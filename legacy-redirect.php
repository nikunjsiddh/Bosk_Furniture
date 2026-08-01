<?php
/* ============================================================
   Bosk Furniture — legacy parameter URL -> slug URL (301).

   Reached only via the .htaccess rewrite for URLs still carrying
   ?astringdata / ?astringdata2. Resolves the row, then sends a single
   permanent redirect to the canonical slug URL.

   The rewrite is internal, so REQUEST_URI still holds the ORIGINAL
   path — that is what distinguishes a blog id from a product id,
   rather than guessing from the encoding.
   ============================================================ */

include_once __DIR__ . '/connect.php';
require_once __DIR__ . '/inc/urls.php';

$to   = null;
$path = strtok($_SERVER['REQUEST_URI'], '?');
$raw  = isset($_GET['astringdata']) ? $_GET['astringdata'] : null;

/* Legacy ids arrive either plain ("18") or base64-encoded ("MQ=="). */
$legacy_id = 0;
if ($raw !== null) {
    if (ctype_digit((string)$raw)) {
        $legacy_id = (int)$raw;
    } else {
        $dec = base64_decode((string)$raw, true);
        if ($dec !== false && ctype_digit($dec)) {
            $legacy_id = (int)$dec;
        }
    }
}

// /project-details?astringdata=<id>  ->  /project-<slug>
// Checked before the blog branch, because "project-details" also contains
// the substring "details".
if ($legacy_id > 0 && strpos($path, 'project-details') !== false) {
    if ($slug = bosk_slug_for($con, 'projects', $legacy_id)) {
        $to = url_project($slug);
    }
}

// /details?astringdata=<id>  ->  /blog-<slug>
if ($to === null && $legacy_id > 0 && strpos($path, 'details') !== false && strpos($path, 'project-details') === false) {
    if ($slug = bosk_slug_for($con, 'blog', $legacy_id)) {
        $to = url_blog($slug);
    }
}

// /product?astringdata=<id>  ->  /product-<slug>
if ($to === null && $legacy_id > 0 && strpos($path, 'product') !== false) {
    if ($slug = bosk_slug_for($con, 'products', $legacy_id)) {
        $to = url_product($slug);
    }
}

// /shop?astringdata2=<Category Name>  ->  /<category-slug>
// Matched on the DISPLAY NAME, because that is what legacy URLs carry.
if ($to === null && isset($_GET['astringdata2'])) {
    $name = urldecode(str_replace('+', ' ', (string)$_GET['astringdata2']));
    if (trim($name) !== '') {
        $to = url_category(bosk_category_slug($con, $name));
    }
}

// Unresolvable legacy URL falls back to the shop rather than 404ing —
// these are live indexed URLs and must never dead-end.
header('Location: ' . bosk_base_path() . ($to !== null ? $to : 'all_products'), true, 301);
exit;
