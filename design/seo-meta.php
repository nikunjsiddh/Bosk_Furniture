<?php
/* ============================================================
   Bosk Furniture - Central SEO Meta Partial
   ------------------------------------------------------------
   Include this in <head> of every page.
   Each page should set the following BEFORE including:
     $page_title        - Unique page title (required)
     $page_description  - 150-160 char meta description
     $page_keywords     - Optional comma-separated keywords
     $page_canonical    - Optional canonical URL slug (e.g. "about-us.php")
     $og_image          - Optional OG/Twitter image path
     $page_robots       - Optional robots directive (default: index, follow)
     $page_schema       - Optional extra JSON-LD as string
   ============================================================ */

// ---- Site-wide defaults (Bosk Furniture - India) ----
$site_name        = 'Bosk Furniture';
$site_url         = 'https://www.boskfurniture.com';
$default_title    = 'Bosk Furniture - Premium Modular & Custom Furniture in India';
$default_desc     = 'Bosk Furniture offers premium modular kitchens, wardrobes, sofas, beds, dining sets & custom interior furniture across India. Shop online for guaranteed quality home & office furniture.';
$default_keywords = 'furniture india, modular furniture, modular kitchen, wardrobes, sofa set, dining table, bed, custom furniture, interior design furniture, online furniture store india, bosk furniture';
$default_image    = $site_url . '/images/og-default.jpg';
$twitter_handle   = '@boskfurniture';

// ---- Resolve values with safe fallbacks ----
$_title       = isset($page_title) && $page_title !== '' ? $page_title : $default_title;
$_description = isset($page_description) && $page_description !== '' ? $page_description : $default_desc;
$_keywords    = isset($page_keywords) && $page_keywords !== '' ? $page_keywords : $default_keywords;
$_robots      = isset($page_robots) && $page_robots !== '' ? $page_robots : 'index, follow, max-image-preview:large';
$_image       = isset($og_image) && $og_image !== '' ? $og_image : $default_image;

// Compute canonical URL
if (isset($page_canonical) && $page_canonical !== '') {
    $_canonical = (strpos($page_canonical, 'http') === 0)
        ? $page_canonical
        : rtrim($site_url, '/') . '/' . ltrim($page_canonical, '/');
} else {
    // Auto-detect from REQUEST_URI
    $req = isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
    $_canonical = rtrim($site_url, '/') . $req;
}

// Sanitize for safe output
$e_title       = htmlspecialchars($_title, ENT_QUOTES, 'UTF-8');
$e_description = htmlspecialchars($_description, ENT_QUOTES, 'UTF-8');
$e_keywords    = htmlspecialchars($_keywords, ENT_QUOTES, 'UTF-8');
$e_canonical   = htmlspecialchars($_canonical, ENT_QUOTES, 'UTF-8');
$e_image       = htmlspecialchars($_image, ENT_QUOTES, 'UTF-8');
$e_robots      = htmlspecialchars($_robots, ENT_QUOTES, 'UTF-8');
$e_sitename    = htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8');
?>
<!-- ===== PRIMARY SEO META ===== -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title><?php echo $e_title; ?></title>
<meta name="description" content="<?php echo $e_description; ?>">
<meta name="keywords" content="<?php echo $e_keywords; ?>">
<meta name="author" content="Bosk Furniture">
<meta name="robots" content="<?php echo $e_robots; ?>">
<meta name="googlebot" content="<?php echo $e_robots; ?>">
<meta name="language" content="English">
<meta name="geo.region" content="IN">
<meta name="geo.placename" content="India">
<meta name="rating" content="general">
<meta name="revisit-after" content="7 days">
<meta name="theme-color" content="#532A1A">

<!-- ===== CANONICAL ===== -->
<link rel="canonical" href="<?php echo $e_canonical; ?>">

<!-- ===== FAVICONS ===== -->
<link rel="icon" type="image/png" href="images/fevicon.png">
<link rel="shortcut icon" type="image/png" href="images/fevicon.png">
<link rel="apple-touch-icon" href="images/fevicon.png">

<!-- ===== OPEN GRAPH ===== -->
<meta property="og:locale" content="en_IN">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?php echo $e_sitename; ?>">
<meta property="og:title" content="<?php echo $e_title; ?>">
<meta property="og:description" content="<?php echo $e_description; ?>">
<meta property="og:url" content="<?php echo $e_canonical; ?>">
<meta property="og:image" content="<?php echo $e_image; ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?php echo $e_title; ?>">

<!-- ===== TWITTER CARD ===== -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="<?php echo $twitter_handle; ?>">
<meta name="twitter:creator" content="<?php echo $twitter_handle; ?>">
<meta name="twitter:title" content="<?php echo $e_title; ?>">
<meta name="twitter:description" content="<?php echo $e_description; ?>">
<meta name="twitter:image" content="<?php echo $e_image; ?>">

<!-- ===== ORGANIZATION JSON-LD (site-wide) ===== -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Bosk Furniture",
  "url": "<?php echo $site_url; ?>",
  "logo": "<?php echo $site_url; ?>/images/fevicon.png",
  "description": "<?php echo $e_description; ?>",
  "address": {
    "@type": "PostalAddress",
    "addressCountry": "IN"
  },
  "sameAs": [
    "https://www.facebook.com/boskfurniture",
    "https://www.instagram.com/boskfurniture",
    "https://twitter.com/boskfurniture"
  ]
}
</script>

<!-- ===== WEBSITE JSON-LD (SearchAction) ===== -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Bosk Furniture",
  "url": "<?php echo $site_url; ?>",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "<?php echo $site_url; ?>/shop.php?astringdata2={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>

<?php if (isset($page_schema) && $page_schema !== '') { echo $page_schema; } ?>
<!-- ===== END SEO META ===== -->
