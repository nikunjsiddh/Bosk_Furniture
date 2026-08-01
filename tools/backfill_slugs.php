<?php
/* ============================================================
   Bosk Furniture — slug + index-hygiene migration (CLI ONLY)

   Idempotent. Safe to re-run. Does three things:
     1. Adds `slug` to products / category / blog if missing.
     2. Backfills slugs (curated where SEO value depends on it,
        auto-slugified from the name otherwise).
     3. Adds `is_demo` to products and flags the placeholder rows
        so they can be de-indexed without deleting them (test
        orders may still reference them).

   Run:  php tools/backfill_slugs.php
   ============================================================ */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("This migration is CLI-only.\n");
}

require_once __DIR__ . '/../connect.php';

function bosk_slugify(string $s): string {
    $s = strtolower(trim($s));
    $s = preg_replace('~[^a-z0-9]+~', '-', $s);
    return trim($s, '-');
}

function col_exists($con, string $table, string $col): bool {
    $t = mysqli_real_escape_string($con, $table);
    $c = mysqli_real_escape_string($con, $col);
    $q = mysqli_query($con, "SHOW COLUMNS FROM `$t` LIKE '$c'");
    return $q && mysqli_num_rows($q) > 0;
}

function run($con, string $sql): void {
    if (!mysqli_query($con, $sql)) {
        echo "  [!] " . mysqli_error($con) . "\n";
    }
}

/* Ensure a slug is unique within its table by appending -2, -3, ... */
function unique_slug($con, string $table, string $base, int $id): string {
    $base = $base !== '' ? $base : 'item-' . $id;
    $slug = $base;
    $n    = 2;
    while (true) {
        $s  = mysqli_real_escape_string($con, $slug);
        $q  = mysqli_query($con, "SELECT id FROM `$table` WHERE slug='$s' AND id<>" . (int)$id . " LIMIT 1");
        if (!$q || mysqli_num_rows($q) === 0) return $slug;
        $slug = $base . '-' . $n++;
    }
}

echo "== Bosk slug migration ==\n";

// ---- 1. Columns ---------------------------------------------------------
foreach ([['products', 'pname'], ['category', 'name'], ['blog', 'blog_title'], ['projects', 'project_name']] as [$table, $after]) {
    if (!col_exists($con, $table, 'slug')) {
        run($con, "ALTER TABLE `$table` ADD COLUMN `slug` VARCHAR(190) NULL AFTER `$after`");
        echo "added $table.slug\n";
    }
}
if (!col_exists($con, 'products', 'is_demo')) {
    run($con, "ALTER TABLE `products` ADD COLUMN `is_demo` TINYINT(1) NOT NULL DEFAULT 0");
    echo "added products.is_demo\n";
}

// ---- 2. Categories ------------------------------------------------------
// Slugs are chosen for search volume, not to mirror the display name.
// Display names on the site are never changed by this script.
$category_slugs = [
    'sofa'                         => 'sofas',
    'luscious wardrobes'           => 'wardrobes',
    'comfy beds with full storage' => 'storage-beds',
    'entertaining tv units'        => 'tv-units',
    'modular kitchens'             => 'modular-kitchens',
    'other comforts'               => 'other-comforts',
];
$q = mysqli_query($con, "SELECT id, name FROM category");
while ($r = mysqli_fetch_assoc($q)) {
    $key  = strtolower(trim($r['name']));
    $base = $category_slugs[$key] ?? bosk_slugify($r['name']);
    $slug = unique_slug($con, 'category', $base, (int)$r['id']);
    run($con, "UPDATE category SET slug='" . mysqli_real_escape_string($con, $slug) . "' WHERE id=" . (int)$r['id']);
    echo "category #{$r['id']} {$r['name']} -> $slug\n";
}

// ---- 3. Blog ------------------------------------------------------------
// Matched on title, not id — ids differ between environments.
$blog_slugs = [
    'modular kitchen cost'      => 'modular-kitchen-cost-gujarat',
    'marine plywood'            => 'marine-plywood-vs-bwr-vs-mr',
    'custom vs readymade'       => 'custom-vs-readymade-furniture',
];
$q = mysqli_query($con, "SELECT id, blog_title FROM blog");
while ($r = mysqli_fetch_assoc($q)) {
    $title = strtolower($r['blog_title']);
    $base  = bosk_slugify($r['blog_title']);
    foreach ($blog_slugs as $needle => $curated) {
        if (strpos($title, $needle) !== false) { $base = $curated; break; }
    }
    $slug = unique_slug($con, 'blog', $base, (int)$r['id']);
    run($con, "UPDATE blog SET slug='" . mysqli_real_escape_string($con, $slug) . "' WHERE id=" . (int)$r['id']);
    echo "blog #{$r['id']} -> $slug\n";
}

// ---- 4. Products --------------------------------------------------------
$q = mysqli_query($con, "SELECT id, pname FROM products");
while ($r = mysqli_fetch_assoc($q)) {
    $slug = unique_slug($con, 'products', bosk_slugify($r['pname']), (int)$r['id']);
    run($con, "UPDATE products SET slug='" . mysqli_real_escape_string($con, $slug) . "' WHERE id=" . (int)$r['id']);
    echo "product #{$r['id']} {$r['pname']} -> $slug\n";
}

// ---- 4b. Projects -------------------------------------------------------
$q = mysqli_query($con, "SELECT id, project_name FROM projects");
while ($r = mysqli_fetch_assoc($q)) {
    $slug = unique_slug($con, 'projects', bosk_slugify($r['project_name']), (int)$r['id']);
    run($con, "UPDATE projects SET slug='" . mysqli_real_escape_string($con, $slug) . "' WHERE id=" . (int)$r['id']);
    echo "project #{$r['id']} {$r['project_name']} -> $slug\n";
}

// ---- 5. Flag placeholder catalogue rows ---------------------------------
// These are seed/demo rows that predate the real catalogue. Flagged rather
// than deleted so existing test orders keep resolving.
run($con, "UPDATE products SET is_demo=1
           WHERE pname REGEXP '^Product[[:space:]]*[0-9]+$'
              OR pname IN ('Kylie','Kylie Terry','Colorado Gross')");
$demo = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM products WHERE is_demo=1"));
echo "flagged {$demo[0]} demo product(s)\n";

// ---- 6. Constraints -----------------------------------------------------
// Applied last, once every row is guaranteed to hold a unique non-null slug.
foreach ([['products', 'uk_products_slug'], ['category', 'uk_category_slug'], ['blog', 'uk_blog_slug'], ['projects', 'uk_projects_slug']] as [$table, $key]) {
    $q = mysqli_query($con, "SHOW INDEX FROM `$table` WHERE Key_name='$key'");
    if ($q && mysqli_num_rows($q) === 0) {
        run($con, "ALTER TABLE `$table` MODIFY `slug` VARCHAR(190) NOT NULL, ADD UNIQUE KEY `$key` (`slug`)");
        echo "indexed $table.slug\n";
    }
}

echo "== done ==\n";
