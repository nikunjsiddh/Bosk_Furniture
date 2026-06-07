<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");

// Safe defaults so the rest of the page never sees undefined variables.
$blog_title = '';
$blogid     = 0;

if (isset($_GET['astringdata'])) {

    $raw = $_GET['astringdata'];

    // The site links to this page in TWO styles:
    //   1) plain numeric id   -> details.php?astringdata=1           (blog-full-list.php, related sidebar)
    //   2) base64-encoded id  -> details.php?astringdata=MQ==        (homepage block in index.php)
    // Accept both without breaking existing links.
    if (ctype_digit($raw)) {
        $blogid = (int) $raw;
    } else {
        $decoded = base64_decode($raw, true);
        $blogid  = ($decoded !== false && ctype_digit($decoded)) ? (int) $decoded : 0;
    }

    // Scheduled publishing: a blog post is only viewable from its publish date onward.
    if ($blogid > 0) {
        $pubchk = mysqli_query($con, "select id from blog where id='" . $blogid . "' and blog_date <= NOW()");
        if (!$pubchk || mysqli_num_rows($pubchk) === 0) {
            header("Location: blog-full-list.php");
            exit();
        }
    }

    if ($blogid > 0) {
        $cmd3    = "select * from blog where id='" . $blogid . "'";
        $result3 = mysqli_query($con, $cmd3) or die(mysqli_error($con));
        while ($row3 = mysqli_fetch_array($result3)) {
            $blog_title = $row3['blog_title'];
        }
    }

// ---- Dynamic SEO for blog post ----
$_seo_blog        = isset($blog_title) && $blog_title !== '' ? $blog_title : 'Blog Article';
$page_title       = $_seo_blog . ' | Bosk Furniture Blog India';
$page_description = 'Read "' . $_seo_blog . '" on the Bosk Furniture blog - expert furniture tips, interior design ideas and home decor inspiration for Indian homes.';
$page_keywords    = $_seo_blog . ', furniture blog, interior design tips, bosk furniture blog india';
$page_canonical   = '/details?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '');
$og_type          = 'article';
$page_breadcrumbs = [
    ['name' => 'Home',     'url' => '/'],
    ['name' => 'Blog',     'url' => '/blog-full-list'],
    ['name' => $_seo_blog, 'url' => '/details?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '')]
];
$page_schema = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": ' . json_encode($_seo_blog) . ',
  "author": {"@type":"Organization","name":"Bosk Furniture"},
  "publisher": {"@type":"Organization","name":"Bosk Furniture","logo":{"@type":"ImageObject","url":"https://www.boskfurniture.com/images/fevicon.png"}},
  "mainEntityOfPage": "' . htmlspecialchars($page_canonical, ENT_QUOTES, 'UTF-8') . '",
  "inLanguage": "en-IN"
}
</script>';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <style>
        /* ============================================================ */
        /* ================= BLOG DETAILS - MODERN UI ================= */
        /* ============================================================ */
        :root { --brand: #532A1A; --brand-deep: #3a1d12; --brand-soft: #fbf5f1; }

        body.blog-details-page { background: #fafafa; }

        /* Reading progress bar */
        .reading-progress {
            position: fixed;
            top: 0; left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, var(--brand), #c47a5a);
            box-shadow: 0 0 8px rgba(83,42,26,.5);
            z-index: 9999;
            transition: width .1s ease-out;
        }

        /* =================== ARTICLE HERO =================== */
        .article-hero {
            position: relative;
            min-height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            overflow: hidden;
            color: #fff;
            padding: 8rem 0 0;
            isolation: isolate;
        }
        .article-hero-bg {
            position: absolute;
            inset: 0;
            background-position: center;
            background-size: cover;
            transform: scale(1.05);
            transition: transform 12s ease-out;
            z-index: -2;
        }
        .article-hero.is-revealed .article-hero-bg { transform: scale(1); }
        .article-hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(17,17,17,.25) 0%, rgba(17,17,17,.55) 55%, rgba(17,17,17,.85) 100%),
                linear-gradient(135deg, rgba(83,42,26,.35) 0%, transparent 60%);
            z-index: -1;
        }

        .article-hero-inner {
            position: relative;
            padding-bottom: 3.5rem;
        }

        .article-back {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: rgba(255,255,255,.85) !important;
            text-decoration: none !important;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: .55rem 1rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,.3);
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(6px);
            margin-bottom: 1.8rem;
            transition: all .3s ease;
        }
        .article-back:hover {
            background: rgba(255,255,255,.18);
            border-color: rgba(255,255,255,.55);
            color: #fff !important;
            transform: translateX(-3px);
        }
        .article-back i { transition: transform .3s ease; }
        .article-back:hover i { transform: translateX(-3px); }

        .article-category {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: var(--brand);
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            padding: .45rem .85rem;
            border-radius: 3px;
            margin-bottom: 1.2rem;
        }

        .article-title {
            color: #fff !important;
            font-size: clamp(1.7rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -.01em;
            margin: 0 0 1.4rem;
            max-width: 900px;
            text-shadow: 0 2px 20px rgba(0,0,0,.25);
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.4rem;
            color: rgba(255,255,255,.92);
            font-size: .9rem;
        }
        .article-meta .meta-item {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
        }
        .article-meta .meta-item i { color: #f4c8b1; }

        /* Hero breadcrumb strip at bottom of hero */
        .article-crumb {
            position: relative;
            background: rgba(0,0,0,.35);
            backdrop-filter: blur(6px);
            border-top: 1px solid rgba(255,255,255,.08);
            padding: .85rem 0;
            font-size: .85rem;
        }
        .article-crumb a {
            color: rgba(255,255,255,.85) !important;
            text-decoration: none !important;
            transition: color .25s ease;
        }
        .article-crumb a:hover { color: #f4c8b1 !important; }
        .article-crumb span { color: rgba(255,255,255,.6); margin: 0 .55rem; }
        .article-crumb .current {
            color: #f4c8b1;
            margin-left: 0;
            margin-right: 0;
            display: inline-block;
            max-width: 360px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: bottom;
        }

        /* =================== ARTICLE SECTION =================== */
        .article-section {
            padding: 4.5rem 0 5rem;
            background:
                radial-gradient(900px 500px at 0% 0%, rgba(83,42,26,.05), transparent 60%),
                #fafafa;
        }

        .article-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.4rem 2.4rem 1.8rem;
            box-shadow: 0 10px 40px rgba(83,42,26,.06);
            border: 1px solid rgba(83,42,26,.05);
            margin-bottom: 2rem;
        }

        /* Featured image inside the article card */
        .article-feature-img {
            margin: 0 0 1.8rem;
            padding: 0;
            position: relative;
        }
        .article-feature-frame {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            background: #111;
            box-shadow: 0 14px 36px rgba(83,42,26,.14);
            border: 1px solid rgba(83,42,26,.08);
        }
        .article-feature-frame::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 60%, rgba(0,0,0,.35) 100%);
            opacity: 0;
            transition: opacity .45s ease;
            pointer-events: none;
            z-index: 1;
        }
        .article-feature-img:hover .article-feature-frame::before { opacity: 1; }
        .article-feature-frame img {
            display: block;
            width: 100%;
            height: auto;
            max-width: 100%;
            transform: scale(1);
            transition: transform .9s cubic-bezier(.2,.7,.2,1), filter .6s ease;
            filter: saturate(1) brightness(.98);
        }
        .article-feature-img:hover .article-feature-frame img {
            transform: scale(1.035);
            filter: saturate(1.08) brightness(1);
        }
        .article-feature-caption {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            margin-top: .8rem;
            padding: .4rem .85rem;
            background: var(--brand-soft);
            border-left: 3px solid var(--brand);
            color: #555;
            font-size: .82rem;
            font-style: italic;
            border-radius: 0 6px 6px 0;
        }
        .article-feature-caption i { color: var(--brand); }

        .article-content { font-size: 1rem; }
        .article-content p,
        .article-content .article-lead {
            color: #444;
            font-size: 1.05rem;
            line-height: 1.85;
            margin: 0 0 1.3rem;
        }
        /* Drop-cap on first letter of lead paragraph */
        .article-lead::first-letter {
            float: left;
            font-family: 'Poppins', Georgia, serif;
            font-size: 3.6rem;
            font-weight: 800;
            line-height: 1;
            color: var(--brand);
            padding: .15rem .65rem 0 0;
            margin-top: .2rem;
        }
        .article-content a {
            color: var(--brand);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed rgba(83,42,26,.35);
            transition: all .25s ease;
        }
        .article-content a:hover {
            color: var(--brand-deep);
            border-bottom-color: var(--brand);
        }

        /* Article footer (tags + share) */
        .article-footer {
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem;
            align-items: center;
            justify-content: space-between;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px dashed rgba(83,42,26,.18);
        }
        .article-tags {
            display: inline-flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .5rem;
            color: #777;
            font-size: .85rem;
        }
        .article-tags > i { color: var(--brand); margin-right: .25rem; }
        .article-tags a {
            display: inline-block;
            padding: .35rem .75rem;
            border-radius: 999px;
            background: var(--brand-soft);
            color: var(--brand) !important;
            font-size: .78rem;
            font-weight: 600;
            text-decoration: none !important;
            border: 1px solid rgba(83,42,26,.15);
            transition: all .25s ease;
        }
        .article-tags a:hover {
            background: var(--brand);
            color: #fff !important;
            border-color: var(--brand);
            transform: translateY(-2px);
        }

        .article-share {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }
        .article-share .share-label {
            color: #777;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-right: .25rem;
        }
        .share-btn {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff;
            border: 1px solid rgba(83,42,26,.18);
            color: var(--brand);
            font-size: .95rem;
            cursor: pointer;
            transition: all .3s cubic-bezier(.2,.7,.2,1);
            text-decoration: none !important;
            padding: 0;
        }
        .share-btn:hover {
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(83,42,26,.18);
        }
        .share-fb:hover { background: #1877f2; border-color: #1877f2; }
        .share-tw:hover { background: #1da1f2; border-color: #1da1f2; }
        .share-wa:hover { background: #25d366; border-color: #25d366; }
        .share-li:hover { background: #0a66c2; border-color: #0a66c2; }
        .share-copy:hover { background: var(--brand); border-color: var(--brand); }
        .share-copy.is-copied {
            background: #2e7d32 !important;
            border-color: #2e7d32 !important;
            color: #fff !important;
        }

        /* =================== COMMENT FORM =================== */
        .comment-card {
            background: #fff;
            border-radius: 16px;
            padding: 2.4rem;
            box-shadow: 0 10px 40px rgba(83,42,26,.06);
            border: 1px solid rgba(83,42,26,.05);
        }
        .comment-heading { margin-bottom: 1.8rem; }
        .comment-eyebrow {
            display: inline-flex;
            align-items: center;
            font-size: .76rem;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--brand);
            font-weight: 700;
            margin-bottom: .8rem;
        }
        .eyebrow-line {
            display: inline-block;
            width: 30px;
            height: 2px;
            background: var(--brand);
            margin-right: 10px;
        }
        .comment-heading h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 .4rem;
        }
        .comment-sub {
            color: #777;
            font-size: .95rem;
            margin: 0;
        }
        .comment-form .form-group { margin-bottom: 1.1rem; }
        .comment-form label {
            display: block;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #555;
            margin-bottom: .45rem;
        }
        .comment-form .form-control {
            width: 100%;
            background: var(--brand-soft);
            border: 1px solid transparent;
            border-radius: 10px;
            padding: .85rem 1rem;
            font-size: .95rem;
            color: #222;
            transition: border-color .25s ease, background .25s ease, box-shadow .25s ease;
        }
        .comment-form .form-control:focus {
            background: #fff;
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(83,42,26,.08);
            outline: none;
        }
        .comment-form textarea.form-control {
            min-height: 140px;
            resize: vertical;
        }

        /* Validation styling */
        .comment-form label .req { color: #c0392b; margin-left: 2px; }
        .comment-form .form-group.has-error .form-control {
            border-color: #c0392b !important;
            background: #fcf3f3;
            box-shadow: 0 0 0 4px rgba(192,57,43,.07);
        }
        .comment-form .error-msg {
            display: none;
            margin-top: 6px;
            font-size: 12px;
            color: #c0392b;
            font-weight: 500;
            opacity: 0;
            transform: translateY(-4px);
            transition: opacity .25s ease, transform .25s ease;
        }
        .comment-form .form-group.has-error .error-msg {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
        .comment-form .form-group.has-error .error-msg::before {
            content: "⚠  ";
            color: #c0392b;
        }
        #return:not(:empty) {
            margin-top: 18px;
            padding: 14px 18px;
            background: #ecf7ed;
            border: 1.5px solid #b6dfb9;
            color: #1f6d28;
            border-radius: 10px;
            font-size: 14px;
        }
        .comment-submit {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            padding: .9rem 1.6rem;
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: 999px;
            font-weight: 600;
            font-size: .92rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 10px 22px rgba(83,42,26,.22);
            transition: all .3s cubic-bezier(.2,.7,.2,1);
            margin-top: .6rem;
        }
        .comment-submit:hover {
            background: var(--brand-deep);
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(83,42,26,.32);
        }
        .comment-submit i { transition: transform .3s ease; }
        .comment-submit:hover i { transform: translateX(4px); }

        /* =================== SIDEBAR =================== */
        .article-sidebar { padding-left: 2rem; }
        @media (max-width: 991px) {
            .article-sidebar { padding-left: 15px; margin-top: 2.5rem; }
        }
        .sidebar-sticky {
            position: sticky;
            top: 100px;
        }
        @media (max-width: 991px) { .sidebar-sticky { position: static; } }

        .widget {
            background: #fff;
            border-radius: 16px;
            padding: 1.8rem 1.6rem;
            box-shadow: 0 10px 40px rgba(83,42,26,.06);
            border: 1px solid rgba(83,42,26,.05);
            margin-bottom: 1.6rem;
        }
        .widget-heading { margin-bottom: 1.2rem; }
        .widget-eyebrow {
            display: inline-flex;
            align-items: center;
            font-size: .7rem;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--brand);
            font-weight: 700;
            margin-bottom: .55rem;
        }
        .widget-heading h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }

        /* Recent Posts list */
        .recent-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .recent-item { margin: 0 0 .9rem; }
        .recent-item:last-child { margin-bottom: 0; }
        .recent-link {
            display: flex;
            gap: .9rem;
            align-items: stretch;
            padding: .6rem;
            border-radius: 12px;
            text-decoration: none !important;
            transition: background .3s ease, transform .3s ease;
            border: 1px solid transparent;
        }
        .recent-link:hover {
            background: var(--brand-soft);
            border-color: rgba(83,42,26,.1);
            transform: translateX(3px);
        }
        .recent-item.is-active .recent-link {
            background: var(--brand-soft);
            border-color: rgba(83,42,26,.18);
        }
        .recent-thumb {
            display: block;
            flex: 0 0 84px;
            width: 84px;
            height: 64px;
            overflow: hidden;
            border-radius: 8px;
            background: #eee;
        }
        .recent-thumb img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s cubic-bezier(.2,.7,.2,1);
        }
        .recent-link:hover .recent-thumb img { transform: scale(1.1); }
        .recent-meta {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            flex: 1 1 auto;
        }
        .recent-meta h6 {
            font-size: .92rem;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 .25rem;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color .25s ease;
        }
        .recent-link:hover .recent-meta h6 { color: var(--brand); }
        .recent-date {
            font-size: .76rem;
            color: #888;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }
        .recent-date i { color: var(--brand); }

        .widget-cta {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            margin-top: 1.2rem;
            font-size: .85rem;
            font-weight: 700;
            color: var(--brand) !important;
            text-decoration: none !important;
            letter-spacing: .04em;
            text-transform: uppercase;
            transition: all .25s ease;
        }
        .widget-cta i { transition: transform .25s ease; }
        .widget-cta:hover { color: var(--brand-deep) !important; }
        .widget-cta:hover i { transform: translateX(4px); }

        /* CTA Widget */
        .cta-widget {
            background: linear-gradient(135deg, var(--brand) 0%, #7a4128 100%);
            color: #fff;
            text-align: center;
            padding: 2rem 1.6rem;
        }
        .cta-widget .cta-icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            background: rgba(255,255,255,.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
        }
        .cta-widget h5 {
            color: #fff;
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0 0 .55rem;
        }
        .cta-widget p {
            color: rgba(255,255,255,.85);
            font-size: .9rem;
            line-height: 1.6;
            margin: 0 0 1.2rem;
        }
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: #fff;
            color: var(--brand) !important;
            padding: .75rem 1.3rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: .85rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            text-decoration: none !important;
            transition: all .3s cubic-bezier(.2,.7,.2,1);
        }
        .cta-btn:hover {
            background: #1a1a1a;
            color: #fff !important;
            transform: translateY(-3px);
            box-shadow: 0 12px 22px rgba(0,0,0,.18);
        }
        .cta-btn i { transition: transform .25s ease; }
        .cta-btn:hover i { transform: translateX(4px); }

        /* On-scroll reveal */
        [data-reveal] {
            opacity: 0;
            transition: opacity .9s ease, transform .9s cubic-bezier(.2,.7,.2,1);
        }
        [data-reveal="up"]    { transform: translateY(28px); }
        [data-reveal="left"]  { transform: translateX(-28px); }
        [data-reveal="right"] { transform: translateX(28px); }
        [data-reveal].is-revealed {
            opacity: 1;
            transform: translate(0, 0);
        }

        /* =================== RESPONSIVE =================== */
        @media (max-width: 991px) {
            .article-hero { min-height: 50vh; padding-top: 6rem; }
            .article-hero-inner { padding-bottom: 2.5rem; }
            .article-section { padding: 3rem 0 3.5rem; }
            .article-card,
            .comment-card { padding: 1.8rem 1.5rem; }
            .article-footer { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 575px) {
            .article-hero { min-height: 44vh; padding-top: 5rem; }
            .article-hero-inner { padding-bottom: 2rem; }
            .article-title { font-size: 1.5rem; }
            .article-meta { gap: .8rem 1rem; font-size: .82rem; }
            .article-crumb .current { max-width: 160px; }
            .article-card,
            .comment-card { padding: 1.4rem 1.2rem; border-radius: 12px; }
            .article-feature-img { margin-bottom: 1.2rem; }
            .article-feature-frame { border-radius: 10px; }
            .article-feature-caption { font-size: .76rem; padding: .35rem .7rem; }
            .article-lead::first-letter { font-size: 2.6rem; padding: 0 .5rem 0 0; }
            .share-btn { width: 34px; height: 34px; font-size: .85rem; }
            .recent-thumb { flex-basis: 70px; width: 70px; height: 54px; }
            .recent-meta h6 { font-size: .85rem; }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            [data-reveal],
            .article-hero-bg,
            .share-btn,
            .article-tags a,
            .comment-submit,
            .recent-link,
            .recent-thumb img,
            .cta-btn,
            .article-back {
                transition: none !important;
            }
            [data-reveal] { opacity: 1; transform: none; }
            .article-hero-bg { transform: scale(1); }
            .reading-progress { display: none; }
        }
    </style>
</head>

<body class="inner-page blog-details-page">
    <!-- Wrapper -->
    <div id="wrapper">
       <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

     <?php
        // Safe defaults so the page still renders if the blog id is missing/invalid.
        $blog_title       = '';
        $blog_description = '';
        $blog_date        = '';
        $img              = '';

        if (!empty($blogid) && $blogid > 0) {
            $cmd    = "select * from blog where id='" . (int)$blogid . "'";
            $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
            $row    = mysqli_fetch_array($result);

            if ($row) {
                $blog_title       = $row['blog_title'];
                $blog_description = $row['blog_description'];
                $blog_date        = $row['blog_date'];
                $img              = $row['img'];
            }
        }

        // ---- Derived data for the article UI ----
        $word_count   = str_word_count(strip_tags($blog_description));
        $reading_min  = max(1, (int) ceil($word_count / 200));
        $hero_img     = $img ? 'admin/blog_image/' . $img : 'images/bg/about-us.jpg';
        $share_url    = 'https://www.boskfurniture.com/details?astringdata=' . urlencode((string)$blogid);
        $share_title  = $blog_title;
        ?>

        <!-- Reading progress bar -->
        <div class="reading-progress" id="readingProgress" aria-hidden="true"></div>

        <!-- =================== ARTICLE HERO =================== -->
        <section class="article-hero" data-reveal-section>
            <div class="article-hero-bg" style="background-image: url('<?php echo htmlspecialchars($hero_img, ENT_QUOTES, 'UTF-8'); ?>');"></div>
            <div class="article-hero-overlay"></div>
            <div class="container article-hero-inner">
                <a href="blog-full-list.php" class="article-back" data-reveal="up">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Blog
                </a>
                <div class="article-hero-content" data-reveal="up">
                    <span class="article-category">
                        <i class="fa fa-bookmark" aria-hidden="true"></i> Bosk Insights
                    </span>
                    <h1 class="article-title"><?php echo $blog_title ? htmlspecialchars($blog_title, ENT_QUOTES, 'UTF-8') : 'Blog Article'; ?></h1>
                    <div class="article-meta">
                        <?php if (!empty($blog_date)) : ?>
                        <span class="meta-item"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo htmlspecialchars(($blog_date ? date('Y-m-d', strtotime($blog_date)) : ''), ENT_QUOTES, 'UTF-8'); ?></span>
                        <?php endif; ?>
                        <span class="meta-item"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $reading_min; ?> min read</span>
                        <span class="meta-item"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Bosk Team</span>
                    </div>
                </div>
            </div>
            <nav class="article-crumb" aria-label="Breadcrumb">
                <div class="container">
                    <a href="index.php">Home</a>
                    <span aria-hidden="true">»</span>
                    <a href="blog-full-list.php">Blog</a>
                    <span aria-hidden="true">»</span>
                    <span class="current"><?php echo $blog_title ? htmlspecialchars($blog_title, ENT_QUOTES, 'UTF-8') : 'Article'; ?></span>
                </div>
            </nav>
        </section>

        <!-- =================== ARTICLE BODY + SIDEBAR =================== -->
        <section class="article-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <article class="article-card" data-reveal="up">
                            <?php if (!empty($img)) : ?>
                            <figure class="article-feature-img">
                                <div class="article-feature-frame">
                                    <img src="admin/blog_image/<?php echo htmlspecialchars($img, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($blog_title, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                                </div>
                                <figcaption class="article-feature-caption">
                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                    <?php echo htmlspecialchars($blog_title, ENT_QUOTES, 'UTF-8'); ?>
                                </figcaption>
                            </figure>
                            <?php endif; ?>
                            <div class="article-content">
                                <p class="article-lead"><?php echo $blog_description ? nl2br(htmlspecialchars($blog_description, ENT_QUOTES, 'UTF-8')) : 'This article is being prepared. Please check back soon.'; ?></p>
                            </div>

                            <div class="article-footer">
                                <div class="article-tags">
                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                    <a href="blog-full-list.php">Furniture</a>
                                    <a href="blog-full-list.php">Interior</a>
                                    <a href="blog-full-list.php">Home Decor</a>
                                </div>
                                <div class="article-share">
                                    <span class="share-label">Share</span>
                                    <a class="share-btn share-fb" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($share_url); ?>" aria-label="Share on Facebook"><i class="fa fa-facebook"></i></a>
                                    <a class="share-btn share-tw" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?url=<?php echo urlencode($share_url); ?>&text=<?php echo urlencode($share_title); ?>" aria-label="Share on Twitter"><i class="fa fa-twitter"></i></a>
                                    <a class="share-btn share-wa" target="_blank" rel="noopener" href="https://wa.me/?text=<?php echo urlencode($share_title . ' ' . $share_url); ?>" aria-label="Share on WhatsApp"><i class="fa fa-whatsapp"></i></a>
                                    <a class="share-btn share-li" target="_blank" rel="noopener" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($share_url); ?>" aria-label="Share on LinkedIn"><i class="fa fa-linkedin"></i></a>
                                    <button type="button" class="share-btn share-copy" data-copy-url="<?php echo htmlspecialchars($share_url, ENT_QUOTES, 'UTF-8'); ?>" aria-label="Copy link"><i class="fa fa-link"></i></button>
                                </div>
                            </div>
                        </article>

                        <!-- Comment form -->
                        <section class="comment-card" data-reveal="up">
                            <div class="comment-heading">
                                <span class="comment-eyebrow"><span class="eyebrow-line"></span>Join the conversation</span>
                                <h3>Leave a Comment</h3>
                                <p class="comment-sub">Got thoughts on this article? We'd love to hear what you think.</p>
                            </div>
                            <form onsubmit="return validateAndSubmitComment(this);" id="MyForm" method="post" class="comment-form" novalidate>
                                <div class="row">
                                    <div class="col-md-6 form-group" data-field="name">
                                        <label for="cf-name">Your Name<span class="req">*</span></label>
                                        <input id="cf-name" type="text" name="name" class="form-control" placeholder="e.g. Ravi Patel" autocomplete="name" maxlength="60">
                                        <small class="error-msg"></small>
                                    </div>
                                    <div class="col-md-6 form-group" data-field="email">
                                        <label for="cf-email">Email<span class="req">*</span></label>
                                        <input id="cf-email" type="email" name="email" class="form-control" placeholder="you@example.com" autocomplete="email" maxlength="80">
                                        <small class="error-msg"></small>
                                    </div>
                                    <div class="col-md-12 form-group" data-field="phone">
                                        <label for="cf-phone">Contact Number<span class="req">*</span></label>
                                        <input id="cf-phone" type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" autocomplete="tel" inputmode="numeric" maxlength="10">
                                        <small class="error-msg"></small>
                                    </div>
                                    <div class="col-md-12 form-group" data-field="msg">
                                        <label for="cf-msg">Your Comment<span class="req">*</span></label>
                                        <textarea id="cf-msg" class="form-control" name="msg" rows="6" placeholder="Share your thoughts..." maxlength="1000"></textarea>
                                        <small class="error-msg"></small>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="comment-submit">
                                            <span>Post Comment</span>
                                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div id="return"></div>
                        </section>
                    </div>

                    <!-- =================== SIDEBAR =================== -->
                    <aside class="col-lg-4 col-md-12 article-sidebar">
                        <div class="sidebar-sticky">
                            <div class="widget recent-widget" data-reveal="up">
                                <div class="widget-heading">
                                    <span class="widget-eyebrow"><span class="eyebrow-line"></span>From the Blog</span>
                                    <h5>Recent Posts</h5>
                                </div>
                                <ul class="recent-list">
                                    <?php
                                    include_once "connect.php";
                                    $cmd1    = "select * from blog where blog_date <= NOW() limit 6";
                                    $result1 = mysqli_query($con, $cmd1) or die(mysqli_error($con));
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $rid     = $row1['id'];
                                        $rtitle  = $row1['blog_title'];
                                        $rdate   = $row1['blog_date'];
                                        $rimg    = $row1['img'];
                                        $isActive = ((int)$rid === (int)$blogid);
                                    ?>
                                    <li class="recent-item<?php echo $isActive ? ' is-active' : ''; ?>">
                                        <a class="recent-link" href="details.php?astringdata=<?php echo (int)$rid; ?>">
                                            <span class="recent-thumb">
                                                <img src="admin/blog_image/<?php echo htmlspecialchars($rimg, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($rtitle, ENT_QUOTES, 'UTF-8'); ?>" loading="lazy">
                                            </span>
                                            <span class="recent-meta">
                                                <h6><?php echo htmlspecialchars($rtitle, ENT_QUOTES, 'UTF-8'); ?></h6>
                                                <?php if (!empty($rdate)) : ?>
                                                <span class="recent-date"><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo htmlspecialchars(($rdate ? date('Y-m-d', strtotime($rdate)) : ''), ENT_QUOTES, 'UTF-8'); ?></span>
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                                <a class="widget-cta" href="blog-full-list.php">
                                    View All Posts <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>

                            <div class="widget cta-widget" data-reveal="up">
                                <div class="cta-icon"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                                <h5>Need design help?</h5>
                                <p>Talk to our design team about your space — wardrobes, kitchens, beds and more.</p>
                                <a href="contact.php" class="cta-btn">Get in Touch <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
        <!-- END SECTION BLOG -->

          <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <!-- Wrapper / End -->
    <script src="js/add/comment.js"></script>
    <script>
        (function () {
            // 1) Reading progress bar
            var bar = document.getElementById('readingProgress');
            if (bar) {
                var tick = function () {
                    var h = document.documentElement;
                    var max = (h.scrollHeight - h.clientHeight) || 1;
                    var pct = Math.min(100, Math.max(0, (h.scrollTop / max) * 100));
                    bar.style.width = pct + '%';
                };
                window.addEventListener('scroll', tick, { passive: true });
                window.addEventListener('resize', tick);
                tick();
            }

            // 2) Scroll reveal
            var revealEls = document.querySelectorAll('[data-reveal], [data-reveal-section]');
            if (revealEls.length) {
                if (!('IntersectionObserver' in window) ||
                    window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    revealEls.forEach(function (el) { el.classList.add('is-revealed'); });
                } else {
                    var io = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('is-revealed');
                                io.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
                    revealEls.forEach(function (el) { io.observe(el); });
                }
            }

            // 3) Comment form validation (mirrors contact.php pattern)
            var commentForm = document.getElementById('MyForm');
            if (commentForm) {
                var rules = {
                    name: function (v) {
                        if (!v.trim()) return 'Please enter your name.';
                        if (v.trim().length < 2) return 'Name must be at least 2 characters.';
                        if (!/^[A-Za-z\s.'-]{2,60}$/.test(v.trim())) return 'Only letters, spaces and . \' - are allowed.';
                        return '';
                    },
                    email: function (v) {
                        if (!v.trim()) return 'Please enter your email address.';
                        if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v.trim())) return 'Please enter a valid email address.';
                        return '';
                    },
                    phone: function (v) {
                        if (!v.trim()) return 'Please enter your contact number.';
                        if (!/^[6-9]\d{9}$/.test(v.trim())) return 'Enter a valid 10-digit Indian mobile number.';
                        return '';
                    },
                    msg: function (v) {
                        if (!v.trim()) return 'Please type a comment.';
                        if (v.trim().length < 10) return 'Comment should be at least 10 characters.';
                        if (v.trim().length > 1000) return 'Comment must be under 1000 characters.';
                        return '';
                    }
                };

                var getGroup = function (field) {
                    return commentForm.querySelector('.form-group[data-field="' + field + '"]');
                };

                var showError = function (field, msg) {
                    var g = getGroup(field);
                    if (!g) return;
                    var errEl = g.querySelector('.error-msg');
                    if (msg) {
                        g.classList.add('has-error');
                        if (errEl) errEl.textContent = msg;
                    } else {
                        g.classList.remove('has-error');
                        if (errEl) errEl.textContent = '';
                    }
                };

                var validateField = function (field) {
                    var rule = rules[field];
                    if (!rule) return true;
                    var input = commentForm.querySelector('[name="' + field + '"]');
                    var value = input ? (input.value || '') : '';
                    var msg = rule(value);
                    showError(field, msg);
                    return msg === '';
                };

                var validateAll = function () {
                    var ok = true;
                    Object.keys(rules).forEach(function (f) {
                        if (!validateField(f)) ok = false;
                    });
                    return ok;
                };

                // Restrict phone input to digits only
                var phoneInput = commentForm.querySelector('[name="phone"]');
                if (phoneInput) {
                    phoneInput.addEventListener('input', function () {
                        this.value = this.value.replace(/\D/g, '').slice(0, 10);
                    });
                }

                // Live validation on blur and while correcting
                Object.keys(rules).forEach(function (f) {
                    var input = commentForm.querySelector('[name="' + f + '"]');
                    if (!input) return;
                    input.addEventListener('input', function () {
                        var g = getGroup(f);
                        if (g && g.classList.contains('has-error')) validateField(f);
                    });
                    input.addEventListener('blur', function () {
                        var g = getGroup(f);
                        if (input.value.trim() !== '' || (g && g.classList.contains('has-error'))) {
                            validateField(f);
                        }
                    });
                });

                window.validateAndSubmitComment = function (formEl) {
                    if (!validateAll()) {
                        var firstErr = commentForm.querySelector('.form-group.has-error input, .form-group.has-error textarea');
                        if (firstErr) firstErr.focus();
                        return false;
                    }
                    if (typeof contact_us === 'function') {
                        return contact_us(formEl);
                    }
                    return true;
                };
            }

            // 4) Copy share link
            var copyBtn = document.querySelector('.share-copy');
            if (copyBtn) {
                copyBtn.addEventListener('click', function () {
                    var url = copyBtn.getAttribute('data-copy-url') || window.location.href;
                    var done = function () {
                        copyBtn.classList.add('is-copied');
                        var icon = copyBtn.querySelector('i');
                        var originalIcon = icon ? icon.className : '';
                        if (icon) icon.className = 'fa fa-check';
                        setTimeout(function () {
                            copyBtn.classList.remove('is-copied');
                            if (icon && originalIcon) icon.className = originalIcon;
                        }, 1800);
                    };
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(url).then(done).catch(function () {
                            // fallback below
                            fallback();
                        });
                    } else {
                        fallback();
                    }
                    function fallback() {
                        var ta = document.createElement('textarea');
                        ta.value = url;
                        ta.style.position = 'fixed';
                        ta.style.opacity = '0';
                        document.body.appendChild(ta);
                        ta.select();
                        try { document.execCommand('copy'); done(); } catch (e) { /* no-op */ }
                        document.body.removeChild(ta);
                    }
                });
            }
        })();
    </script>
</body>

</html>
<?php
}
?>