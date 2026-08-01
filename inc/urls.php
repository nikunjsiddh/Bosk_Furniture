<?php
/* ============================================================
   Bosk Furniture — canonical URL helpers.

   Slug URLs are deliberately FLAT (one path segment), because every
   asset and nav link on the site is relative ("css/styles.css",
   "all_products"). A nested URL such as /product/kylie would make the
   browser resolve those against /product/, breaking the page — the
   only fixes being a global <base> tag or rewriting every asset path.
   Flat slugs carry the same search value at none of that risk.

     category  ->  modular-kitchens
     product   ->  product-kylie
     blog post ->  blog-modular-kitchen-cost-gujarat

   Helpers return RELATIVE URLs so the site keeps working when served
   from a sub-folder (http://localhost/bosk/) as well as from the
   domain root in production.
   ============================================================ */

if (!function_exists('bosk_slugify')) {
    function bosk_slugify($s) {
        $s = strtolower(trim((string)$s));
        $s = preg_replace('~[^a-z0-9]+~', '-', $s);
        return trim($s, '-');
    }
}

if (!function_exists('url_product')) {
    function url_product($slug) { return 'product-' . rawurlencode((string)$slug); }
}
if (!function_exists('url_category')) {
    function url_category($slug) { return rawurlencode((string)$slug); }
}
if (!function_exists('url_blog')) {
    function url_blog($slug) { return 'blog-' . rawurlencode((string)$slug); }
}
if (!function_exists('url_project')) {
    function url_project($slug) { return 'project-' . rawurlencode((string)$slug); }
}

/* Application root path, e.g. "/bosk/" locally or "/" in production.
   Used for Location: headers, which need a path rather than a relative ref. */
if (!function_exists('bosk_base_path')) {
    function bosk_base_path() {
        $dir = str_replace('\\', '/', dirname(isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/'));
        return rtrim($dir, '/') . '/';
    }
}

/* Look up a slug for a legacy numeric id. Returns null when absent, so
   callers can fall back rather than emitting a broken link.

   Rows that are not yet published are treated as absent: redirecting a live
   legacy URL to a slug URL that then 404s would turn one bad URL into a
   301 -> 404 chain, which is worse than sending it somewhere useful. */
if (!function_exists('bosk_slug_for')) {
    function bosk_slug_for($con, $table, $id) {
        $published = [
            'products' => ' AND publish_date <= NOW()',
            'blog'     => ' AND blog_date <= NOW()',
            'category' => '',
            'projects' => '',
        ];
        if (!isset($published[$table])) return null;
        $id = (int)$id;
        $q  = @mysqli_query($con, "SELECT slug FROM `$table` WHERE id=$id" . $published[$table] . " LIMIT 1");
        if (!$q || mysqli_num_rows($q) === 0) return null;
        $r = mysqli_fetch_row($q);
        return ($r && $r[0] !== '') ? $r[0] : null;
    }
}

/* Category slug from its display name — legacy links carry the name. */
if (!function_exists('bosk_category_slug')) {
    function bosk_category_slug($con, $name) {
        $n = mysqli_real_escape_string($con, trim((string)$name));
        $q = @mysqli_query($con, "SELECT slug FROM category WHERE LOWER(TRIM(name))=LOWER('$n') LIMIT 1");
        if ($q && mysqli_num_rows($q) > 0) {
            $r = mysqli_fetch_row($q);
            if ($r && $r[0] !== '') return $r[0];
        }
        return bosk_slugify($name);
    }
}
