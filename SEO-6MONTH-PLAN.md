# Bosk Furniture — Deep 6-Month SEO Plan (May 2026 → Nov 2026)

**Owner:** Nikunj / Bosk Infracon Private Limited
**Site:** https://www.boskfurniture.com
**Target market:** India (national) — primary cities: Bhavnagar, Rajkot,
Ahmedabad, Vadodara, Surat, Mumbai, Pune, Delhi, Bangalore, Hyderabad.
**Plan generated:** 2026-05-26
**Constraint:** No UI / theme / layout changes — content + meta + image +
infrastructure work only.

---

## What was just fixed (2026-05-26 audit pass)

| Area              | Fix applied                                                        |
|-------------------|--------------------------------------------------------------------|
| Sitemap           | All `lastmod` refreshed to 2026-05-26                              |
| Typo: "Warrenty"  | Fixed on warranty.php, warranty_policy.php, hardware_warranty.php  |
| Wrong H1          | return_request.php "CONTACT US" → "Return Request"                 |
| Wrong H3          | return_request.php "Return Reqest?" → "Return Request?"            |
| Logo alt          | nav.php + nav1.php now have descriptive alt + width/height         |
| Homepage          | Category cards, "Why Choose" icons → real alt + lazy + decoding    |
| Services page     | 12 empty alts + 6 lorem-ipsum blurbs replaced with real SEO copy   |
| Projects pages    | Project + gallery + sidebar images → dynamic alt + lazy            |
| Product page      | Related-product thumb → dynamic alt + lazy                         |
| Testimonial page  | 24 customer-avatar imgs → alt + lazy + width/height (CLS fix)      |
| Order details     | Cart-line image → alt + lazy                                       |
| JSON-LD URLs      | product.php & shop.php now use clean URLs (no `.php`) in schema    |
| OG image          | Auto-falls back to slider/2.jpg if og-default.jpg is missing       |
| GSC/Bing/Yandex   | Verification meta-tag placeholders added (uncomment + paste code)  |
| GA4 + Clarity     | Analytics script placeholders added in design/script.php           |

**You can re-submit the sitemap to Google Search Console right now.**

---

## Pre-launch checklist (one-time, do these THIS WEEK)

1. **Create real `og-default.jpg`** (1200×630 px, your best room shot + logo,
   < 200 KB) and save at `images/og-default.jpg`. The fallback kicks in
   automatically — replace it the moment you upload the real file.
2. **Choose canonical host** — pick `www.boskfurniture.com` (recommended)
   OR `boskfurniture.com`. Uncomment the matching block in `.htaccess`
   lines 14-20. **Do not** leave both versions live.
3. **Install SSL on production**, then uncomment `.htaccess` lines 11-12
   to force HTTPS.
4. **Google Search Console**:
   - Verify ownership (use HTML meta tag method — paste your code into
     the placeholder in `design/seo-meta.php`).
   - Submit `https://www.boskfurniture.com/sitemap.xml`.
   - Submit a **URL Inspection** + **Request Indexing** for the homepage,
     `/all_products`, `/about-us`, `/contact`, `/all-services` (5 critical
     pages).
5. **Bing Webmaster Tools** — same flow. Bing has ~15% share on Indian
   desktops (Windows default).
6. **GA4 + Microsoft Clarity** — paste real IDs in
   `design/script.php` and uncomment.
7. **Google Business Profile** — register "Bosk Furniture" with the
   Bhavnagar address, +91-8866647777 phone, real opening hours, 6+ photos.
   This is the single highest-impact local-SEO win for a Gujarat-based
   furniture maker.
8. **Run** `https://www.boskfurniture.com/sitemap-generator.php` once to
   add every product/category/project/blog URL.

---

## The 6-month plan

I'm structuring this as **Foundation → Authority → Scale**. Each month
has a single anchor goal so you can measure if it worked.

### Month 1 — June 2026 — Foundation & Indexing

**Anchor goal:** every public page indexed in Google with no warnings.

| Week | Tasks |
|------|-------|
| W1 | Finish all pre-launch checklist items (above). Run `sitemap-generator.php`. Submit sitemap to GSC + Bing. Request indexing on homepage + 4 core pages. Set up rank-tracking in GSC for: "modular furniture Bhavnagar", "modular kitchen Gujarat", "custom furniture India", "wardrobe design India". |
| W2 | Set up a weekly **cron job** for `/sitemap-generator.php` (Sunday 03:00 IST). On hosting cPanel: Cron Jobs → `0 3 * * 0  /usr/bin/php /home/USER/public_html/sitemap-generator.php`. Submit `og-default.jpg`. Test all schema with [validator.schema.org](https://validator.schema.org) (paste 5 page URLs). |
| W3 | Convert top-20 hero / category / product images to **WebP**. Keep JPG fallback. Don't touch markup — use Apache `mod_rewrite` to serve WebP if browser supports it (rule below). |
| W4 | First Google Business Profile post (offer / showcase). Get 3 happy clients to leave a Google review. **Goal: cross 5 Google reviews.** |

**WebP serving rule for `.htaccess` (drop in below the `mod_rewrite` block):**
```apache
# Serve .webp if a sibling file exists and the browser accepts it
<IfModule mod_rewrite.c>
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{REQUEST_FILENAME} \.(jpe?g|png)$ [NC]
  RewriteCond %{REQUEST_FILENAME}.webp -f
  RewriteRule (.+)\.(jpe?g|png)$  $1.$2.webp  [T=image/webp,E=accept:1,L]
</IfModule>
<IfModule mod_headers.c>
  Header append Vary Accept env=REDIRECT_accept
</IfModule>
```

**KPI check (end of June):** GSC "Pages" → indexed count ≥ 30. No
"Discovered – currently not indexed" red flags. Bing index ≥ 20.

---

### Month 2 — July 2026 — Local SEO & Reviews

**Anchor goal:** rank top-5 for "modular furniture Bhavnagar" and at least
3 other "[furniture term] + city" combos.

| Week | Tasks |
|------|-------|
| W1 | **City landing pages** — create one page per metro you serve. Files: `bhavnagar-modular-furniture.php`, `rajkot-modular-furniture.php`, `ahmedabad-modular-furniture.php`, `vadodara-modular-furniture.php`, `surat-modular-furniture.php`. Each: 600+ words, real photos from projects in that city, customer quote, FAQ schema. Use the same header/footer — only the H1, intro, FAQ change. |
| W2 | 5 more city pages: `mumbai`, `pune`, `delhi`, `bangalore`, `hyderabad-modular-furniture.php`. Add all 10 to sitemap + internal links from `/all-services` & footer. |
| W3 | Get 5 more Google reviews. Add 3 real customer reviews to your testimonial DB. Capture customer name + city + product bought (use this in `AggregateRating` schema on product.php — Month 3). |
| W4 | NAP audit. NAP = Name, Address, Phone. List on 20 free Indian business directories: JustDial, Sulekha, IndiaMART, TradeIndia, IndianYellowPages, AskLaila, Hotfrog, Yellow.Place, Cylex, Tuugo, City Local, IndiaList, Yalwa, BizPages, etc. **Exact same** NAP everywhere — Google uses consistency as a ranking signal. |

**KPI check (end of July):** ≥ 10 Google reviews. ≥ 3 city landing pages
in Google's top 10 for "[city] + modular furniture". Direction queries to
showroom increase visible in GBP Insights.

---

### Month 3 — Aug 2026 — Content Engine (blog) + E-E-A-T

**Anchor goal:** publish 12 cornerstone blog posts targeting buyer-intent
keywords. Establish Bosk as an authority.

**Why blogs:** product/category pages convert traffic, blogs *bring* the
traffic. India has > 300k monthly searches for furniture buying-guide
keywords.

**Editorial calendar (1 post every 2-3 days = 12 posts):**

| # | Title (also the H1) | Target keyword | Word count |
|---|---|---|---|
| 1 | L-Shaped vs U-Shaped Modular Kitchen: Which Layout Suits Your Indian Home? | l shaped modular kitchen | 1500 |
| 2 | 12 Wardrobe Designs for Small Bedrooms (Indian Apartments 2026) | wardrobe design for small bedroom | 1800 |
| 3 | How Much Does a Modular Kitchen Cost in India? (Bhavnagar / Ahmedabad / Mumbai Rates) | modular kitchen cost india | 2000 |
| 4 | Solid Wood vs Plywood vs MDF: Which Is Best for Indian Climate? | plywood vs solid wood furniture | 1500 |
| 5 | Hettich Hardware: Why Bosk Uses It (And You Should Demand It) | hettich hardware furniture | 1200 |
| 6 | TV Unit Designs 2026: 15 Ideas for Indian Living Rooms | tv unit design | 2000 |
| 7 | Bed With Storage: 10 Smart Designs for Indian Bedrooms | storage bed design | 1500 |
| 8 | How to Measure Your Kitchen for a Modular Kitchen (DIY Guide) | how to measure modular kitchen | 1800 |
| 9 | Bosk Customer Story: Modular Kitchen Installation in Bhavnagar (Photos + Cost) | modular kitchen bhavnagar | 2000 |
| 10 | Sofa Sizes Guide: 3-Seater, L-Shape, Sectional — Indian Living Room Pick | sofa size guide india | 1500 |
| 11 | Vastu For Furniture Placement: A Practical Indian Guide | vastu for furniture | 1500 |
| 12 | Furniture Care in Monsoon: Protecting Your Wood Furniture in India | furniture care monsoon | 1200 |

**Each post MUST have:**
- One unique target keyword in title + H1 + first 100 words + URL slug.
- 3-5 internal links: to a category page (`/shop?astringdata2=Sofa`),
  to a related blog, to `/contact` or `/ex-customize_furniture` (CTA).
- 1 external authoritative link (Hettich, IS standards, government).
- 3 images with descriptive filenames + alt text (admin upload form
  passes `img` to `details.php` so use slug-style filenames).
- Author = "Bosk Furniture Design Team" — that triggers `Article`
  schema (already wired in `details.php`).
- FAQ section at bottom — 3-5 Q&A. Add FAQPage JSON-LD (snippet below).

**FAQPage schema snippet to paste into blog post body via admin:**
```html
<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"FAQPage",
  "mainEntity":[
    {"@type":"Question","name":"Q1 here?","acceptedAnswer":{"@type":"Answer","text":"A1 here."}},
    {"@type":"Question","name":"Q2 here?","acceptedAnswer":{"@type":"Answer","text":"A2 here."}}
  ]
}
</script>
```

**Also in Aug:** add **`AggregateRating`** JSON-LD to `product.php` once
you have ≥ 3 reviews per product. Hooks for `ratingValue` + `reviewCount`
in `product.php` line ~83 (inside the existing Product schema).

**KPI check (end of Aug):** Blog posts indexed within 7 days each. At
least 5 blog posts ranking on page 1-3. Organic clicks (GSC) up 100%
month-over-month.

---

### Month 4 — Sep 2026 — Internal Linking + Technical Performance

**Anchor goal:** average Core Web Vitals (CWV) "Good" rating on 80% of
URLs. LCP < 2.5s, CLS < 0.1, INP < 200ms.

| Week | Tasks |
|------|-------|
| W1 | Run [PageSpeed Insights](https://pagespeed.web.dev/) on 10 templates (home, shop, product, details, about, contact, projects, project-details, testimonial, design-order-process). Fix flagged issues. Likely fixes: (a) inline critical CSS for above-the-fold, (b) defer non-critical JS, (c) compress remaining JPGs to WebP, (d) add `fetchpriority="high"` to hero image. |
| W2 | **Internal linking pass.** Open every blog post (sept'd 12 posts) and add 5 contextual links each pointing to product pages and other blogs. Open `product.php` template — add a "Related blog posts" block under the related-products carousel (DB-driven, fetched by `pcategory`). |
| W3 | **Schema audit.** Re-run [Rich Results Test](https://search.google.com/test/rich-results) on 10 page templates. Fix any warnings. Add `Review` schema on testimonial.php (each testimonial gets `Review` markup). |
| W4 | **Pagination + canonicals** on `all_products.php` and `shop.php`. If/when you paginate, add `<link rel="canonical">` to the page-1 canonical and use `rel="prev"` / `rel="next"`. Avoid faceted-URL duplicate-content issues by disallowing filter-query patterns in robots.txt (already partly done — extend as needed). |

**KPI check (end of Sep):** PSI mobile score ≥ 75 on all templates. CWV
report in GSC: "Good URLs" > 80%.

---

### Month 5 — Oct 2026 — Authority / Off-page / Backlinks

**Anchor goal:** acquire 25 high-quality dofollow backlinks from Indian
domains.

| Source                                            | Target |
|---------------------------------------------------|--------|
| **Local press releases** (PRNewswire India, EIN India) — "Bosk launches X" or "Bosk expands to Y" | 3 links |
| **Furniture blog guest posts** (e.g. interior-design websites accepting submissions) — pitch 5, land 2 | 2 links |
| **Architectural Digest India / Beautiful Homes / HomeLane comparison articles** — outreach for product mentions | 2 links |
| **Manufacturer partner links** — ask Hettich India to list you as an authorised partner page | 1 link |
| **Bhavnagar / Gujarat business chambers** — Federation of Gujarat Industries, BCCI Bhavnagar | 2 links |
| **Industry associations** — Furniture Industry Association of India, FOAI | 2 links |
| **University / college projects** — Gujarat institute interior-design courses, sponsor a workshop | 2 links |
| **Wikipedia / Wikidata** — create a Wikidata entry for Bosk Infracon (auto-flows to Google Knowledge Panel) | 1 link |
| **YouTube backlinks** — upload 4 project walk-through videos, link description → site (technically nofollow but drives referral traffic + brand entity signals) | 4 links |
| **Instagram + Pinterest** — claim brand on Pinterest (huge for furniture in India), add Rich Pins (uses your existing Product schema) | 6 links |

**One-time E-E-A-T win:** add an "About the Founder" section on
`about-us.php` with your photo, qualifications, years in industry —
Google rewards real-author signals for YMYL-adjacent niches like home
purchase decisions. (Content-only, no layout shift.)

**KPI check (end of Oct):** Domain Rating (Ahrefs/Moz) up by ≥ 5 points.
Referring domains ≥ 30. Branded search ("bosk furniture") volume up 50%
in GSC.

---

### Month 6 — Nov 2026 — Conversion + AI Search (GEO)

**Anchor goal:** convert the traffic you've built. And lock in visibility
in AI-generated answers (ChatGPT, Gemini, Perplexity, Claude).

| Week | Tasks |
|------|-------|
| W1 | **Conversion audit.** Heatmaps from Microsoft Clarity (set up in Month 1) — find where users drop off on `product.php` and `checkout.php`. Improve CTAs, trust badges, shipping info. Add "WhatsApp Now" floating button (massive in India). |
| W2 | **Speed audit refresh.** Re-run PSI on top 20 URLs. Anything new that broke gets fixed. Check 404s in GSC and 301-redirect any that have backlinks. |
| W3 | **AI Search optimization (GEO / AEO).** AI engines pull from sites with: (a) clean schema, (b) FAQ blocks, (c) authoritative third-party mentions, (d) factual specifics (prices, dimensions, materials). Audit every blog + product page for "ChatGPT-friendly" answers — first 2 sentences after every H2 should be a clean factual paragraph that can stand alone. |
| W4 | **Q4 push.** Diwali / wedding-season campaign content. Publish "Top 10 Wedding-Season Furniture Picks for 2026" and "Diwali Home Refresh Guide" — keyword volume spikes 8x in Oct-Dec in India. |

**KPI check (end of Nov):** Organic sessions up 4-6x vs May baseline.
Total indexed pages ≥ 100 (15 static + 12 blog + 10 city + ~60 dynamic
product/category/project). At least 1 of your blog posts gets quoted by
Perplexity or Gemini for a target query.

---

## Recurring weekly tasks (every Monday, 30 min)

1. Open **GSC Performance** → Top queries → Top pages. Note any new
   query gaining impressions but with poor CTR — rewrite that page's
   meta description.
2. Open **GSC Coverage / Pages** → fix any new "Error" or "Excluded"
   URLs.
3. Open **GSC Core Web Vitals** → any new "Poor" URLs → escalate.
4. **Run `/sitemap-generator.php`** (or confirm the cron ran).
5. Check Bing Webmaster Tools.
6. Reply to all new Google reviews within 24 hours.

## Recurring monthly tasks (first Sunday of month, 2 hrs)

1. Publish ≥ 3 new blog posts.
2. Add 2 new project case studies to `projects.php` via admin.
3. Refresh 1 older blog post (Google rewards freshness).
4. 1 new Google Business Profile post + 4 new photos.
5. Outreach: 5 backlink prospects pitched.

---

## Tracking dashboard — what to watch

| Metric | Tool | Baseline (May 2026) | Goal (Nov 2026) |
|---|---|---|---|
| GSC indexed pages | Search Console | ~20 | ≥ 100 |
| GSC organic clicks / mo | Search Console | TBD | 4-6x baseline |
| Branded "bosk furniture" search vol | Search Console | TBD | +50% |
| Google reviews | Google Business Profile | 0 | 50+ |
| Referring domains | Ahrefs free / Moz Link Explorer | TBD | 30+ |
| Domain Rating | Ahrefs free | TBD | +5 |
| CWV "Good" URLs % | Search Console | TBD | ≥ 80% |
| Top-3 ranking keywords | RankMath / Ubersuggest free / manual | <5 | ≥ 25 |

---

## Important "do not break" reminders

These are based on the constraint you set — **no UI/theme/layout
changes** — and from this audit:

1. Don't rename existing PHP file names (URLs depend on them, .htaccess
   maps clean URLs to `.php` files).
2. Don't change CSS class names or DOM structure inside any partial in
   `design/`. SEO is happening entirely in `<head>` (via
   `design/seo-meta.php`) — the body stays untouched.
3. When adding new pages, copy an existing template and only swap
   `$page_title`, `$page_description`, `$page_canonical`, body content.
   The header/nav/footer partials will give you all SEO meta for free.
4. Never re-introduce `lang="zxx"`. Always `lang="en-IN"` (for any new
   page, copy DOCTYPE block from an existing page).
5. Never write `alt=""` — use the same dynamic alt pattern this audit
   added.
6. Every product/category image upload in admin → use slug-style file
   names (`l-shaped-sofa-grey.jpg`, not `IMG_2738.jpg`). Filename is a
   ranking signal for Google Images.

---

## File reference (what's in this codebase that drives SEO)

| File | What it does | Touch when |
|---|---|---|
| `design/seo-meta.php` | Central head — meta, OG, Twitter, JSON-LD | Site-wide change (e.g. paste GSC code) |
| `design/header.php` | Loads seo-meta + CSS includes | Never (it's clean) |
| `design/script.php` | All bottom-of-page JS + analytics placeholders | When adding tracking |
| `sitemap.xml` | Static sitemap | Don't edit by hand — regenerated by next file |
| `sitemap-generator.php` | Builds full sitemap from DB | Run weekly via cron |
| `robots.txt` | Crawl directives | When adding new blocked sections |
| `.htaccess` | Clean URLs, gzip, cache, security headers | When enabling HTTPS / www redirect |
| `SEO-AUDIT-REPORT.md` | Original (2026-05-18) audit | Reference only |
| `SEO-6MONTH-PLAN.md` | This document | Update at end of each month |

---

*Plan generated by Claude SEO audit + roadmap pass, 2026-05-26.*
