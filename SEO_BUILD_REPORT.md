# BOSK Furniture — SEO Build Report

Branch `claude/seo-ranking-website-ea699f`. Verified locally against Apache;
**nothing has been deployed.**

---

## What the audit got wrong

The audit (1 Aug 2026) was run against the live server and is partly stale.
These were already built and working in the codebase before this session:

- `.htaccess` already forced `https://www.` and already 301'd `/page.php` → `/page`
  (correctly matching `%{THE_REQUEST}`, so no redirect loop).
- `design/seo-meta.php` already emitted a single global head: title, description,
  canonical, OG, Twitter, geo, plus Organization / FurnitureStore / WebSite JSON-LD.
- `robots.txt` was already clean and AI-crawler friendly.
- `sitemap.xml` was already valid uncompressed XML — not binary.

So audit items **C1, C2, C3 (partly), H1 and M4 were already fixed.** The live
site is presumably running an older deploy. Worth confirming before you act on
the rest of that document.

## What was actually still broken — and is now fixed

| # | Problem | Fix |
|---|---|---|
| C4 | Products, categories, blog posts and projects all sat behind `?astringdata=` | Slug URLs everywhere + 301s from every legacy URL |
| C5 | 7 placeholder products indexable as the real catalogue | `is_demo` flag drives noindex + sitemap exclusion |
| C6 | Empty categories indexable, incl. the top keyword target | Auto-noindex when a category has 0 live products |
| H3 | Blog used generic `Article`, no dates | `BlogPosting` with `datePublished`/`dateModified` |
| H4 | "Free shipping across India" / "Best prices" — unverified claims | Removed everywhere |
| H6 | Blog titles 78 chars, category titles 65 | Suffix appended only if result stays ≤60 |
| — | No FAQPage despite 14 Q&A pairs sitting in the posts | `FAQPage` parsed from post body, text matches page exactly |

## New URL structure

Slug URLs are **flat** (one path segment). This is deliberate: every asset and
nav link on the site is relative (`css/styles.css`, `all_products`), so a nested
`/product/kylie` would make the browser resolve them against `/product/` and
break the page. Avoiding that would need a global `<base>` tag — risky with
mmenu, revolution slider and owl carousel all building URLs at runtime. Flat
slugs carry identical search value at none of that risk.

```
/modular-kitchens                      (category — top-level, highest value)
/product-colorado-gross                (product)
/blog-modular-kitchen-cost-gujarat     (blog post)
/project-hall1                         (project)
/blog                                  (blog index)
```

Every legacy URL 301s in **exactly one hop**, verified:

| Old | New |
|---|---|
| `/details?astringdata=19` | `/blog-modular-kitchen-cost-gujarat` |
| `/product?astringdata=OA==` | `/product-colorado-gross` |
| `/shop?astringdata2=Sofa` | `/sofas` |
| `/project-details?astringdata=Mg==` | `/project-hall1` |
| `/blog-full-list` | `/blog` |
| `/about-us.php` | `/about-us` |

## Security issues found and fixed in passing

1. **SQL injection in `shop.php`** — `$decodedcategoryname` was `urldecode()`d
   raw input interpolated straight into the product query. Unescaped.
2. **SQL injection in `project-details.php`** — `base64_decode()` output went
   into the query with no validation. Now must decode to a plain integer.
3. **Unpublished blog drafts were publicly readable** at
   `/blog/files/Blog-4-How-to-Choose-a-Wardrobe.md` (also Blog-5, Blog-6, and the
   strategy doc). Now denied via `blog/.htaccess`.
4. **Empty 200 pages** — `/checkout` logged-out, plus `/order_details`,
   `/invoice`, `/return_request` with no parameters, all returned a blank
   200 that a crawler can index as thin content. Now 302 to login / 404.

## Bugs fixed in passing

- Homepage category counts used `COUNT(*)` on a LEFT JOIN, so empty categories
  reported "1 Products". Now `COUNT(p.id)`.
- Category matching ignored a stray leading space in one product's `pcategory`,
  so a wardrobe was missing from its own category listing. Now `TRIM`ed both sides.
- Blog index title rendered as `&amp;amp;` (double-escaped).
- `sameAs` listed five social profiles (`facebook.com/boskfurniture` etc.) that
  appear nowhere on the site — the footer icons all point at bare domain roots.
  They were almost certainly guessed. **Removed** — claiming a profile you don't
  own is a spam signal.
- `SearchAction` pointed at `/shop?astringdata2={term}`, a category filter rather
  than a search. Removed; the site has no search page.

---

## [CONFIRM] — needs your input

1. **Social profiles.** Send the real URLs and I'll restore `sameAs`. Right now
   the footer links go to `facebook.com`, `instagram.com` etc. with no account path.
2. **All 7 products are placeholders**, so the entire catalogue is now `noindex`
   and every category is empty → also `noindex`. This is correct (a ₹408
   "Colorado Gross" hurts more than it helps) but it means **no product or
   category page will rank until the real catalogue is loaded.** Clearing
   `is_demo` on a row re-indexes it automatically — no code change needed.
3. **Opening hours** in LocalBusiness schema say Mon–Sat 10:00–20:00. I did not
   set that; please confirm it's accurate.
4. **Product pages have two `<h1>`s** (banner + product title). Fixing it means
   editing theme CSS, which you've asked me not to touch — and Google handles
   multiple H1s fine. Left as-is deliberately. Say the word if you want it changed.

---

## Deploy steps

The DB migration must run **before** the code goes live, or slug URLs 404.

```bash
php tools/backfill_slugs.php
```

It is idempotent and safe to re-run. It adds `slug` to products/category/blog/projects,
adds `is_demo` to products, backfills, flags the 7 placeholder rows, then applies
unique indexes. It refuses to run over the web.

Then regenerate the sitemap:

```bash
php sitemap-generator.php
```

Note `connect.php` now honours `BOSK_DB_ENV=local` so CLI tooling can target the
XAMPP database; on the server, leave it unset and it uses production as before.

After deploy: submit `/sitemap.xml` in Search Console, request indexing for
`/blog` and the three post URLs, and keep the legacy redirects permanently.

## Verification results

- Redirect matrix: 10/10 legacy URLs, single hop, all end 200. Zero loops.
- Sitemap: 26 URLs, all return 200. No 301s, no 404s, no parameter URLs.
- JSON-LD: 13 page types, 0 parse failures.
- FAQPage: 14 Q&A pairs across 3 posts, all matching visible page text exactly.
- Head tags: one title / canonical / description per page; all titles ≤57 chars.
- Unknown slugs return a real 404.
- PHP: zero warnings or notices across all pages; all changed files lint clean.
- Regression: 30 public pages return 200; `/Admin`, `/back/*` AJAX endpoints and
  static dirs behave identically to the pre-change site.
