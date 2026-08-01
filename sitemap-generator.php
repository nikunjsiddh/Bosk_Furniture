<?php
/* ============================================================
   Bosk Furniture - Dynamic Sitemap Generator (v2 - clean URLs)
   ------------------------------------------------------------
   Generates a complete sitemap.xml that includes:
     - All static pages (home, about, contact, etc.)
     - All products from `products` table
     - All categories from `category` table (or distinct from products)
     - All projects from `projects` table
     - All blog posts from `blog` table

   All URLs emitted in CLEAN form (no .php extension) so they
   match the .htaccess clean-URL rewrite rules.

   Usage:
     - Browser: https://www.boskfurniture.com/sitemap-generator.php
     - CLI:     php sitemap-generator.php
     - Cron:    0 3 * * 0  /usr/bin/php /var/www/.../sitemap-generator.php
   ============================================================ */

include_once __DIR__ . '/connect.php';
require_once __DIR__ . '/inc/urls.php';

$site_url = 'https://www.boskfurniture.com';
$today    = date('Y-m-d');

$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
$xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"' . "\n";
$xml .= '        xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n\n";

function add_url(&$xml, $loc, $priority = '0.7', $changefreq = 'weekly', $lastmod = null, $image_loc = null, $image_title = null, $hreflang_en_in = true) {
    // Safety net: never emit the same <loc> twice in one sitemap.
    static $seen_locs = array();
    if (isset($seen_locs[$loc])) { return; }
    $seen_locs[$loc] = true;

    $lastmod = $lastmod ?: date('Y-m-d');
    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars($loc, ENT_QUOTES, 'UTF-8') . "</loc>\n";
    if ($hreflang_en_in) {
        $xml .= '    <xhtml:link rel="alternate" hreflang="en-IN" href="' . htmlspecialchars($loc, ENT_QUOTES, 'UTF-8') . '"/>' . "\n";
    }
    $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
    $xml .= "    <changefreq>" . $changefreq . "</changefreq>\n";
    $xml .= "    <priority>" . $priority . "</priority>\n";
    if ($image_loc) {
        $xml .= "    <image:image>\n";
        $xml .= "      <image:loc>" . htmlspecialchars($image_loc, ENT_QUOTES, 'UTF-8') . "</image:loc>\n";
        if ($image_title) {
            $xml .= "      <image:title>" . htmlspecialchars($image_title, ENT_QUOTES, 'UTF-8') . "</image:title>\n";
        }
        $xml .= "    </image:image>\n";
    }
    $xml .= "  </url>\n\n";
}

// ---- Static pages (clean URLs) ----
$static = [
    ['/',                                  '1.0',  'daily'],
    ['/about-us',                          '0.85', 'monthly'],
    ['/contact',                           '0.85', 'monthly'],
    ['/all_products',                      '0.95', 'daily'],
    ['/all-services',                      '0.85', 'monthly'],
    ['/projects',                          '0.8',  'weekly'],
    ['/blog',                              '0.8',  'weekly'],
    ['/testimonial',                       '0.7',  'monthly'],
    ['/ex-customize_furniture',            '0.85', 'monthly'],
    ['/design-order-process',              '0.75', 'monthly'],
    ['/warranty',                          '0.5',  'monthly'],
    ['/warranty_policy',                   '0.4',  'monthly'],
    ['/hardware_warranty',                 '0.4',  'monthly'],
    ['/care_and_maintenance_policy',       '0.4',  'monthly'],
];
foreach ($static as $row) {
    add_url($xml, $site_url . $row[0], $row[1], $row[2], $today);
}

// ---- Dynamic content from DB ----
if (isset($con) && $con) {
    // Products — demo/placeholder rows are excluded so they never get indexed
    // as the real BOSK catalogue.
    $q = @mysqli_query($con, "SELECT id, pname, slug, img1 FROM products WHERE publish_date <= NOW() AND is_demo = 0 ORDER BY id DESC");
    if ($q) {
        while ($r = mysqli_fetch_assoc($q)) {
            if (empty($r['slug'])) { continue; }
            $loc = $site_url . '/' . url_product($r['slug']);
            $img = !empty($r['img1']) ? $site_url . '/admin/product_image/' . $r['img1'] : null;
            add_url($xml, $loc, '0.9', 'weekly', $today, $img, $r['pname']);
        }
    }

    // Categories — a category with no live products is noindex on the page
    // itself, so listing it here would contradict that.
    $q2 = @mysqli_query($con,
        "SELECT c.slug, COUNT(p.id) AS cnt
           FROM category c
           LEFT JOIN products p
             ON TRIM(LOWER(c.name)) = TRIM(LOWER(p.pcategory))
            AND p.publish_date <= NOW()
            AND p.is_demo = 0
          GROUP BY c.id, c.slug
          HAVING cnt > 0");
    if ($q2) {
        while ($r = mysqli_fetch_assoc($q2)) {
            if (empty($r['slug'])) { continue; }
            add_url($xml, $site_url . '/' . url_category($r['slug']), '0.85', 'weekly', $today);
        }
    }

    // Projects
    $q3 = @mysqli_query($con, "SELECT id, project_name, slug, img1 FROM projects ORDER BY id DESC");
    if ($q3) {
        while ($r = mysqli_fetch_assoc($q3)) {
            if (empty($r['slug'])) { continue; }
            $loc = $site_url . '/' . url_project($r['slug']);
            $img = !empty($r['img1']) ? $site_url . '/admin/project_image/' . $r['img1'] : null;
            add_url($xml, $loc, '0.7', 'monthly', $today, $img, $r['project_name']);
        }
    }

    // Blog — real <lastmod> from the publish date rather than "today".
    $q4 = @mysqli_query($con, "SELECT id, blog_title, slug, img, blog_date FROM blog WHERE blog_date <= NOW() ORDER BY id DESC");
    if ($q4) {
        while ($r = mysqli_fetch_assoc($q4)) {
            if (empty($r['slug'])) { continue; }
            $loc  = $site_url . '/' . url_blog($r['slug']);
            $img  = !empty($r['img']) ? $site_url . '/admin/blog_image/' . $r['img'] : null;
            $lmod = !empty($r['blog_date']) ? date('Y-m-d', strtotime($r['blog_date'])) : $today;
            add_url($xml, $loc, '0.7', 'monthly', $lmod, $img, $r['blog_title']);
        }
    }
}

$xml .= '</urlset>' . "\n";

// Save to sitemap.xml
$result = @file_put_contents(__DIR__ . '/sitemap.xml', $xml);

// Output
if (PHP_SAPI === 'cli') {
    echo ($result !== false ? "[OK] sitemap.xml regenerated ($result bytes)\n" : "[ERROR] Could not write sitemap.xml\n");
} else {
    header('Content-Type: text/plain; charset=UTF-8');
    if ($result !== false) {
        echo "sitemap.xml regenerated successfully ($result bytes).\n";
        echo "View it at: " . $site_url . "/sitemap.xml\n";
        echo "Re-submit it in Google Search Console.\n";
    } else {
        http_response_code(500);
        echo "ERROR: Could not write sitemap.xml. Check file permissions.\n";
    }
}
