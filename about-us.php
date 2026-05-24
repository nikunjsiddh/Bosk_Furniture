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
        .all-services .row > [class*="col-"] {
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
            transition: transform .45s cubic-bezier(.25,.8,.25,1),
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
            transition: width .4s cubic-bezier(.25,.8,.25,1);
        }
        .all-services .item:hover .service-box {
            transform: translateY(-10px);
            box-shadow: 0 22px 42px rgba(83, 42, 26, 0.18);
        }
        .all-services .item:hover .service-box::before { opacity: 1; }
        .all-services .item:hover .service-box::after { width: 6px; }

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
            transition: opacity .45s ease, transform .55s cubic-bezier(.25,.8,.25,1);
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
            .all-services .service-box { padding: 22px 22px 20px; }
            .all-services .service-box h3 { font-size: 16px; }
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
        <section class="who-we-are">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 who">
                        <img src="images/bg/2.jpg" alt="BOSK leadership team and customized modular furniture workshop in Bhavnagar, Gujarat">
                    </div>
                    <div class="col-md-6 who-1">
                        <div>
                            <h2 class="text-left mb-4">Our Story: From Timber to <span>Customized Modular Furniture</span></h2>
                        </div>
                        <div class="pftext">
                            <p>BOSK is the furniture brand of <b>Bosk Infracon Private Limited</b>, founded in 2019
                                with a single, clear intention: to give Indian homes <b>customized, quality modular
                                furniture with a difference</b>. From our manufacturing base in Bhavnagar, Gujarat,
                                we craft made-to-order wardrobes, beds, TV units, sofas and
                                <a href="shop.php?astringdata2=Modular Kitchens">modular kitchens</a> on high-end
                                imported machines &mdash; and deliver them, fully guaranteed, to customers across
                                India. Every piece is built around <i>your</i> space, taste and budget, not pulled
                                off a ready-made shelf.</p>

                            <p><b>Our Promoter :</b> Shri Jiten Indukumar Chhagani, a Civil Engineer and visionary
                                leader, steered the family enterprise through a strategic shift from Timber to
                                Plywood. That engineering mindset still defines how we work &mdash; we treat
                                furniture as something to be built to last, not just assembled to look good in a
                                showroom.<br /><b>Our Directors :</b> Shri Pranav Jiten Chhagani and
                                Smt. Komal Chhagani bring complementary strengths to the business. Pranav, a
                                dynamic young entrepreneur, began his career in the family's furniture trading
                                business and is driven by one ambition: to produce high-quality, customized
                                furniture in India that rivals ready-made imports from China. Komal is an interior
                                designer with a refined eye for elegant, liveable spaces; trained under renowned
                                architects, she has delivered numerous projects and leads design at BOSK. Together
                                they pair manufacturing discipline with genuine design sensibility.
                            </p>
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

        <section class="who-we-are">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 who-1">
                        <div>
                            <h2 class="text-left mb-4">Customized Modular Furniture vs. <span>Ready-Made &amp; Imported</span></h2>
                        </div>
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
                                satisfied smile on every user's face.<br /><br />
                                <b>What we make:</b> a complete range of modular furniture for the home, including
                                modular sofas,
                                <a href="shop.php?astringdata2=LUSCIOUS WARDROBES">luscious wardrobes</a>,
                                <a href="shop.php?astringdata2=Comfy Beds With Full Storage">comfy beds with full storage</a>,
                                <a href="shop.php?astringdata2=Entertaining TV Units">entertaining TV units</a>,
                                <a href="shop.php?astringdata2=Modular Kitchens">modular kitchens</a> and other
                                everyday comforts. Each range is fully customizable in size, layout, finish and
                                hardware. Ready to replace ready-made compromises with furniture designed around
                                your home? <a href="all_products.php">Explore our range</a> or
                                <a href="contact.php">get in touch</a>.
                            </p>
                        </div>

                    </div>
                    <div class="col-md-6 who">
                        <img src="images/bg/1.jpg" alt="Customized modular furniture crafted in marine-grade 710 plywood at the BOSK factory">
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
</body>

</html>