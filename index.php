<?php
// Start the session BEFORE any output so nav1.php's session_start() doesn't trigger
// a "headers already sent" warning. Guarded so it never collides with a prior start.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title       = 'Bosk Furniture | Custom Modular Furniture in India';
$page_description = 'Custom modular kitchens, wardrobes, sofas, beds & interior furniture by Bosk Furniture — premium quality with free shipping across India.';
$page_keywords    = 'bosk furniture, modular furniture india, online furniture store, modular kitchen, wardrobe, sofa, bed, dining set, custom furniture, interior design india';
$page_canonical   = '/';
// Let design/seo-meta.php pick the OG image — it falls back to slider/2.jpg
// if /images/og-default.jpg hasn't been uploaded yet.
$page_breadcrumbs = [
    ['name' => 'Home', 'url' => '/']
];
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once "design/seo-meta.php"; ?>
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500,600,700%7COpen+Sans:300,400" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Slider Revolution CSS Files -->
    <link rel="stylesheet" href="revolution/css/settings.css">
    <link rel="stylesheet" href="revolution/css/layers.css">
    <link rel="stylesheet" href="revolution/css/navigation.css">
    <!-- ARCHIVES CSS -->
    <link rel="stylesheet" href="css/slider-home18.css">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/aos2.css">
    <link rel="stylesheet" href="css/slick.css">
    <link href="css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/lightcase.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link href="css/menu.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <!-- Note: site-wide FurnitureStore + Organization JSON-LD is emitted by design/seo-meta.php.
         No duplicate schema block needed here. -->

    <style>
        .recent-img16 {}

        @media screen and (min-width: 991px) {
            .btn-class-view-all {
                margin-left: 80.8vw;
                margin-top: -6.3vw;
            }
        }

        @media screen and (max-width: 990px) {
            .btn-class-view-all {
                margin-top: -11.3vw;
            }
        }

        @media screen and (min-width: 991px) {
            .btn-class-view-all1 {
                margin-left: 60.8vw;
                margin-top: -6.3vw;
            }
        }

        @media screen and (max-width: 990px) {
            .btn-class-view-all1 {
                margin-top: -11.3vw;
            }
        }

        /* Hero image dark overlay + soft gradient so heading/buttons stay readable */
        #hero-area.home-1 {
            position: relative;
        }

        #hero-area.home-1::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.65) 0%,
                    rgba(0, 0, 0, 0.45) 45%,
                    rgba(0, 0, 0, 0.55) 100%);
            z-index: 1;
            pointer-events: none;
        }

        #hero-area.home-1 .hero-main,
        #hero-area.home-1 .container {
            position: relative;
            z-index: 2;
        }

        #hero-area.home-1 .welcome-text h1,
        #hero-area.home-1 .welcome-text p {
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.75);
        }

        #hero-area.home-1 .hero-buttons .btn {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.45);
        }

        /* Hero layout: heading, text and buttons all centered together in the middle of the image */
        #hero-area.home-1 .hero-inner {
            margin: 0 !important;
            position: relative;
            min-height: 85vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        #hero-area.home-1 .welcome-text {
            margin: 0;
        }

        #hero-area.home-1 .hero-buttons {
            margin-top: 30px;
            text-align: center;
        }

        #hero-area.home-1 .hero-buttons .btn {
            margin: 0 8px !important;
        }

        @media (max-width: 767px) {
            #hero-area.home-1 .hero-buttons {
                margin-top: 20px;
            }

            #hero-area.home-1 .hero-buttons .btn {
                margin: 6px !important;
            }
        }

        /* ============ BLOG SECTION REDESIGN ============ */
        .blog-section .blog-card {
            position: relative;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
            transition: transform .45s cubic-bezier(.25, .8, .25, 1),
                box-shadow .45s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-section .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.18);
        }

        .blog-section .blog-card-img {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 10;
            background: #f2f2f2;
        }

        .blog-section .blog-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .8s ease, filter .5s ease;
        }

        .blog-section .blog-card:hover .blog-card-img img {
            transform: scale(1.12);
            filter: brightness(.85);
        }

        .blog-section .blog-card-img::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, .55) 0%, rgba(0, 0, 0, 0) 55%);
            opacity: 0;
            transition: opacity .5s ease;
        }

        .blog-section .blog-card:hover .blog-card-img::after {
            opacity: 1;
        }

        .blog-section .blog-date-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: #532A1A;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .5px;
            line-height: 1.2;
            z-index: 2;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .2);
            transition: transform .4s ease;
        }

        .blog-section .blog-card:hover .blog-date-badge {
            transform: translateY(-3px);
        }

        .blog-section .blog-card-body {
            padding: 22px 24px 26px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .blog-section .blog-meta {
            font-size: 12px;
            color: #888;
            letter-spacing: .4px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .blog-section .blog-meta i {
            color: #532A1A;
            margin-right: 5px;
        }

        .blog-section .blog-card-body h3 {
            font-size: 20px;
            font-weight: 700;
            line-height: 1.3;
            margin: 0 0 12px;
            color: #222;
            transition: color .35s ease;
        }

        .blog-section .blog-card-body h3 a {
            color: inherit;
            text-decoration: none;
        }

        .blog-section .blog-card:hover .blog-card-body h3 {
            color: #532A1A;
        }

        .blog-section .blog-card-body p {
            font-size: 14px;
            line-height: 1.6;
            color: #666;
            margin: 0 0 18px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blog-section .blog-read-more {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #532A1A;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            margin-top: auto;
            position: relative;
            width: fit-content;
        }

        .blog-section .blog-read-more::after {
            content: "→";
            display: inline-block;
            transition: transform .35s ease;
        }

        .blog-section .blog-read-more:hover {
            color: #211610;
        }

        .blog-section .blog-read-more:hover::after {
            transform: translateX(6px);
        }

        @media (max-width: 575px) {
            .blog-section .blog-card-body {
                padding: 18px 18px 22px;
            }

            .blog-section .blog-card-body h3 {
                font-size: 17px;
            }
        }

        /* ============ RECENT PROJECTS REDESIGN ============ */
        .recently .project-card {
            position: relative;
            display: block;
            width: 100%;
            aspect-ratio: 4 / 5;
            border-radius: 14px;
            overflow: hidden;
            background: #111;
            box-shadow: 0 6px 22px rgba(0, 0, 0, 0.10);
            transition: transform .5s cubic-bezier(.25, .8, .25, 1),
                box-shadow .5s ease;
            text-decoration: none;
        }

        .recently .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 46px rgba(0, 0, 0, 0.22);
        }

        .recently .project-card-img {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 1s cubic-bezier(.25, .8, .25, 1);
        }

        .recently .project-card:hover .project-card-img {
            transform: scale(1.12);
        }

        .recently .project-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.85) 0%,
                    rgba(0, 0, 0, 0.45) 50%,
                    rgba(0, 0, 0, 0.10) 100%);
            opacity: 0.65;
            transition: opacity .5s ease;
            z-index: 1;
        }

        .recently .project-card:hover .project-card-overlay {
            opacity: 1;
        }

        .recently .project-tag {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 2;
            background: #532A1A;
            color: #fff;
            padding: 6px 13px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.28);
            transition: transform .4s ease;
        }

        .recently .project-card:hover .project-tag {
            transform: translateY(-3px);
        }

        .recently .project-card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 26px 22px 24px;
            color: #fff;
            z-index: 2;
            transform: translateY(34px);
            transition: transform .55s cubic-bezier(.25, .8, .25, 1);
        }

        .recently .project-card:hover .project-card-content {
            transform: translateY(0);
        }

        .recently .project-card-title {
            font-size: 19px;
            font-weight: 700;
            line-height: 1.3;
            margin: 0 0 14px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .recently .project-card-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #fff;
            padding: 8px 18px;
            border: 1.5px solid rgba(255, 255, 255, 0.75);
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.08);
            -webkit-backdrop-filter: blur(4px);
            backdrop-filter: blur(4px);
            opacity: 0;
            transition: opacity .35s ease .12s,
                background .3s ease;
        }

        .recently .project-card:hover .project-card-cta {
            opacity: 1;
        }

        .recently .project-card-cta:hover {
            background: #532A1A;
            border-color: #532A1A;
        }

        .recently .project-card-cta::after {
            content: "→";
            transition: transform .35s ease;
        }

        .recently .project-card-cta:hover::after {
            transform: translateX(5px);
        }

        /* Touch devices: show content without hover */
        @media (hover: none) {
            .recently .project-card-content {
                transform: translateY(0);
            }

            .recently .project-card-cta {
                opacity: 1;
            }

            .recently .project-card-overlay {
                opacity: 1;
            }
        }

        @media (max-width: 575px) {
            .recently .project-card {
                aspect-ratio: 4 / 4.5;
            }

            .recently .project-card-title {
                font-size: 17px;
            }
        }

        /* ============ PARTNER LOGO MARQUEE ============ */
        .partners .logo-marquee {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 10px 0;
        }

        .partners .logo-marquee-track {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center;
            width: max-content;
            -webkit-animation: logoScroll 35s linear infinite !important;
            animation: logoScroll 35s linear infinite !important;
            will-change: transform;
        }

        .partners .logo-set {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            flex-shrink: 0;
        }

        .partners .logo-set img {
            flex-shrink: 0 !important;
            height: 100px;
            width: auto;
            max-width: none;
            object-fit: contain;
            display: block;
            margin: 0 45px;
            cursor: pointer;
            filter: grayscale(100%) opacity(.6);
            -webkit-transition: filter .35s ease, -webkit-transform .35s ease;
            transition: filter .35s ease, transform .35s ease;
            -webkit-user-drag: none;
            user-select: none;
            pointer-events: auto;
        }

        /* When the cursor enters the strip: pause + dim every logo slightly */
        .partners .logo-marquee:hover .logo-marquee-track {
            -webkit-animation-play-state: paused;
            animation-play-state: paused;
        }

        .partners .logo-marquee:hover .logo-set img {
            filter: grayscale(100%) opacity(.3);
        }

        /* The one logo under the cursor pops to full color, scales up, glows */
        .partners .logo-marquee .logo-set img:hover {
            filter: grayscale(0%) opacity(1) drop-shadow(0 8px 18px rgba(0, 0, 0, 0.22)) !important;
            -webkit-transform: scale(1.2);
            transform: scale(1.2);
        }

        @-webkit-keyframes logoScroll {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }

            100% {
                -webkit-transform: translateX(-50%);
                transform: translateX(-50%);
            }
        }

        @keyframes logoScroll {
            0% {
                -webkit-transform: translateX(0);
                transform: translateX(0);
            }

            100% {
                -webkit-transform: translateX(-50%);
                transform: translateX(-50%);
            }
        }

        @media (max-width: 991px) {
            .partners .logo-set img {
                height: 75px;
                margin: 0 32px;
            }

            .partners .logo-marquee-track {
                animation-duration: 28s !important;
                -webkit-animation-duration: 28s !important;
            }
        }

        @media (max-width: 575px) {
            .partners .logo-set img {
                height: 58px;
                margin: 0 24px;
            }

            .partners .logo-marquee-track {
                animation-duration: 22s !important;
                -webkit-animation-duration: 22s !important;
            }
        }

        /* ============ RECENT PROJECTS SLIDER ARROWS ============ */
        .homepage-1 .home5-right-slider.owl-carousel {
            position: relative;
        }

        .homepage-1 .home5-right-slider.owl-carousel .owl-stage-outer {
            position: relative;
            overflow: hidden !important;
        }

        /* Allow ancestors of the arrows to render outside their normal box so
           absolutely-positioned arrows are never clipped */
        .recently,
        .recently .portfolio,
        .recently .right-slider,
        .homepage-1 .home5-right-slider.owl-carousel {
            overflow: visible !important;
        }

        /* Overlay the nav exactly on the slide area, so top:50% = middle of cards */
        .homepage-1 .home5-right-slider.owl-carousel .owl-nav {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            pointer-events: none !important;
            height: auto !important;
        }

        .homepage-1 .home5-right-slider.owl-carousel .owl-prev,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next {
            position: absolute !important;
            top: 50% !important;
            margin: 0 !important;
            padding: 0 !important;
            pointer-events: auto !important;
            -webkit-transform: translateY(-50%) !important;
            transform: translateY(-50%) !important;
            width: 54px !important;
            height: 54px !important;
            border-radius: 50% !important;
            background: linear-gradient(135deg, #6b3823 0%, #532A1A 60%, #3a1c10 100%) !important;
            color: #ffffff !important;
            display: -webkit-box !important;
            display: -ms-flexbox !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 18px !important;
            line-height: 1 !important;
            box-shadow:
                0 8px 22px rgba(83, 42, 26, 0.35),
                inset 0 0 0 2px rgba(255, 255, 255, 0.18) !important;
            border: none !important;
            z-index: 20 !important;
            opacity: 1 !important;
            overflow: visible !important;
            transition: transform .45s cubic-bezier(.25, .8, .25, 1),
                box-shadow .45s ease,
                background .45s ease !important;
        }

        /* Soft glowing ring that expands on hover */
        .homepage-1 .home5-right-slider.owl-carousel .owl-prev::before,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next::before {
            content: "";
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid rgba(83, 42, 26, 0.35);
            opacity: 0;
            transform: scale(.85);
            transition: opacity .45s ease, transform .55s cubic-bezier(.25, .8, .25, 1);
            pointer-events: none;
        }

        /* Subtle resting pulse to draw the eye */
        .homepage-1 .home5-right-slider.owl-carousel .owl-prev::after,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(83, 42, 26, 0.55);
            animation: arrowPulse 2.4s ease-out infinite;
            pointer-events: none;
        }

        @keyframes arrowPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(83, 42, 26, 0.5);
            }

            70% {
                box-shadow: 0 0 0 16px rgba(83, 42, 26, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(83, 42, 26, 0);
            }
        }

        /* Push both arrows inside the slider so neither edge can clip them */
        .homepage-1 .home5-right-slider.owl-carousel .owl-prev {
            left: 28px !important;
            right: auto !important;
        }

        .homepage-1 .home5-right-slider.owl-carousel .owl-next {
            right: 28px !important;
            left: auto !important;
        }

        /* Hover state */
        .homepage-1 .home5-right-slider.owl-carousel .owl-prev:hover,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next:hover {
            background: linear-gradient(135deg, #7a4128 0%, #532A1A 60%, #2a1208 100%) !important;
            box-shadow:
                0 14px 30px rgba(83, 42, 26, 0.45),
                inset 0 0 0 2px rgba(255, 255, 255, 0.28) !important;
            -webkit-transform: translateY(-50%) scale(1.12) !important;
            transform: translateY(-50%) scale(1.12) !important;
        }

        .homepage-1 .home5-right-slider.owl-carousel .owl-prev:hover::before,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next:hover::before {
            opacity: 1;
            transform: scale(1.15);
            border-color: rgba(83, 42, 26, 0.55);
        }

        /* Pause the resting pulse on hover for a clean focused look */
        .homepage-1 .home5-right-slider.owl-carousel .owl-prev:hover::after,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next:hover::after {
            animation-play-state: paused;
        }

        /* Arrow icon — perfectly centered inside the circle */
        .homepage-1 .home5-right-slider.owl-carousel .owl-prev i,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next i {
            color: inherit !important;
            font-size: 16px !important;
            line-height: 1 !important;
            display: -webkit-inline-box !important;
            display: -ms-inline-flexbox !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 1em;
            height: 1em;
            margin: 0 !important;
            padding: 0 !important;
            text-align: center;
            vertical-align: middle;
            transition: transform .35s cubic-bezier(.25, .8, .25, 1) !important;
        }

        .homepage-1 .home5-right-slider.owl-carousel .owl-prev:hover i {
            transform: translateX(-4px);
        }

        .homepage-1 .home5-right-slider.owl-carousel .owl-next:hover i {
            transform: translateX(4px);
        }

        /* Click press feedback */
        .homepage-1 .home5-right-slider.owl-carousel .owl-prev:active,
        .homepage-1 .home5-right-slider.owl-carousel .owl-next:active {
            -webkit-transform: translateY(-50%) scale(1.02) !important;
            transform: translateY(-50%) scale(1.02) !important;
        }

        @media (max-width: 991px) {

            .homepage-1 .home5-right-slider.owl-carousel .owl-prev,
            .homepage-1 .home5-right-slider.owl-carousel .owl-next {
                width: 44px !important;
                height: 44px !important;
                font-size: 15px !important;
            }

            .homepage-1 .home5-right-slider.owl-carousel .owl-prev {
                left: 14px !important;
            }

            .homepage-1 .home5-right-slider.owl-carousel .owl-next {
                right: 14px !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .homepage-1 .home5-right-slider.owl-carousel .owl-prev::after,
            .homepage-1 .home5-right-slider.owl-carousel .owl-next::after {
                animation: none;
            }
        }
    </style>
</head>

<body class="homepage-1 int_white_bg">
    <!-- Wrapper -->
    <div id="wrapper" class="int_main_wraapper">
        <!-- START SECTION HEADINGS -->
        <!-- Header Container
        ================================================== -->
        <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <!-- SLIDER START -->
        <section id="hero-area" class="parallax-search overlay home-1" data-stellar-background-ratio="0.5">
            <div class="hero-main">
                <div class="container" data-aos="zoom-in">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-inner">
                                <!-- Welcome Text -->
                                <div class="welcome-text">
                                    <h1 style="color:white !important;" class="h1"><b>Guaranteed Modular Furniture</b>
                                        <br class="d-md-none">
                                        <span class="typed border-bottom"></span>
                                    </h1>
                                    <p style="color:white !important;" class="mt-4"><b>Our experience ensures that your
                                            projects will be done right and with the upmost professionalism.</b></p>
                                </div>
                                <!--/ End Welcome Text -->
                                <div class="hero-buttons">
                                    <a href="about-us.php" class="btn btn-default btn-theme-colored2 btn-xl">Read
                                        More</a>
                                    <a href="contact.php" class="btn btn-dark btn-theme-colored btn-xl">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- START SECTION RECENTLY WORKS -->
        <section class="recently portfolio bg-white-3">
            <div class="container-fluid recently-slider">
                <div class="section-title">
                    <h3>Recent</h3>
                    <h2>Projects</h2>
                    <div class="hero-inner btn-class-view-all" style="">
                        <a href="all_products.php" class="btn btn-dark btn-theme-colored btn-xl mt-5">View All</a>
                    </div>
                </div>
                <div class="portfolio right-slider">
                    <div class="owl-carousel home5-right-slider">
                        <?php
                        include_once"connect.php";
                                 
                                  $cmd1="select * from projects order by id DESC limit 12";
                                  $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
                                  while($row1=mysqli_fetch_array($result1))
                                  {     
                                      $project_id = $row1['id'];
                                      $project_name=$row1['project_name'];
                                      $pro_desc=$row1['pro_desc'];
                                      $interior_detail=$row1['interior_detail'];
                                      $img1=$row1['img1'];
                                      $img2=$row1['img2'];
                                      
                                      $encode_project_id=base64_encode($project_id);
                        ?>
                        <div class="inner-box">
                            <a href="project-details.php?astringdata=<?php echo $encode_project_id; ?>"
                                class="project-card" data-aos="fade-up">
                                <div class="project-card-img"
                                    style="background-image: url(Admin/project_image/<?php echo $img1;?>)"></div>
                                <span class="project-tag">Project</span>
                                <div class="project-card-overlay"></div>
                                <div class="project-card-content">
                                    <h4 class="project-card-title">
                                        <?php echo $project_name;?>
                                    </h4>
                                    <span class="project-card-cta">View Details </span>
                                </div>
                            </a>
                        </div>
                        <?php
                                  }
                        ?>
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/17.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Family Apartment</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/18.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Villa House</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/19.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Luxury Condo</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/20.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Luxury House</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/23.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Luxury House</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/24.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Luxury House</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/26.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Luxury House</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                        <!--<a href="masonry-box-project-4.php" class="recent-16" data-aos="fade-up">-->
                        <!--    <div class="recent-img16 img-center" style="background-image: url(images/taken/a/29.jpg);"></div>-->
                        <!--    <div class="recent-content"></div>-->
                        <!--    <div class="recent-details">-->
                        <!--        <div class="recent-title">Luxury House</div>-->
                        <!--        <div class="recent-price">$230,000</div>-->
                        <!--        <div class="house-details">6 Bed <span>|</span> 3 Bath <span>|</span> 720 sq ft</div>-->
                        <!--    </div>-->
                        <!--    <div class="view-proper">View Details</div>-->
                        <!--</a>-->
                    </div>
                </div>
            </div>

        </section>
        <!-- END SECTION RECENTLY WORKS -->

        <section class="all-services bg-white-2">
            <div class="container">
                <div class="section-title">
                    <h3>Our</h3>
                    <h2>Categories</h2>
                </div>
                <div class="row mt-50">
                    <?php
                                         include_once"connect.php";
                                         
                                        //   $cmd2="select * from category ORDER BY name ASC";
                                          $cmd2="SELECT c.id, c.name, c.img, COUNT(*) AS product_count FROM category c LEFT JOIN products p ON c.name = p.pcategory GROUP BY c.id, c.name ORDER BY c.name ASC;";
                                          $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                          while($row2=mysqli_fetch_array($result2))
                                          {     
                                              $categoryid = $row2['id'];
                                              $name=$row2['name'];
                                            //   $encode_name=base64_encode($name);
                                              $img=$row2['img'];
                                              $count=$row2['product_count'];
                                          ?>

                    <div class="col-lg-4 col-xs-6 col-sm-6 col-md-6">
                        <div class="item mb-30">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">
                                    <div class=service-icon-box><img src="Admin/category_image/<?php echo $img;?>"
                                            alt="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture Category" loading="lazy" decoding="async"></div>
                                    <div class="service-content-box mt-1">
                                        <h3><a href="shop.php?astringdata2=<?php echo $row2['name'];?>"><b>
                                                    <?php echo $name;?>
                                                </b></a></h3>
                                        <p>
                                            <?php echo $count;?> Products
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                                          }
                   ?>




                </div>
            </div>
        </section>

        <!-- START SECTION INFO-HELP -->
        <section class="info-help h18">
            <div class="container">
                <div class="row info-head">
                    <div class="col-lg-12 col-md-8 col-xs-8">
                        <div class="info-text" data-aos="fade-up">
                            <h3 style="color:white !important;" class="text-center mb-0"><b>Why Choose Us</b></h3>
                            <p style="color:white !important;" class="text-center mb-4 p-0"><b>Ethical working and
                                    Integrity is our strength</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION INFO-HELP -->

        <!-- START SECTION INFO -->
        <section _ngcontent-bgi-c3="" class="featured-boxes-area">
            <div _ngcontent-bgi-c3="" class="container">
                <div _ngcontent-bgi-c3="" class="featured-boxes-inner">
                    <div _ngcontent-bgi-c3="" class="row m-0">
                        <div _ngcontent-bgi-c3="" class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up">
                            <div _ngcontent-bgi-c3="" class="single-featured-box">
                                <div _ngcontent-bgi-c3="" class="icon color-fb7756"><img src="images/icons/i-5.svg"
                                        width="85" height="85" alt="Uniqueness icon - custom furniture made just for you" loading="lazy" decoding="async"></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">UNIQUENESS</h3>
                                <p _ngcontent-bgi-c3="">The furniture we craft is exclusively as per your taste & hence
                                    has its own uniqueness.</p><a _ngcontent-bgi-c3="" class="read-more-btn"
                                    href="about-us.php">Read More</a>
                            </div>
                        </div>
                        <div _ngcontent-bgi-c3="" class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up">
                            <div _ngcontent-bgi-c3="" class="single-featured-box">
                                <div _ngcontent-bgi-c3="" class="icon color-facd60"><img src="images/icons/i-6.svg"
                                        width="85" height="85" alt="Best finishing icon - machine-edged premium furniture" loading="lazy" decoding="async"></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">BEST FINISHING</h3>
                                <p _ngcontent-bgi-c3="">FINISHING- The furniture is crafted on machines, the edges are
                                    also covered with hot press Edge bands.
                                </p><a _ngcontent-bgi-c3="" class="read-more-btn" href="about-us.php">Read More</a>
                            </div>
                        </div>
                        <div _ngcontent-bgi-c3="" class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up">
                            <div _ngcontent-bgi-c3="" class="single-featured-box">
                                <div _ngcontent-bgi-c3="" class="icon color-1ac0c6"><img src="images/icons/i-7.svg"
                                        width="85" height="85" alt="Cost effective icon - affordable customised furniture India" loading="lazy" decoding="async"></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">COST EFFECTIVE</h3>
                                <p _ngcontent-bgi-c3="">If all the parameters are compared, our crafted furniture should
                                    be economical than other similar products.</p><a _ngcontent-bgi-c3=""
                                    class="read-more-btn" href="about-us.php">Read More</a>
                            </div>
                        </div>
                        <div _ngcontent-bgi-c3="" class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up">
                            <div _ngcontent-bgi-c3="" class="single-featured-box">
                                <div _ngcontent-bgi-c3="" class="icon"><img src="images/icons/i-8.svg" width="85"
                                        height="85" alt="Hygiene icon - factory crafted furniture, on-site fitting only" loading="lazy" decoding="async"></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">HYGIENE</h3>
                                <p _ngcontent-bgi-c3="">The furniture is being crafted at our factory, only erection and
                                    fitting is to be done at customer’s premises.
                                </p><a _ngcontent-bgi-c3="" class="read-more-btn" href="about-us.php">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><br /><br />
        <!-- END SECTION INFO -->

        <!-- START SECTION PROJECTS -->
        <!--<section class="portfolio bg-white-5">-->
        <!--    <div class="container">-->
        <!--        <div class="section-title">-->
        <!--            <h3>Latest</h3>-->
        <!--            <h2>Products</h2>-->
        <!--            <div class="box bg-3">-->
        <!--        <a href="shop.php" class="button button--wayra button--border-thick button--text-upper button--size-s">View All</a>-->
        <!--    </div>-->
        <!--        </div>-->
        <!--        <div class="filters-group">-->
        <!--            <ul>-->
        <!--                <li class="active" data-filter="*">Show All</li>-->
        <!--                <li data-filter=".people">Residential</li>-->
        <!--                <li data-filter=".landscapes">Commercial</li>-->
        <!--                <li data-filter=".web">Office</li>-->
        <!--                <li data-filter=".graphic">Hospitaly</li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--        <div class="row portfolio-items">-->

        <?php
                                // include_once"connect.php";
                                         
                                // $cmd3="select * from products limit 8";
                                // $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
                                // while($row3=mysqli_fetch_array($result3))
                                // {     
                                //      $product_id=$row3['id'];
                                //     $encode_id=base64_encode($product_id);
                                   
                                //     $pname=$row3['pname'];
                                //     $pcategory=$row3['pcategory'];
                                //     $img1=$row3['img1'];
                                //     $img2=$row3['img2'];
                                //     $img3=$row3['img3'];
                                //     $img4=$row3['img4'];
                                //     $img5=$row3['img5'];
                                //     $description=$row3['description'];
                                //     $stock=$row3['stock'];
                                //     $old_price=$row3['old_price'];
                                //     $new_price=$row3['new_price'];
                                //     $tags=$row3['tags'];
                                   
                                ?>
        <!--<div class="item col-lg-3 col-sm-6 col-xs-12 people landscapes last-item two pt">-->
        <!--    <div class="single-portfolio">-->
        <!--        <div class="portfolio-img">-->
        <!--            <a href="product.php?astringdata={encode_id}"><img src="Admin/product_image/{img1}" alt="" /></a>-->

        <!--        </div>-->
        <!--    </div>-->

        <!--        <div class="shop-info bl mb-4">-->
        <!--        <h3 style="color:black !important;" class="text-center"><a href="product.php?astringdata={encode_id}" style="color:black !important;"><b>{pname}</b></a></h3>-->
        <!--        <ul style="margin-top:-2%;" class="starts text-center">-->
        <!--            <li class="mb-0"><i class="fa fa-star"></i>-->
        <!--            </li>-->
        <!--            <li class="mb-0"><i class="fa fa-star"></i>-->
        <!--            </li>-->
        <!--            <li class="mb-0"><i class="fa fa-star"></i>-->
        <!--            </li>-->
        <!--            <li class="mb-0"><i class="fa fa-star"></i>-->
        <!--            </li>-->
        <!--            <li class="mb-0"><i class="fa fa-star"></i>-->
        <!--            </li>-->
        <!--        </ul>-->
        <!--        <p class="product-old-price text-center" style="margin-top:-3%;" >₹{old_price}</p>-->
        <!--        <p class="recent-price text-center" style="margin-top:-2%;">₹{new_price}</p>-->
        <!--        <div class="text-center">-->
        <!--            <a class="btn1 btn-sm" style="font-size:1.1rem !important;" href="product.php?astringdata={encode_id}">View Detail</a>-->
        <!--        </div>-->
        <!--    </div>-->

        <!--</div>-->
        <?php
                                // }
                    ?>
        <!--        </div>-->
        <!--    </div>-->

        <!--</section>-->
        <!-- END SECTION PROJECTS -->

        <!-- START SECTION INFO-HELP -->
        <section class="info-help h17">
            <div class="container">
                <div class="row info-head">
                    <div class="col-lg-6 col-md-8 col-xs-8" data-aos="fade-right">
                        <div class="info-text">
                            <h3>WHY BOSK FURNITURE?</h3>
                            <h5 class="mt-3"><b>Furniture has a personality too!</b></h5>
                            <p class="pt-2">There are countless elements which makes you, uniquely you. Furniture has a
                                personality too! <br />With customized furniture, the spaces can be made to speak the
                                language that the owner wants it to. It can be crafted up to the optimum space
                                available. We at the BOSK INFRACON PRIVATE LIMITED deliver it with highest accuracy a
                                machine can give. Custom-crafted furniture made imported machines can have the perfect
                                fit and be highly efficient. It can be designed to fit your space to the tee. </p>
                            <div class="inf-btn pro">
                                <a href="about-us.php" class="btn btn-pro btn-secondary btn-lg">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION INFO-HELP -->

        <!-- START SECTION TESTIMONIALS -->
        <section class="testimonials bg-white-3">
            <div class="container">
                <div class="section-title">
                    <h3>Happy</h3>
                    <h2>Customers</h2>
                    <!--<div class="box bg-3">-->
                    <!--    <a href="blog-full-list.php" class="button button--wayra button--border-thick button--text-upper button--size-s">View All</a>-->
                    <!--</div>-->
                    <div class="hero-inner btn-class-view-all1" style="">
                        <a href="testimonial.php" class="btn btn-dark btn-theme-colored btn-xl mt-5">View All</a>
                    </div>
                </div>
                <div class="owl-carousel style1">
                    <div class="test-1" data-aos="zoom-in">
                        <h3>S.M. Godhwani</h3>
                        <!--<img src="images/testimonials/ts-1.jpg" alt="">-->
                        <h6 class="mt-2">Rajkot</h6>
                        <br />
                        <p>Today visited this showroom, and Today treated very nicely, gone through entire products and
                            found very quality products with transperent rate Analysis.be the customer Definitely will
                            be the customer of this Showroom.<br />Thank You..!</p><br />
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Rajesh Deomurari</h3>
                        <!--<img src="images/testimonials/ts-2.jpg" alt="">-->
                        <h6 class="mt-2">Ahmedabad</h6>
                        <br />
                        <p>A much required system.I was astonish to hear that planning furniture in house is so
                            systematic.He has scientific approach And very effective thing is transperary in the work.
                            He is after quality and workmanship,He has vision and good imagination power. I wish all my
                            heart wish him a great Success.</p>
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Jay Patel</h3>
                        <!--<img src="images/testimonials/ts-6.jpg" alt="">-->
                        <h6 class="mt-2">Amreli</h6>
                        <br />
                        <p>I am pleased with the explanation about products and material range was really exiting..I
                            really recommended this service to others with explanations..I really like to apperieciate
                            the amount of time spend to walk their different days of concepts..<br />Thank You..</p>
                        <br />
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Kaivalya Pathak</h3>
                        <!--<img src="images/testimonials/ts-4.jpg" alt="">-->
                        <h6 class="mt-2">Jamnagar</h6>
                        <br />
                        <p>Came here for first time and we appericiate the concept and kind of dsesign you provide at
                            minimal rate.We liked the ambiance as well as the staff and way they explained their design
                            and work..Overall Great Visit..!!</p><br /><br />
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Abhishek Mehta</h3>
                        <!--<img src="images/testimonials/ts-2.jpg" alt="">-->
                        <h6 class="mt-2">Junagadh</h6>
                        <br />
                        <p>I am working in Import-Export department at bhavnagar.I am visiting at your gallery Bosk
                            Furniture.I am happy to share my feedback that very simple and beautiful structure with
                            color combination.I will contact to you in future whenever i required..Thanks..</p><br />
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Sandip Chauhan</h3>
                        <!--<img src="images/testimonials/ts-6.jpg" alt="">-->
                        <h6 class="mt-2">Vadodara</h6>
                        <br />
                        <p>Showroom lights and color combination is very good..Very good over selection for color at
                            showroom..For concept of furniture making i personally fell time saving compare to making
                            all things on site..<br />Thanks..</p><br /><br />
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION TESTIMONIALS -->

        <!-- START SECTION BLOG -->
        <section class="blog-section bg-white-5">
            <div class="container">
                <div class="section-title">
                    <h3>Latest</h3>
                    <h2>Blog</h2>
                    <!--<div class="box bg-3">-->
                    <!--    <a href="blog-full-list.php" class="button button--wayra button--border-thick button--text-upper button--size-s">View All</a>-->
                    <!--</div>-->
                    <div class="hero-inner btn-class-view-all1" style="">
                        <a href="blog-full-list.php" class="btn btn-dark btn-theme-colored btn-xl mt-5">View All</a>
                    </div>
                </div>
                <div class="news-wrap">
                    <div class="row">
                        <?php
                        include_once"connect.php";
                                         
                        $cmd4="select * from blog where blog_date <= NOW() order by id DESC limit 4";
                        $result4=mysqli_query($con,$cmd4) or die(mysqli_error($con));
                        while($row4=mysqli_fetch_array($result4))
                        {     
                            $blogid = $row4['id'];
                            $encodeblog_id=base64_encode($blogid);
                            $blog_title=$row4['blog_title'];
                            $blog_description=$row4['blog_description'];
                            $blog_date=$row4['blog_date'];
                            $img=$row4['img'];
                        ?>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mt-5" data-aos="fade-up">
                            <article class="blog-card">
                                <a href="details.php?astringdata=<?php echo $encodeblog_id; ?>" class="blog-card-img">
                                    <img src="Admin/blog_image/<?php echo $img;?>"
                                        alt="<?php echo htmlspecialchars($blog_title); ?>">
                                    <span class="blog-date-badge">
                                        <?php echo ($blog_date ? date('Y-m-d', strtotime($blog_date)) : '');?>
                                    </span>
                                </a>
                                <div class="blog-card-body">
                                    <div class="blog-meta">
                                        <i class="fa fa-user"></i> By Admin
                                    </div>
                                    <h3><a href="details.php?astringdata=<?php echo $encodeblog_id; ?>">
                                            <?php echo $blog_title;?>
                                        </a></h3>
                                    <p>
                                        <?php echo strip_tags($blog_description);?>
                                    </p>
                                    <a href="details.php?astringdata=<?php echo $encodeblog_id; ?>"
                                        class="blog-read-more">Read more </a>
                                </div>
                            </article>
                        </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION BLOG -->

        <!-- STAR SECTION PARTNERS -->
        <div class="partners bg-white-3 border-0">
            <div class="logo-marquee">
                <div class="logo-marquee-track">
                    <?php
                    // Render the same set twice so translateX(-50%) loops seamlessly.
                    for ($pass = 0; $pass < 2; $pass++) {
                        echo '<div class="logo-set"' . ($pass === 1 ? ' aria-hidden="true"' : '') . '>';
                        for ($i = 1; $i <= 10; $i++) {
                            echo '<img src="images/partners/' . $i . '.png" alt="Partner ' . $i . '">';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- END SECTION PARTNERS -->

        <!-- START FOOTER -->
        <?php include_once"design/footer1.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <!-- START PRELOADER -->
        <div id="preloader">
            <div id="status">
                <div class="status-mes"></div>
            </div>
        </div>
        <!-- END PRELOADER -->

        <!-- ARCHIVES JS -->
        <script src="js/jquery.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mmenu.min.js"></script>
        <script src="js/mmenu.js"></script>
        <script src="js/aos.js"></script>
        <script src="js/aos2.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/slick.js"></script>
        <script src="js/jquery.easing.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/typed.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/lightcase.js"></script>
        <script src="js/owl.carousel.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>

        <!-- Slider Revolution scripts -->
        <script src="revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.carousel.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.migration.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.parallax.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="revolution/js/extensions/revolution.extension.video.min.js"></script>

        <script>
            var tpj = jQuery;
            var revapi26;
            tpj(document).ready(function () {
                if (tpj("#rev_slider_26_1").revolution == undefined) {
                    revslider_showDoubleJqueryError("#rev_slider_26_1");
                } else {
                    revapi26 = tpj("#rev_slider_26_1").show().revolution({
                        sliderType: "standard",
                        jsFileLocation: "revolution/js/",
                        sliderLayout: "fullscreen",
                        dottedOverlay: "none",
                        delay: 9000,
                        navigation: {
                            keyboardNavigation: "off",
                            keyboard_direction: "horizontal",
                            mouseScrollNavigation: "off",
                            mouseScrollReverse: "default",
                            onHoverStop: "off",
                            touch: {
                                touchenabled: "on",
                                touchOnDesktop: "off",
                                swipe_threshold: 75,
                                swipe_min_touches: 50,
                                swipe_direction: "horizontal",
                                drag_block_vertical: false
                            },

                            arrows: {
                                style: "metis",
                                enable: true,
                                hide_onmobile: false,
                                hide_onleave: false,
                                tmp: '',
                                left: {
                                    h_align: "right",
                                    v_align: "bottom",
                                    h_offset: 80,
                                    v_offset: 10
                                },
                                right: {
                                    h_align: "right",
                                    v_align: "bottom",
                                    h_offset: 10,
                                    v_offset: 10
                                }
                            },
                            bullets: {
                                enable: false,
                                hide_onmobile: false,
                                style: "bullet-bar",
                                hide_onleave: false,
                                direction: "horizontal",
                                h_align: "right",
                                v_align: "bottom",
                                h_offset: 30,
                                v_offset: 30,
                                space: 5,
                                tmp: ''
                            }
                        },
                        responsiveLevels: [1240, 1024, 778, 480],
                        visibilityLevels: [1240, 1024, 778, 480],
                        gridwidth: [1270, 1024, 778, 480],
                        gridheight: [729, 600, 600, 480],
                        lazyType: "none",
                        parallax: {
                            type: "scroll",
                            origo: "slidercenter",
                            speed: 2000,
                            levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 51, 55],
                        },
                        shadow: 0,
                        spinner: "off",
                        stopLoop: "off",
                        stopAfterLoops: -1,
                        stopAtSlide: -1,
                        shuffle: "off",
                        autoHeight: "off",
                        fullScreenAutoWidth: "off",
                        fullScreenAlignForce: "off",
                        fullScreenOffsetContainer: ".site-header",
                        fullScreenOffset: "0px",
                        hideThumbsOnMobile: "off",
                        hideSliderAtLimit: 0,
                        hideCaptionAtLimit: 0,
                        hideAllCaptionAtLilmit: 0,
                        debugMode: false,
                        fallbacks: {
                            simplifyAll: "off",
                            nextSlideOnWindowFocus: "off",
                            disableFocusListener: false,
                        }
                    });
                }
            }); /*ready*/

        </script>
        <script>
            $('.home5-right-slider').owlCarousel({
                loop: true,
                margin: 30,
                dots: false,
                nav: true,
                rtl: false,
                autoplayHoverPause: false,
                autoplay: false,
                singleItem: true,
                smartSpeed: 1200,
                navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
                responsive: {
                    0: {
                        items: 1,
                        center: false
                    },
                    480: {
                        items: 1,
                        center: false
                    },
                    520: {
                        items: 2,
                        center: false
                    },
                    600: {
                        items: 2,
                        center: false
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    },
                    1200: {
                        items: 5
                    },
                    1366: {
                        items: 5
                    },
                    1400: {
                        items: 5
                    }
                }
            });

        </script>

        <!-- MAIN JS -->
        <script src="js/script.js"></script>

    </div>
    <!-- Wrapper / End -->
</body>

</html>