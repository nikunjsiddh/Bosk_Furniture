<?php
/* ============================================================
   Bosk Furniture - Dynamic Sitemap Generator
   ------------------------------------------------------------
   Generates a complete sitemap.xml that includes:
     - All static pages (home, about, contact, etc.)
     - All products from `products` table
     - All categories from `category` table
     - All projects from `projects` table
     - All blog posts from `blog` table

   Usage:
     1) Open https://www.boskfurniture.com/sitemap-generator.php in browser
        (or run via CLI: php sitemap-generator.php)
     2) It will overwrite /sitemap.xml with the fresh content
     3) Re-submit sitemap in Google Search Console

   Schedule this to run weekly via cron:
     0 3 * * 0 /usr/bin/php /path/to/htdocs/bosk/sitemap-generator.php
   ============================================================ */

include_once __DIR__ . '/connect.php';

$site_url = 'https://www.boskfurniture.com';
$today    = date('Y-m-d');

$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . "\n";
$xml .= '        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n\n";

function add_url(&$xml, $loc, $priority = '0.7', $changefreq = 'weekly', $lastmod = null, $image_loc = null, $image_title = null) {
    $lastmod = $lastmod ?: date('Y-m-d');
    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars($loc, ENT_QUOTES, 'UTF-8') . "</loc>\n";
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

// ---- Static pages ----
$static = [
    ['/',                                  '1.0',  'daily'],
    ['/about-us.php',                      '0.85', 'monthly'],
    ['/contact.php',                       '0.85', 'monthly'],
    ['/all_products.php',                  '0.95', 'daily'],
    ['/all-services.php',                  '0.85', 'monthly'],
    ['/projects.php',                      '0.8',  'weekly'],
    ['/blog-full-list.php',                '0.8',  'weekly'],
    ['/testimonial.php',                   '0.7',  'monthly'],
    ['/ex-customize_furniture.php',        '0.85', 'monthly'],
    ['/design-order-process.php',          '0.75', 'monthly'],
    ['/warranty.php',                      '0.5',  'monthly'],
    ['/warranty_policy.php',               '0.4',  'monthly'],
    ['/hardware_warranty.php',             '0.4',  'monthly'],
    ['/care_and_maintenance_policy.php',   '0.4',  'monthly'],
];
foreach ($static as $row) {
    add_url($xml, $site_url . $row[0], $row[1], $row[2], $today);
}

// ---- Products ----
if (isset($con) && $con) {
    $q = @mysqli_query($con, "SELECT id, pname, img1 FROM products ORDER BY id DESC");
    if ($q) {
        while ($r = mysqli_fetch_assoc($q)) {
            $loc = $site_url . '/product.php?astringdata=' . urlencode(base64_encode($r['id']));
            $img = !empty($r['img1']) ? $site_url . '/Admin/product_image/' . $r['img1'] : null;
            add_url($xml, $loc, '0.9', 'weekly', $today, $img, $r['pname']);
        }
    }

    // ---- Categories (shop.php) ----
    $q2 = @mysqli_query($con, "SELECT DISTINCT pcategory FROM products WHERE pcategory IS NOT NULL AND pcategory != ''");
    if ($q2) {
        while ($r = mysqli_fetch_assoc($q2)) {
            $loc = $site_url . '/shop.php?astringdata2=' . urlencode($r['pcategory']);
            add_url($xml, $loc, '0.85', 'weekly', $today);
        }
    }

    // ---- Projects ----
    $q3 = @mysqli_query($con, "SELECT id, project_name, img1 FROM projects ORDER BY id DESC");
    if ($q3) {
        while ($r = mysqli_fetch_assoc($q3)) {
            $loc = $site_url . '/project-details.php?astringdata=' . urlencode(base64_encode($r['id']));
            $img = !empty($r['img1']) ? $site_url . '/Admin/project_image/' . $r['img1'] : null;
            add_url($xml, $loc, '0.7', 'monthly', $today, $img, $r['project_name']);
        }
    }

    // ---- Blog ----
    $q4 = @mysqli_query($con, "SELECT id, blog_title, img FROM blog ORDER BY id DESC");
    if ($q4) {
        while ($r = mysqli_fetch_assoc($q4)) {
            $loc = $site_url . '/details.php?astringdata=' . urlencode(base64_encode($r['id']));
            $img = !empty($r['img']) ? $site_url . '/Admin/blog_image/' . $r['img'] : null;
            add_url($xml, $loc, '0.7', 'monthly', $today, $img, $r['blog_title']);
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
