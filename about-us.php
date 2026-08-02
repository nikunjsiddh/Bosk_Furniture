<?php
$page_title       = 'Customized Modular Furniture Manufacturer in India | BOSK';
$page_description = 'BOSK (Bosk Infracon) crafts guaranteed, customized modular furniture in India - modular wardrobes, beds, TV units & kitchens in marine-grade 710 plywood.';
$page_keywords    = 'customized modular furniture manufacturer in india, modular furniture india, modular wardrobes, modular kitchen, marine plywood furniture, made in india furniture, hettich hardware furniture india, bosk furniture, bosk infracon';
$page_canonical   = '/about-us';
$page_breadcrumbs = [
    ['name' => 'Home',     'url' => '/'],
    ['name' => 'About Us', 'url' => '/about-us']
];
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AboutPage",
      "@id": "https://www.boskfurniture.com/about-us#aboutpage",
      "name": "About BOSK - Customized Modular Furniture, Made in India",
      "url": "https://www.boskfurniture.com/about-us",
      "description": "BOSK (Bosk Infracon Private Limited) is a customized modular furniture manufacturer in India - wardrobes, beds, TV units, sofas and modular kitchens crafted in marine-grade 710 plywood with HETTICH hardware.",
      "isPartOf": { "@id": "https://www.boskfurniture.com/#website" },
      "about": { "@id": "https://www.boskfurniture.com/#organization" },
      "mainEntity": {
        "@type": "Organization",
        "@id": "https://www.boskfurniture.com/#organization",
        "name": "Bosk Furniture",
        "legalName": "Bosk Infracon Private Limited",
        "url": "https://www.boskfurniture.com",
        "foundingDate": "2019",
        "founder": [
          {"@type":"Person","name":"Jiten Indukumar Chhagani","jobTitle":"Promoter"},
          {"@type":"Person","name":"Pranav Jiten Chhagani","jobTitle":"Director"},
          {"@type":"Person","name":"Komal Chhagani","jobTitle":"Director"}
        ]
      }
    }
    </script>
    <style>
        /* ============ WHY BOSK FURNITURE CARDS ============ */
        /* Equal-height grid: stretch all cards in a row to match the tallest */
        .all-services .row {
            display: flex;
            flex-wrap: wrap;
        }

        .all-services .row>[class*="col-"] {
            display: flex;
            margin-bottom: 30px;
        }

        .all-services .item {
            perspective: 1000px;
            width: 100%;
            display: flex;
        }

        .all-services .service-box {
            position: relative;
            background: #ffffff;
            border-radius: 12px;
            padding: 28px 28px 24px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transition: transform .45s cubic-bezier(.25, .8, .25, 1),
                box-shadow .45s ease;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .all-services .service-inner-box {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
        }

        /* Soft brand-tinted wash that fades in on hover */
        .all-services .service-box::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                    rgba(83, 42, 26, 0.07) 0%,
                    rgba(83, 42, 26, 0) 65%);
            opacity: 0;
            transition: opacity .4s ease;
            pointer-events: none;
        }

        /* Left accent bar that slides in from 0 to 6px on hover */
        .all-services .service-box::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #532A1A;
            transition: width .4s cubic-bezier(.25, .8, .25, 1);
        }

        .all-services .item:hover .service-box {
            transform: translateY(-10px);
            box-shadow: 0 22px 42px rgba(83, 42, 26, 0.18);
        }

        .all-services .item:hover .service-box::before {
            opacity: 1;
        }

        .all-services .item:hover .service-box::after {
            width: 6px;
        }

        .all-services .service-box h3 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: .6px;
            margin: 0 0 12px;
            transition: color .35s ease, transform .35s ease;
            position: relative;
            z-index: 1;
        }

        .all-services .service-box h3 a {
            color: #222 !important;
            text-decoration: none !important;
            transition: color .35s ease;
        }

        .all-services .item:hover .service-box h3 {
            transform: translateX(8px);
        }

        .all-services .item:hover .service-box h3 a {
            color: #532A1A !important;
        }

        .all-services .service-box p {
            margin: 0;
            color: #666;
            line-height: 1.65;
            position: relative;
            z-index: 1;
            transition: color .3s ease, transform .35s ease;
        }

        .all-services .item:hover .service-box p {
            color: #444;
            transform: translateX(8px);
        }

        /* Subtle decorative number badge in the top-right */
        .all-services .service-inner-box::before {
            content: "✦";
            position: absolute;
            top: 18px;
            right: 22px;
            font-size: 22px;
            color: #ecdfd7;
            opacity: 0;
            transform: rotate(-25deg) scale(.6);
            transition: opacity .45s ease, transform .55s cubic-bezier(.25, .8, .25, 1);
            pointer-events: none;
            z-index: 1;
        }

        .all-services .service-inner-box {
            position: relative;
        }

        .all-services .item:hover .service-inner-box::before {
            opacity: 1;
            transform: rotate(0deg) scale(1);
            color: #532A1A;
        }

        @media (max-width: 575px) {
            .all-services .service-box {
                padding: 22px 22px 20px;
            }

            .all-services .service-box h3 {
                font-size: 16px;
            }
        }

        /* ============================================================ */
        /* ============  WHO-WE-ARE  (Our Story / Why BOSK)  ============ */
        /* ============================================================ */

        /* Neutralize the global ".who-we-are span::after" underline so it
           doesn't leak onto label, badge, big-number and accent spans.
           The heading underline gets re-enabled further below. */
        .who-section span::after {
            content: none !important;
            display: none !important;
            background: transparent !important;
            width: 0 !important;
            height: 0 !important;
            margin: 0 !important;
        }

        .who-section {
            position: relative;
            overflow: hidden;
            padding: 5rem 0 !important;
        }

        .who-section-1 {
            background:
                radial-gradient(900px 500px at -8% 0%, rgba(83, 42, 26, .05), transparent 60%),
                linear-gradient(180deg, #ffffff 0%, #fbf7f4 100%);
        }

        .who-section-2 {
            background:
                radial-gradient(900px 500px at 108% 100%, rgba(83, 42, 26, .05), transparent 60%),
                linear-gradient(180deg, #fbf7f4 0%, #ffffff 100%);
        }

        .who-section .container {
            position: relative;
            z-index: 1;
        }

        .who-section .row {
            row-gap: 2rem;
        }

        /* Section label tag */
        .who-label {
            display: inline-flex;
            align-items: center;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .25em;
            text-transform: uppercase;
            color: #532A1A;
            margin-bottom: 1rem;
        }

        .who-label-line {
            display: inline-block;
            width: 36px;
            height: 2px;
            background: #532A1A;
            margin-right: 12px;
            transform-origin: left center;
            transform: scaleX(0);
            transition: transform .8s cubic-bezier(.2, .7, .2, 1) .2s;
        }

        [data-reveal].is-revealed .who-label-line {
            transform: scaleX(1);
        }

        /* Heading polish */
        .who-section .who-1 h2 {
            font-size: 2rem;
            line-height: 1.25;
            font-weight: 700;
            color: #111;
            margin-bottom: 1.25rem !important;
        }

        .who-section .who-1 h2 span {
            color: #532A1A;
            position: relative;
            display: inline-block;
        }

        /* Override the global underline rule so it can animate */
        .who-section .who-1 h2 span::after {
            display: block !important;
            content: " " !important;
            height: 3px !important;
            background: #532A1A !important;
            width: 0 !important;
            margin-left: 0 !important;
            margin-top: .35rem !important;
            margin-bottom: 0 !important;
            transition: width .9s cubic-bezier(.2, .7, .2, 1) .3s;
        }

        [data-reveal].is-revealed .who-1 h2 span::after {
            width: 100% !important;
        }

        /* Paragraph text refinement */
        .who-section .pftext p {
            color: #555;
            line-height: 1.75;
            font-size: 1rem;
            margin-bottom: 1.1rem;
        }

        .who-section .pftext a {
            color: #532A1A;
            font-weight: 600;
            text-decoration: none;
            border-bottom: 1px dashed rgba(83, 42, 26, .35);
            transition: border-color .3s ease, color .3s ease;
        }

        .who-section .pftext a:hover {
            color: #3a1d12;
            border-bottom-color: #532A1A;
        }

        /* People cards (Promoter / Directors) */
        .who-people {
            display: grid;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .who-person {
            position: relative;
            padding: 1.1rem 1.2rem 1.1rem 1.4rem;
            background: #fff;
            border-radius: 10px;
            border: 1px solid rgba(83, 42, 26, .10);
            box-shadow: 0 6px 18px rgba(83, 42, 26, .05);
            transition: transform .4s cubic-bezier(.2, .7, .2, 1), box-shadow .4s ease, border-color .4s ease;
        }

        .who-person::before {
            content: "";
            position: absolute;
            left: 0;
            top: 14px;
            bottom: 14px;
            width: 4px;
            background: #532A1A;
            border-radius: 0 4px 4px 0;
            transform: scaleY(.4);
            transform-origin: center;
            transition: transform .4s ease;
        }

        .who-person:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(83, 42, 26, .12);
            border-color: rgba(83, 42, 26, .2);
        }

        .who-person:hover::before {
            transform: scaleY(1);
        }

        .who-person-role {
            display: inline-block;
            font-size: .7rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: #fff;
            background: #532A1A;
            padding: 3px 9px;
            border-radius: 2px;
            margin-bottom: .55rem;
            font-weight: 600;
        }

        .who-section .who-person h4 {
            font-size: 1.02rem;
            font-weight: 700;
            color: #222;
            margin: 0 0 .4rem;
            line-height: 1.3;
        }

        .who-section .who-person p,
        .who-section .pftext .who-person p {
            margin: 0;
            font-size: .92rem;
            line-height: 1.6;
            color: #555;
            background: transparent;
        }

        /* "What we make" chip list */
        .who-make-intro {
            margin-top: .25rem !important;
            margin-bottom: .75rem !important;
        }

        .who-chip-list {
            list-style: none;
            padding: 0;
            margin: 0 0 1.4rem;
            display: flex;
            flex-wrap: wrap;
            gap: .55rem;
        }

        .who-chip-list li a {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .5rem .9rem;
            border-radius: 999px;
            background: #fff;
            border: 1px solid rgba(83, 42, 26, .18);
            color: #532A1A !important;
            font-size: .88rem;
            font-weight: 600;
            text-decoration: none !important;
            transition: transform .35s cubic-bezier(.2, .7, .2, 1), background .35s ease, color .35s ease, border-color .35s ease, box-shadow .35s ease;
        }

        .who-chip-list li a i {
            font-size: .9rem;
        }

        .who-chip-list li a:hover {
            background: #532A1A;
            color: #fff !important;
            border-color: #532A1A;
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(83, 42, 26, .25);
        }

        .who-cta-line {
            font-weight: 600;
            color: #222 !important;
            margin: 0 0 1rem !important;
        }

        /* CTA buttons */
        .who-cta {
            display: flex;
            flex-wrap: wrap;
            gap: .8rem;
            margin-top: .25rem;
        }

        .who-btn {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .85rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            font-size: .92rem;
            letter-spacing: .04em;
            text-transform: uppercase;
            text-decoration: none !important;
            transition: transform .35s cubic-bezier(.2, .7, .2, 1), background .35s ease, color .35s ease, box-shadow .35s ease, border-color .35s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .who-btn i {
            transition: transform .35s cubic-bezier(.2, .7, .2, 1);
        }

        .who-btn-primary {
            background: #532A1A;
            color: #fff !important;
            box-shadow: 0 10px 22px rgba(83, 42, 26, .25);
        }

        .who-btn-primary:hover {
            background: #3a1d12;
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(83, 42, 26, .32);
            color: #fff !important;
        }

        .who-btn-primary:hover i {
            transform: translateX(4px);
        }

        .who-btn-ghost {
            background: transparent;
            border-color: #532A1A;
            color: #532A1A !important;
        }

        .who-btn-ghost:hover {
            background: #532A1A;
            color: #fff !important;
            transform: translateY(-3px);
        }

        /* Image stage — wraps number + image as one unit, centered in column */
        .who-section .who {
            display: block;
            padding: 0 .5rem;
        }

        .who-img-stage {
            position: relative;
            width: 100%;
            max-width: 560px;
            margin: 1.5rem auto 2rem;
            padding-top: 2.5rem;
            padding-right: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .who-section-2 .who-img-stage {
            padding-right: 0;
            padding-left: 1.5rem;
        }

        /* Big decorative numeral, anchored to the image's top corner */
        .who-stage-number {
            position: absolute;
            top: -1.5rem;
            left: -1rem;
            font-family: 'Poppins', Arial, sans-serif;
            font-size: 11rem;
            font-weight: 900;
            line-height: .85;
            letter-spacing: -.05em;
            color: transparent;
            -webkit-text-stroke: 2px rgba(83, 42, 26, 0.18);
            text-stroke: 2px rgba(83, 42, 26, 0.18);
            pointer-events: none;
            user-select: none;
            z-index: 3;
            opacity: 0;
            transform: translate(-12px, 6px);
            transition: opacity .8s ease .15s, transform .8s cubic-bezier(.2, .7, .2, 1) .15s;
        }

        .who-section-2 .who-stage-number {
            left: auto;
            right: -1rem;
            transform: translate(12px, 6px);
        }

        [data-reveal].is-revealed .who-stage-number {
            opacity: 1;
            transform: translate(0, 0);
        }

        /* Image wrap — relative for accent + badge */
        .who-section .who-img-wrap {
            position: relative;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        /* Brown accent block — offset behind image */
        .who-img-accent {
            position: absolute;
            top: 18px;
            left: 18px;
            right: -18px;
            bottom: -18px;
            background: linear-gradient(135deg, #532A1A 0%, #7a4128 100%);
            border-radius: 8px;
            z-index: 0;
            transition: transform .55s cubic-bezier(.2, .7, .2, 1);
        }

        .who-img-wrap:hover .who-img-accent {
            transform: translate(4px, 4px);
        }

        /* Alt-side variant for section 2 (image on right) */
        .who-section-2 .who-img-accent {
            left: -18px;
            right: 18px;
        }

        .who-section-2 .who-img-wrap:hover .who-img-accent {
            transform: translate(-4px, 4px);
        }

        /* Image inner — sits above accent */
        .who-section .who-img-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 18px 38px rgba(0, 0, 0, .18);
            background: #111;
        }

        .who-section .who-img-inner img {
            display: block;
            width: 100%;
            height: auto;
            max-width: 100%;
            padding: 0;
            transform: scale(1);
            transition: transform .8s cubic-bezier(.2, .7, .2, 1), filter .6s ease;
            filter: saturate(1) brightness(.97);
        }

        .who-img-wrap:hover .who-img-inner img {
            transform: scale(1.06);
            filter: saturate(1.1) brightness(1);
        }

        /* Floating badge on image */
        .who-img-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(255, 255, 255, .95);
            color: #532A1A;
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: .5rem .9rem;
            border-radius: 999px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .15);
            z-index: 2;
            backdrop-filter: blur(4px);
            transform: translateY(-6px);
            opacity: 0;
            transition: transform .55s cubic-bezier(.2, .7, .2, 1) .35s, opacity .55s ease .35s;
        }

        .who-img-badge i {
            color: #532A1A;
        }

        [data-reveal].is-revealed .who-img-badge {
            transform: translateY(0);
            opacity: 1;
        }

        .who-section-2 .who-img-badge {
            left: auto;
            right: 16px;
        }

        /* On-scroll reveal: base + revealed states */
        [data-reveal] {
            opacity: 0;
            transition: opacity .9s ease, transform .9s cubic-bezier(.2, .7, .2, 1);
            will-change: opacity, transform;
        }

        [data-reveal="left"] {
            transform: translateX(-32px);
        }

        [data-reveal="right"] {
            transform: translateX(32px);
        }

        [data-reveal="up"] {
            transform: translateY(32px);
        }

        [data-reveal].is-revealed {
            opacity: 1;
            transform: translate(0, 0);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .who-section {
                padding: 4rem 0 !important;
            }

            .who-section .who-1 h2 {
                font-size: 1.6rem;
            }

            .who-img-stage {
                max-width: 520px;
                padding-top: 2rem;
                padding-right: 1.2rem;
                padding-bottom: 1.2rem;
            }

            .who-section-2 .who-img-stage {
                padding-right: 0;
                padding-left: 1.2rem;
            }

            .who-stage-number {
                font-size: 8rem;
                top: -1rem;
            }

            /* Image first on mobile in section 2 for better flow */
            .who-section-2 .row {
                flex-direction: column-reverse;
            }

            .who-section-2 .who {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 575px) {
            .who-section {
                padding: 3rem 0 !important;
            }

            .who-section .who-1 h2 {
                font-size: 1.4rem;
            }

            .who-img-stage {
                padding-top: 1.5rem;
                padding-right: .9rem;
                padding-bottom: .9rem;
            }

            .who-section-2 .who-img-stage {
                padding-right: 0;
                padding-left: .9rem;
            }

            .who-stage-number {
                font-size: 6rem;
                top: -.6rem;
                left: -.3rem;
                -webkit-text-stroke-width: 1.5px;
            }

            .who-section-2 .who-stage-number {
                right: -.3rem;
                left: auto;
            }

            .who-img-accent {
                top: 12px;
                left: 12px;
                right: -12px;
                bottom: -12px;
            }

            .who-section-2 .who-img-accent {
                left: -12px;
                right: 12px;
            }

            .who-chip-list li a {
                font-size: .82rem;
                padding: .42rem .75rem;
            }

            .who-btn {
                padding: .75rem 1.2rem;
                font-size: .85rem;
                flex: 1 1 auto;
                justify-content: center;
            }

            .who-img-badge {
                font-size: .68rem;
                padding: .4rem .7rem;
            }
        }

        /* Respect reduced motion */
        @media (prefers-reduced-motion: reduce) {

            [data-reveal],
            .who-label-line,
            .who-section .who-1 h2 span::after,
            .who-img-badge,
            .who-img-accent,
            .who-stage-number,
            .who-person,
            .who-person::before,
            .who-btn,
            .who-chip-list li a {
                transition: none !important;
            }

            [data-reveal] {
                opacity: 1;
                transform: none;
            }

            .who-label-line {
                transform: scaleX(1);
            }

            .who-section .who-1 h2 span::after {
                width: 100%;
            }

            .who-img-badge {
                opacity: 1;
                transform: none;
            }

            .who-stage-number {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body class="inner-page">
    <!-- Wrapper -->
    <div id="wrapper">
        <!-- START SECTION HEADINGS -->
        <!-- Header Container
        ================================================== -->
        <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <section class="headings">
            <div class="text-heading">
                <div class="container">
                    <h1 class="text-center">About BOSK &mdash; Customized Modular Furniture, Made in India</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>About Us</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

        <!-- START SECTION ABOUT -->
        <section class="who-we-are who-section who-section-1" data-reveal-section>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 who" data-reveal="left">
                        <div class="who-img-stage">
                            <span class="who-stage-number" aria-hidden="true">01</span>
                            <figure class="who-img-wrap">
                                <span class="who-img-accent" aria-hidden="true"></span>
                                <div class="who-img-inner">
                                    <img src="images/about/bosk-furniture-shoppe.jpg"
                                        alt="BOSK Furniture Shoppe showroom interior in Bhavnagar, Gujarat showcasing customized modular furniture displays">
                                </div>
                                <span class="who-img-badge">
                                    <i class="fa fa-star" aria-hidden="true"></i> Since 2019
                                </span>
                            </figure>
                        </div>
                    </div>
                    <div class="col-md-6 who-1" data-reveal="right">
                        <span class="who-label"><span class="who-label-line"></span>Our Story</span>
                        <h2 class="text-left mb-4">Our Story: From Timber to <span>Customized Modular Furniture</span>
                        </h2>
                        <div class="pftext">
                            <p>BOSK is the furniture brand of <b>Bosk Infracon Private Limited</b>, founded in 2019
                                with a single, clear intention: to give Indian homes <b>customized, quality modular
                                    furniture with a difference</b>. From our manufacturing base in Bhavnagar, Gujarat,
                                we craft made-to-order wardrobes, beds, TV units, sofas and
                                <a href="shop.php?astringdata2=Modular Kitchens">modular kitchens</a> on high-end
                                imported machines &mdash; and deliver them, fully guaranteed, to customers across
                                India. Every piece is built around <i>your</i> space, taste and budget, not pulled
                                off a ready-made shelf.
                            </p>

                            <div class="who-people">
                                <div class="who-person">
                                    <span class="who-person-role">Our Promoter</span>
                                    <h4>Shri Jiten Indukumar Chhagani</h4>
                                    <p>Civil Engineer and visionary leader who steered the family enterprise through
                                        a strategic shift from Timber to Plywood. That engineering mindset still
                                        defines how we work &mdash; furniture built to last, not just assembled to
                                        look good in a showroom.</p>
                                </div>
                                <div class="who-person">
                                    <span class="who-person-role">Our Directors</span>
                                    <h4>Shri Pranav Jiten Chhagani &amp; Smt. Komal Chhagani</h4>
                                    <p>Pranav, a dynamic young entrepreneur, is driven to produce customized
                                        furniture in India that rivals ready-made imports from China. Komal, an
                                        interior designer trained under renowned architects, leads design at BOSK.
                                        Together they pair manufacturing discipline with genuine design sensibility.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION ABOUT -->

        <!-- START SECTION SERVICES -->
        <section class="all-services bg-white-2">
            <div class="container">
                <div class="section-title">
                    <h3>WHY BOSK FURNITURE?</h3>
                    <h2>Ethical working and Integrity is our strength</h2>
                </div>
                <div class="row mt-50">
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="all_products.php">TRULY CUSTOMIZED</a></h3>
                                        <p>Every piece is crafted exclusively to your taste, so your furniture has
                                            a uniqueness that mass-produced ranges simply can't offer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div class=service-content-box>
                                        <h3><a href="design-order-process.php">FASTER TURNAROUND</a></h3>
                                        <p>Our high-end imported machines produce precision modular furniture
                                            quickly, cutting the long waits associated with traditional carpentry.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="warranty.php">GUARANTEED PRODUCTS</a></h3>
                                        <p>We stand behind our work with a manufacturing-defect warranty &mdash; so
                                            durable, customized furniture comes with real peace of mind.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="all_products.php">BEST-IN-CLASS FINISHING</a></h3>
                                        <p>Furniture is machine-crafted with edges sealed in matching-tone edge
                                            bands for a clean, polished, long-lasting finish.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="all_products.php">COST-EFFECTIVE</a></h3>
                                        <p>Compare the parameters that matter &mdash; material, hardware, finish and
                                            warranty &mdash; and our crafted furniture works out more economical
                                            than similar products.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="design-order-process.php">HYGIENIC, FACTORY-BUILT</a></h3>
                                        <p>Your furniture is manufactured in our factory under controlled
                                            conditions; only erection and fitting happen at your premises.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="design-order-process.php">HASSLE-FREE INSTALLATION</a></h3>
                                        <p>Because the furniture is made at our factory, there's no mess at home.
                                            Installation on site typically takes just 2&ndash;4 days &mdash; we only
                                            need access to your space for fitting.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-xs-12 col-sm-12 col-md-6">
                        <div class="item">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="warranty.php">BUILT FOR DURABILITY</a></h3>
                                        <p>We build with marine-grade 710 plywood and fit HETTICH hardware &mdash;
                                            from the German company renowned for quality and innovation &mdash; so
                                            your furniture performs for years, not seasons.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- END SECTION SERVICES -->

        <section class="who-we-are who-section who-section-2" data-reveal-section>
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-md-6 who-1" data-reveal="left">
                        <span class="who-label"><span class="who-label-line"></span>Why BOSK</span>
                        <h2 class="text-left mb-4">Customized Modular Furniture vs. <span>Ready-Made &amp;
                                Imported</span></h2>
                        <div class="pftext">
                            <p>BOSK began with a simple question: why are people choosing ready-made or imported
                                furniture? The honest answer was usually time-saving and convenience, not quality.
                                Most locally available ready-made furniture is built from engineered wood &mdash;
                                MDF or particle board &mdash; which can look good on day one but tends to swell, sag
                                and fail when exposed to moisture and daily use, with little after-sales support.</p>

                            <p>We believed there was a better way: <b>guaranteed, customized modular furniture, made
                                    in India</b>, that keeps the looks and the convenience but adds durability,
                                personalisation and a warranty. That belief is the reason Bosk Infracon Private
                                Limited exists &mdash; to craft modular furniture on imported machines and put a
                                satisfied smile on every user's face.</p>

                            <p class="who-make-intro"><b>What we make</b> &mdash; a complete range of modular
                                furniture for the home, fully customizable in size, layout, finish and hardware:</p>

                            <ul class="who-chip-list">
                                <li><a href="shop.php?astringdata2=LUSCIOUS WARDROBES"><i class="fa fa-archive"
                                            aria-hidden="true"></i> Luscious Wardrobes</a></li>
                                <li><a href="shop.php?astringdata2=Comfy Beds With Full Storage"><i class="fa fa-bed"
                                            aria-hidden="true"></i> Beds with Storage</a></li>
                                <li><a href="shop.php?astringdata2=Entertaining TV Units"><i class="fa fa-tv"
                                            aria-hidden="true"></i> TV Units</a></li>
                                <li><a href="shop.php?astringdata2=Modular Kitchens"><i class="fa fa-cutlery"
                                            aria-hidden="true"></i> Modular Kitchens</a></li>
                                <li><a href="shop.php"><i class="fa fa-couch" aria-hidden="true"></i> Modular Sofas</a>
                                </li>
                            </ul>

                            <p class="who-cta-line">Ready to replace ready-made compromises with furniture designed
                                around your home?</p>

                            <div class="who-cta">
                                <a class="who-btn who-btn-primary" href="all_products.php">
                                    Explore Our Range <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </a>
                                <a class="who-btn who-btn-ghost" href="contact.php">
                                    Get in Touch
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 who" data-reveal="right">
                        <div class="who-img-stage">
                            <span class="who-stage-number" aria-hidden="true">02</span>
                            <figure class="who-img-wrap who-img-wrap-alt">
                                <span class="who-img-accent" aria-hidden="true"></span>
                                <div class="who-img-inner">
                                    <img src="images/bg/1.jpg"
                                        alt="Customized modular furniture crafted in marine-grade 710 plywood at the BOSK factory">
                                </div>
                                <span class="who-img-badge">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i> Made in India
                                </span>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <!-- START SECTION COUNTER UP -->
        <section class="counterup">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="countr">
                            <i class="fa fa-trophy" aria-hidden="true"></i>
                            <p class="counter">200</p>
                            <h3>won awards</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="countr">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <p class="counter">300</p>
                            <h3>Happy clients</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="countr">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            <p class="counter">400</p>
                            <h3>Hours Worked</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="countr lt">
                            <i class="fa fa-folder-open" aria-hidden="true"></i>
                            <p class="counter">250</p>
                            <h3>Our Projects</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION COUNTER UP -->

        <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <!-- Wrapper / End -->

    <script>
        (function () {
            var els = document.querySelectorAll('[data-reveal], [data-reveal-section]');
            if (!els.length) return;
            if (!('IntersectionObserver' in window) ||
                window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                els.forEach(function (el) { el.classList.add('is-revealed'); });
                return;
            }
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });
            els.forEach(function (el) { io.observe(el); });
        })();
    </script>
</body>

</html>