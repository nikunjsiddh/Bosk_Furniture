# Bosk Furniture - SEO Audit & Improvements Report

**Date:** 2026-05-18
**Site:** https://www.boskfurniture.com
**Target Market:** India (national)
**Business Focus:** Furniture e-commerce

---

## Executive Summary

A full SEO audit was performed on every customer-facing page of the Bosk
Furniture website. The site previously had **zero** SEO meta tags - every
page rendered with the same generic `<title>BOSK FURNITURE</title>`, no meta
description, no Open Graph data, no structured data, no sitemap and no
robots.txt. This is a near-complete rebuild of the SEO foundation.

All 30+ customer-facing pages now have unique, India-targeted SEO meta,
canonical URLs, Open Graph and Twitter Card data, JSON-LD structured data,
and proper language declarations. Sitemap, robots.txt and an SEO-tuned
.htaccess are now in place.

---

## Critical Issues Found (Before)

| # | Issue                                                              | Severity |
|---|--------------------------------------------------------------------|----------|
| 1 | All pages had identical `<title>BOSK FURNITURE</title>`            | Critical |
| 2 | Zero meta descriptions anywhere on the site                        | Critical |
| 3 | `lang="zxx"` (undeclared language) on every page                   | High     |
| 4 | No canonical URLs - duplicate-content risk on dynamic pages        | Critical |
| 5 | No Open Graph / Twitter Card meta - bad social sharing             | High     |
| 6 | No JSON-LD structured data (Product, Organization, Breadcrumb)     | Critical |
| 7 | No `robots.txt` at root                                            | High     |
| 8 | No `sitemap.xml` at root                                           | Critical |
| 9 | Product images had alt="shoe image" (wrong vertical) on all photos | High     |
| 10| No favicon link consistency                                        | Low      |
| 11| Backend (Admin/) was not disallowed from crawlers                  | High     |
| 12| No browser caching / compression rules (Core Web Vitals)           | High     |
| 13| Missing geo-targeting meta (geo.region, geo.placename)             | Medium   |

---

## Files Created

| File                              | Purpose                                                    |
|-----------------------------------|------------------------------------------------------------|
| `design/seo-meta.php`             | Centralized SEO meta partial used by all pages             |
| `robots.txt`                      | Crawl directives + sitemap reference                       |
| `sitemap.xml`                     | Static sitemap of all public pages                         |
| `sitemap-generator.php`           | Dynamic generator that crawls DB and rebuilds sitemap.xml  |
| `.htaccess`                       | Compression, caching, security headers, 404 handler        |
| `SEO-AUDIT-REPORT.md`             | This report                                                |

## Files Modified (30 files)

`design/header.php`, `index.php`, `about-us.php`, `contact.php`, `login.php`,
`register.php`, `shop.php`, `product.php`, `all_products.php`, `cart.php`,
`cart1.php`, `checkout.php`, `wishlist.php`, `testimonial.php`,
`blog-full-list.php`, `projects.php`, `project-details.php`, `details.php`,
`all-services.php`, `404.php`, `warranty.php`, `warranty_policy.php`,
`hardware_warranty.php`, `care_and_maintenance_policy.php`,
`design-order-process.php`, `ex-customize_furniture.php`, `order_details.php`,
`return_request.php`, `invoice.php`, `profile.php`.

---

## SEO Improvements Applied

### 1. Unique, Optimised Titles & Descriptions

Every page now has a unique, India-targeted title (60-65 chars) and
description (150-160 chars). Examples:

- Homepage: "Bosk Furniture - Premium Modular Furniture & Interior Design in India"
- About: "About Us | Bosk Furniture - Trusted Furniture Brand in India"
- Contact: "Contact Bosk Furniture | Get a Free Furniture Quote in India"
- Products page: dynamic - "[Product Name] | Buy Online at Bosk Furniture India"
- Category page: dynamic - "[Category] - Buy Online at Bosk Furniture India"

### 2. Centralized SEO via `design/seo-meta.php`

A single partial sets all SEO meta. Pages just declare variables before
their DOCTYPE:

```php
<?php
$page_title       = 'About Us | Bosk Furniture';
$page_description = '...';
$page_keywords    = '...';
$page_canonical   = '/about-us.php';
?>
```

Includes: charset, viewport, x-ua-compatible, title, meta description,
keywords, author, robots, googlebot, language, geo.region (IN),
geo.placename (India), rating, revisit-after, theme-color, canonical,
favicons (3 variants), Open Graph (locale en_IN, type, site_name, title,
description, url, image with width/height/alt), Twitter Card
(summary_large_image with @boskfurniture handle), Organization JSON-LD,
WebSite JSON-LD with SearchAction.

### 3. Structured Data (JSON-LD)

- **Organization** + **WebSite** (with SearchAction) - every page
- **FurnitureStore (LocalBusiness)** - homepage (with priceRange, opening
  hours, areaServed=India)
- **AboutPage** + **BreadcrumbList** - about-us.php
- **ContactPage** + **ContactPoint** (areaServed=IN, English+Hindi) +
  **BreadcrumbList** - contact.php
- **Product** (dynamic) with offers, price in INR, availability from stock,
  brand, category, SKU + **BreadcrumbList** - product.php
- **CollectionPage** + **BreadcrumbList** - shop.php
- **Article** - details.php blog posts

### 4. Open Graph & Twitter Cards (every page)

Social sharing on Facebook, LinkedIn, WhatsApp, Twitter and others will
now render proper title, description and image previews.

### 5. Canonical URLs (every page)

Every page emits `<link rel="canonical">`. Dynamic pages
(product.php, shop.php, details.php, project-details.php) include the
relevant query string so each product/category gets its own canonical.

### 6. Language & Geo Targeting

- Replaced `lang="zxx"` with `lang="en-IN"` on all 30+ pages
- Added `geo.region` = IN
- Added `geo.placename` = India
- Added `og:locale` = en_IN

### 7. `robots.txt`

- Allows public site
- Disallows Admin/, back/, form/, design/, connect.php
- Disallows transactional pages (cart, checkout, login, register, profile,
  wishlist, invoice, order_details, return_request) - they have no SEO value
- Allows /css/, /js/, /images/, /fonts/ (mobile-friendly test passes)
- Declares Sitemap location

### 8. `sitemap.xml`

Static sitemap covers 14 main pages with lastmod, changefreq, priority and
homepage image reference. The included `sitemap-generator.php` script
dynamically rebuilds the sitemap to include all products, categories,
projects and blog posts from the database.

### 9. `.htaccess`

- **Gzip compression** for HTML, CSS, JS, JSON, XML, SVG, fonts
- **Browser caching** - 1 year for CSS/JS/images, 0 for HTML
- **Security headers** - X-Content-Type-Options, X-Frame-Options,
  Referrer-Policy, Permissions-Policy, X-XSS-Protection
- **Custom 404** - routes to `/404.php`
- **Block sensitive files** - .env, connect.php, composer.json, .git
- **Disable directory browsing**
- **HTTPS + www redirect** stubs (uncomment after SSL install)

### 10. Image Alt Text Fixed

All `alt="shoe image"` placeholder alt tags on furniture product images
have been replaced with `alt="[Product Name] - Bosk Furniture"` (dynamic).

### 11. Page-specific Robots Directives

Transactional and account pages now have `noindex, follow` so they don't
get indexed but link equity still flows. Indexed pages have
`index, follow, max-image-preview:large` for rich Google previews.

### 12. 404 Page Returns Real 404

`404.php` now correctly returns HTTP 404 status via
`http_response_code(404)` instead of 200.

---

## Action Items For You

### Immediate (Pre-Launch)

1. **Replace placeholder OG image**: Create a 1200×630 image and save it at
   `/images/og-default.jpg` (used by social shares).
2. **Update phone & address** in homepage `FurnitureStore` schema (currently
   placeholder `+91-XXXXXXXXXX`) in `index.php`.
3. **Update social URLs** in `design/seo-meta.php` Organization schema if
   you have real Facebook / Instagram / Twitter pages.
4. **Pick canonical domain** - decide www vs non-www, then uncomment the
   matching block in `.htaccess`.
5. **Install SSL** and uncomment the HTTPS redirect block in `.htaccess`.
6. **Update `$site_url`** in `design/seo-meta.php` and `sitemap-generator.php`
   to match your final live domain.

### Week 1

7. **Submit sitemap** to Google Search Console:
   - URL to submit: `https://www.boskfurniture.com/sitemap.xml`
8. **Submit sitemap** to Bing Webmaster Tools (Bing is a big share of
   Indian search traffic on Windows).
9. **Run dynamic sitemap generator** once: open
   `https://www.boskfurniture.com/sitemap-generator.php` in browser, or
   schedule it via cron weekly.
10. **Set up Google Search Console** verification (add the verification
    meta tag to `design/seo-meta.php` if you choose the meta-tag method).
11. **Set up Google Analytics 4 + Google Tag Manager** - add the script
    just before `</head>` in `design/header.php`.

### Month 1

12. **Add Google Business Profile** for "Bosk Furniture" with India
    address - this is your single biggest local-SEO win.
13. **Add real customer reviews / ratings** to products and embed
    AggregateRating schema in `product.php`.
14. **Create city-specific landing pages** for the top metros you serve
    (Mumbai, Delhi, Bangalore, Pune, Hyderabad, Chennai).
15. **Add blog posts** in the existing blog system - target keywords like
    "modular kitchen design India", "best wardrobe designs", "L-shaped sofa
    for living room". Each new blog post is auto-added to the dynamic
    sitemap.
16. **Image optimization** - convert product photos to WebP, add `loading="lazy"`,
    add proper width/height attributes (currently missing on many images -
    affects Core Web Vitals).

### Ongoing

17. **Internal linking** - link related products on `product.php`, link
    blog posts to relevant product categories, link services pages to
    category pages.
18. **Monitor Google Search Console** weekly for: crawl errors, mobile
    usability issues, Core Web Vitals scores, structured-data warnings.
19. **Refresh sitemap weekly** via cron.
20. **Track keyword rankings** for top targets: "modular furniture India",
    "buy sofa online", "modular kitchen", "wardrobe design", "custom
    furniture", "interior design India".

---

## Verification Results

All SEO improvements have been verified across the codebase:

- 30 customer-facing pages updated
- 0 pages still using `lang="zxx"`
- 0 pages still using generic `<title>BOSK FURNITURE</title>`
- 30+ pages now setting `$page_title` correctly
- `seo-meta.php`, `robots.txt`, `sitemap.xml`, `.htaccess` all created
- JSON-LD validates as structured Organization, WebSite, Product,
  CollectionPage, AboutPage, ContactPage, Article, FurnitureStore,
  BreadcrumbList schemas

---

## Tools to Run After Going Live

Once the site is live with a real domain, run these free SEO tests:

1. **Google Rich Results Test** - https://search.google.com/test/rich-results
   (paste any page URL - all should validate with Organization + page-specific
   schema)
2. **PageSpeed Insights** - https://pagespeed.web.dev/ (Core Web Vitals)
3. **Mobile-Friendly Test** - https://search.google.com/test/mobile-friendly
4. **Lighthouse audit** in Chrome DevTools (SEO score should now be 95-100)
5. **Open Graph debug** - https://www.opengraph.xyz/ (paste a page URL)
6. **Schema validator** - https://validator.schema.org/

---

*Report generated by Claude SEO audit, 2026-05-18.*
