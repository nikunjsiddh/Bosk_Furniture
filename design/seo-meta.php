<?php
/* ============================================================
   Bosk Furniture - Central SEO Meta Partial (v2 - advanced)
   ------------------------------------------------------------
   IMPORTANT: This file outputs <head> content ONLY. It does not
   render any visible HTML to the page body, so it cannot change
   the UI in any way.

   Each page should set (BEFORE including):
     $page_title        - Unique page title (required)
     $page_description  - 150-160 char meta description
     $page_keywords     - Optional comma-separated keywords
     $page_canonical    - Optional canonical slug ("about-us" or "/about-us")
                          The .php extension will be auto-stripped.
     $og_image          - Optional OG/Twitter image absolute URL
     $page_robots       - Optional robots directive
     $page_schema       - Optional extra JSON-LD (string, already escaped)
     $page_breadcrumbs  - Optional array of breadcrumbs:
                          [ ['name' => 'Home', 'url' => '/'],
                            ['name' => 'About', 'url' => '/about-us'] ]
   ============================================================ */

// ---- Site-wide canonical brand info (matches live business data) ----
$site_name        = 'Bosk Furniture';
$site_legal_name  = 'Bosk Infracon Private Limited';
$site_url         = 'https://www.boskfurniture.com';
$site_logo        = $site_url . '/images/logo-black.png';
$site_phone1      = '+91-8866647777';
$site_phone2      = '+91-9737817777';
$site_email       = 'boskinfracon@gmail.com';
$site_street      = '5, Aryamaan Complex, Near Meghani Circle, Sir Patanni Road';
$site_locality    = 'Bhavnagar';
$site_region      = 'Gujarat';
$site_postal      = '364001';
$site_country     = 'IN';
$site_founded     = '2019';
$site_price_range = '₹₹';

$default_title    = 'Bosk Furniture - Premium Modular & Custom Furniture in India';
$default_desc     = 'Bosk Furniture offers premium modular kitchens, wardrobes, sofas, beds, dining sets & custom interior furniture across India. Guaranteed quality, Hettich hardware, customised craftsmanship from Bhavnagar, Gujarat.';
$default_keywords = 'modular furniture india, modular kitchen bhavnagar, custom furniture gujarat, wardrobes, sofa set, dining table, bed, interior design furniture, online furniture store india, bosk furniture';
// OG image: prefer the official 1200x630 og-default.jpg if it exists,
// otherwise fall back to a real slider image so social shares never break.
$_og_local_path   = __DIR__ . '/../images/og-default.jpg';
$default_image    = $site_url . (is_file($_og_local_path) ? '/images/og-default.jpg' : '/images/slider/2.jpg');
$twitter_handle   = '@boskfurniture';

/* ------------------------------------------------------------
   Helper: turn any input path into the canonical CLEAN URL form
     - drops .php extension
     - normalises /index or /index.php to /
     - keeps query strings intact
   Wrapped in function_exists() so multiple includes of this file
   never trigger a "Cannot redeclare function" fatal error.
   ------------------------------------------------------------ */
if (!function_exists('bosk_clean_url')) {
    function bosk_clean_url($path) {
        if (!is_string($path) || $path === '') return '/';
        // If full URL passed, just return as-is
        if (strpos($path, 'http') === 0) return $path;
        $path = '/' . ltrim($path, '/');
        // Split off query string
        $query = '';
        if (($q = strpos($path, '?')) !== false) {
            $query = substr($path, $q);
            $path  = substr($path, 0, $q);
        }
        // Strip trailing .php
        $path = preg_replace('/\.php$/i', '', $path);
        // Normalise /index → /
        $path = preg_replace('#/index$#i', '/', $path);
        // Collapse double slashes
        $path = preg_replace('#/+#', '/', $path);
        return $path . $query;
    }
}

// ---- Resolve values with safe fallbacks ----
$_title       = isset($page_title) && $page_title !== '' ? $page_title : $default_title;
$_description = isset($page_description) && $page_description !== '' ? $page_description : $default_desc;
$_keywords    = isset($page_keywords) && $page_keywords !== '' ? $page_keywords : $default_keywords;
$_robots      = isset($page_robots) && $page_robots !== ''
                ? $page_robots
                : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
$_image       = isset($og_image) && $og_image !== '' ? $og_image : $default_image;

// Build canonical URL — always clean (no .php)
if (isset($page_canonical) && $page_canonical !== '') {
    if (strpos($page_canonical, 'http') === 0) {
        $_canonical = $page_canonical;
    } else {
        $_canonical = rtrim($site_url, '/') . bosk_clean_url($page_canonical);
    }
} else {
    $req = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    $_canonical = rtrim($site_url, '/') . bosk_clean_url($req);
}

// Type of OG (page type)
$_og_type = (isset($og_type) && $og_type !== '') ? $og_type : 'website';

// Sanitize for safe output
$e_title       = htmlspecialchars($_title, ENT_QUOTES, 'UTF-8');
$e_description = htmlspecialchars($_description, ENT_QUOTES, 'UTF-8');
$e_keywords    = htmlspecialchars($_keywords, ENT_QUOTES, 'UTF-8');
$e_canonical   = htmlspecialchars($_canonical, ENT_QUOTES, 'UTF-8');
$e_image       = htmlspecialchars($_image, ENT_QUOTES, 'UTF-8');
$e_robots      = htmlspecialchars($_robots, ENT_QUOTES, 'UTF-8');
$e_sitename    = htmlspecialchars($site_name, ENT_QUOTES, 'UTF-8');
$e_ogtype      = htmlspecialchars($_og_type, ENT_QUOTES, 'UTF-8');

// Build BreadcrumbList JSON-LD if provided
$_breadcrumb_json = '';
if (isset($page_breadcrumbs) && is_array($page_breadcrumbs) && count($page_breadcrumbs) > 0) {
    $items = [];
    $pos   = 1;
    foreach ($page_breadcrumbs as $crumb) {
        $cname = isset($crumb['name']) ? $crumb['name'] : '';
        $curl  = isset($crumb['url'])  ? $crumb['url']  : '';
        if ($curl !== '' && strpos($curl, 'http') !== 0) {
            $curl = rtrim($site_url, '/') . bosk_clean_url($curl);
        }
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $pos++,
            'name'     => $cname,
            'item'     => $curl
        ];
    }
    $_breadcrumb_json = '
<script type="application/ld+json">' .
        json_encode([
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items
        ], JSON_UNESCAPED_SLASHES) .
    '</script>';
}
?>
<!-- ===== PRIMARY SEO META ===== -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="format-detection" content="telephone=no">
<title><?php echo $e_title; ?></title>
<meta name="description" content="<?php echo $e_description; ?>">
<meta name="keywords" content="<?php echo $e_keywords; ?>">
<meta name="author" content="<?php echo htmlspecialchars($site_legal_name, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="publisher" content="<?php echo $e_sitename; ?>">
<meta name="robots" content="<?php echo $e_robots; ?>">
<meta name="googlebot" content="<?php echo $e_robots; ?>">
<meta name="bingbot" content="<?php echo $e_robots; ?>">
<meta name="language" content="English">
<meta name="content-language" content="en-IN">
<meta name="distribution" content="global">
<meta name="coverage" content="Worldwide">
<meta name="target" content="all">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="<?php echo $e_sitename; ?>">
<meta name="application-name" content="<?php echo $e_sitename; ?>">
<meta name="geo.region" content="IN-GJ">
<meta name="geo.placename" content="Bhavnagar, Gujarat, India">
<meta name="geo.position" content="21.7645;72.1519">
<meta name="ICBM" content="21.7645, 72.1519">
<meta name="rating" content="general">
<meta name="revisit-after" content="7 days">
<meta name="theme-color" content="#532A1A">
<meta name="msapplication-TileColor" content="#532A1A">
<meta name="msapplication-navbutton-color" content="#532A1A">
<meta name="referrer" content="strict-origin-when-cross-origin">

<!-- ===== SEARCH ENGINE VERIFICATION (replace with your real codes) ===== -->
<!-- <meta name="google-site-verification" content="YOUR_GSC_CODE_HERE"> -->
<!-- <meta name="msvalidate.01" content="YOUR_BING_CODE_HERE"> -->
<!-- <meta name="yandex-verification" content="YOUR_YANDEX_CODE_HERE"> -->
<!-- <meta name="p:domain_verify" content="YOUR_PINTEREST_CODE_HERE"> -->

<!-- ===== CANONICAL & HREFLANG ===== -->
<link rel="canonical" href="<?php echo $e_canonical; ?>">
<link rel="alternate" hreflang="en-IN" href="<?php echo $e_canonical; ?>">
<link rel="alternate" hreflang="en" href="<?php echo $e_canonical; ?>">
<link rel="alternate" hreflang="x-default" href="<?php echo $e_canonical; ?>">

<!-- ===== PERFORMANCE HINTS (preconnect / dns-prefetch) ===== -->
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">

<!-- ===== FAVICONS & PWA MANIFEST ===== -->
<link rel="icon" type="image/png" href="<?php echo $site_url; ?>/images/fevicon.png">
<link rel="shortcut icon" type="image/png" href="<?php echo $site_url; ?>/images/fevicon.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $site_url; ?>/images/fevicon.png">
<link rel="manifest" href="manifest.json">

<!-- ===== OPEN GRAPH ===== -->
<meta property="og:locale" content="en_IN">
<meta property="og:type" content="<?php echo $e_ogtype; ?>">
<meta property="og:site_name" content="<?php echo $e_sitename; ?>">
<meta property="og:title" content="<?php echo $e_title; ?>">
<meta property="og:description" content="<?php echo $e_description; ?>">
<meta property="og:url" content="<?php echo $e_canonical; ?>">
<meta property="og:image" content="<?php echo $e_image; ?>">
<meta property="og:image:secure_url" content="<?php echo $e_image; ?>">
<meta property="og:image:type" content="image/jpeg">
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
<meta name="twitter:image:alt" content="<?php echo $e_title; ?>">
<meta name="twitter:domain" content="boskfurniture.com">
<meta name="twitter:url" content="<?php echo $e_canonical; ?>">

<!-- ===== ORGANIZATION JSON-LD (site-wide) ===== -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "@id": "<?php echo $site_url; ?>/#organization",
  "name": "<?php echo $e_sitename; ?>",
  "legalName": "<?php echo htmlspecialchars($site_legal_name, ENT_QUOTES, 'UTF-8'); ?>",
  "alternateName": ["Bosk Infracon", "Bosk"],
  "url": "<?php echo $site_url; ?>",
  "logo": {
    "@type": "ImageObject",
    "url": "<?php echo $site_logo; ?>",
    "width": 600,
    "height": 200
  },
  "image": "<?php echo $default_image; ?>",
  "description": "<?php echo $e_description; ?>",
  "foundingDate": "<?php echo $site_founded; ?>",
  "telephone": "<?php echo $site_phone1; ?>",
  "email": "<?php echo $site_email; ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "<?php echo htmlspecialchars($site_street, ENT_QUOTES, 'UTF-8'); ?>",
    "addressLocality": "<?php echo $site_locality; ?>",
    "addressRegion": "<?php echo $site_region; ?>",
    "postalCode": "<?php echo $site_postal; ?>",
    "addressCountry": "<?php echo $site_country; ?>"
  },
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "<?php echo $site_phone1; ?>",
    "contactType": "customer service",
    "areaServed": "IN",
    "availableLanguage": ["English","Hindi","Gujarati"]
  },{
    "@type": "ContactPoint",
    "telephone": "<?php echo $site_phone2; ?>",
    "contactType": "sales",
    "areaServed": "IN",
    "availableLanguage": ["English","Hindi","Gujarati"]
  }],
  "sameAs": [
    "https://www.facebook.com/boskfurniture",
    "https://www.instagram.com/boskfurniture",
    "https://twitter.com/boskfurniture",
    "https://www.youtube.com/@boskfurniture",
    "https://www.linkedin.com/company/bosk-infracon"
  ]
}
</script>

<!-- ===== LOCAL BUSINESS (FurnitureStore) JSON-LD ===== -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FurnitureStore",
  "@id": "<?php echo $site_url; ?>/#localbusiness",
  "name": "<?php echo $e_sitename; ?>",
  "image": "<?php echo $default_image; ?>",
  "url": "<?php echo $site_url; ?>",
  "telephone": "<?php echo $site_phone1; ?>",
  "email": "<?php echo $site_email; ?>",
  "priceRange": "<?php echo $site_price_range; ?>",
  "description": "Custom modular kitchens, wardrobes, beds, sofas and complete interior furniture, crafted in Bhavnagar, Gujarat. Guaranteed quality with Hettich hardware.",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "<?php echo htmlspecialchars($site_street, ENT_QUOTES, 'UTF-8'); ?>",
    "addressLocality": "<?php echo $site_locality; ?>",
    "addressRegion": "<?php echo $site_region; ?>",
    "postalCode": "<?php echo $site_postal; ?>",
    "addressCountry": "<?php echo $site_country; ?>"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 21.7645,
    "longitude": 72.1519
  },
  "areaServed": [
    {"@type":"Country","name":"India"},
    {"@type":"State","name":"Gujarat"},
    {"@type":"City","name":"Bhavnagar"},
    {"@type":"City","name":"Rajkot"},
    {"@type":"City","name":"Ahmedabad"},
    {"@type":"City","name":"Vadodara"},
    {"@type":"City","name":"Jamnagar"},
    {"@type":"City","name":"Junagadh"},
    {"@type":"City","name":"Amreli"}
  ],
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    "opens": "10:00",
    "closes": "20:00"
  },
  "currenciesAccepted": "INR",
  "paymentAccepted": "Cash, Credit Card, Debit Card, UPI, Bank Transfer"
}
</script>

<!-- ===== WEBSITE JSON-LD (SearchAction) ===== -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "@id": "<?php echo $site_url; ?>/#website",
  "name": "<?php echo $e_sitename; ?>",
  "url": "<?php echo $site_url; ?>",
  "publisher": { "@id": "<?php echo $site_url; ?>/#organization" },
  "inLanguage": "en-IN",
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "<?php echo $site_url; ?>/shop?astringdata2={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  }
}
</script>

<!-- ===== SITE NAVIGATION JSON-LD ===== -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SiteNavigationElement",
  "name": ["Home","Shop","About Us","Blog","How It Works","Contact Us"],
  "url": [
    "<?php echo $site_url; ?>/",
    "<?php echo $site_url; ?>/all_products",
    "<?php echo $site_url; ?>/about-us",
    "<?php echo $site_url; ?>/blog-full-list",
    "<?php echo $site_url; ?>/design-order-process",
    "<?php echo $site_url; ?>/contact"
  ]
}
</script>

<?php echo $_breadcrumb_json; ?>
<?php if (isset($page_schema) && $page_schema !== '') { echo $page_schema; } ?>
<!-- ===== END SEO META ===== -->
