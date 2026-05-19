<?php
$page_title       = 'About Us | Bosk Furniture - Trusted Furniture Brand in India';
$page_description = 'Learn about Bosk Furniture - a trusted Indian brand crafting premium modular kitchens, wardrobes, sofas and custom interior furniture with guaranteed quality and craftsmanship.';
$page_keywords    = 'about bosk furniture, furniture brand india, modular furniture company, custom furniture manufacturer, interior furniture brand';
$page_canonical   = '/about-us.php';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AboutPage",
      "name": "About Bosk Furniture",
      "url": "https://www.boskfurniture.com/about-us.php",
      "description": "Learn about Bosk Furniture - trusted Indian brand crafting premium modular kitchens, wardrobes and custom interior furniture.",
      "mainEntity": {
        "@type": "Organization",
        "name": "Bosk Furniture",
        "url": "https://www.boskfurniture.com"
      },
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
          {"@type":"ListItem","position":1,"name":"Home","item":"https://www.boskfurniture.com/"},
          {"@type":"ListItem","position":2,"name":"About Us","item":"https://www.boskfurniture.com/about-us.php"}
        ]
      }
    }
    </script>
    <style>
        /* ============ WHY BOSK FURNITURE CARDS ============ */
        .all-services .item { perspective: 1000px; }
        .all-services .service-box {
            position: relative;
            background: #ffffff;
            border-radius: 12px;
            padding: 28px 28px 24px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transition: transform .45s cubic-bezier(.25,.8,.25,1),
                        box-shadow .45s ease;
            height: 100%;
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
                    <h1 class="text-center">About Us</h1>
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
                        <img src="images/bg/2.jpg" alt="">
                    </div>
                    <div class="col-md-6 who-1">
                        <div>
                            <h2 class="text-left mb-4">Key Figures in <span>Bosk Interior Team</span></h2>
                        </div>
                        <div class="pftext">
                            <p>Bosk Infracon Private Limited is started in the year 2019 with clear intention of
                                satisfying the customers with Customized Quality Furniture with a difference.</p>

                            <p><b>Our Promoter : </b>Shri Jiten Indukumar Chhagani, a Civil Engineer and visionary
                                leader, has excelled not only in his professional career but has also demonstrated
                                adaptability to global changes in the furniture industry. His foresight led to the
                                strategic diversification of the family business, transitioning from Timber to
                                Plywood.<br /><b>Our Director :</b>Shri Pranav Jiten Chhagani and Smt. Komal Chhagani,
                                bring unique expertise to our team. Shri Pranav, a dynamic young entrepreneur, began his
                                career in the family's furniture trading business. Renowned for his enthusiasm and
                                friendly demeanor, he is recognized as a man of words. With a visionary spirit, Pranav
                                aims to produce high-quality, customized furniture in India to rival ready-made imports
                                from China. On the other hand, Smt. Komal Chhagani, also a young entrepreneur,
                                specializes in interior design. Her energetic and enthusiastic approach, coupled with a
                                refined taste for elegant designs, showcases her success in completing numerous projects
                                and establishing expertise in furniture design, having trained under renowned
                                architects. Together, they contribute to the diverse strengths of our leadership team.
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
                        <div class="item mb-30">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="#">UNIQUENESS</a></h3>
                                        <p>The furniture we craft is exclusively as per your taste & hence has its own
                                            uniqueness.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item smb-30">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div class=service-content-box>
                                        <h3><a href="#">TIME SAVING</a></h3>
                                        <p>The high end machines creates furniture in no time.</p>
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
                                        <h3><a href=#>GUARANTEED PRODUCTS</a></h3>
                                        <p>We provide manufacturing defect warranty.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item mb-30">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="#">BEST FINISHING</a></h3>
                                        <p>The furniture is machine-crafted with edges covered in matching-tone Edge
                                            bands, ensuring a polished finish.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item mb-30">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href="#">COST EFFECTIVE</a></h3>
                                        <p>If all the parameters are compared, our crafted furniture should be
                                            economical than other similar products.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-xs-12 col-sm-12 col-md-6">
                        <div class="item smb-30">
                            <div class=service-box>

                                <div class="clearfix service-inner-box">

                                    <div>
                                        <h3><a href=#>HYGIENE</a></h3>
                                        <p>The furniture is being crafted at our factory, only erection and fitting is
                                            to be done at customer’s premises.</p>
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
                                        <h3><a href=#>HASSLES</a></h3>
                                        <p>No hassles as the furniture is going to be made at our factory. Only
                                            installation to be done at site which normally takes 2-4 days. We need your
                                            place only for installation.</p>
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
                                        <h3><a href=#>DURABILITY</a></h3>
                                        <p>The base material used is Marine grade : 710 ply and the fixtures used are
                                            from HETTICH – a German company known for its quality & innovations in
                                            hardware.</p>
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
                            <h2 class="text-left mb-4">INITIATION</h2>
                        </div>
                        <div class="pftext">
                            <p>Transforming Furniture Choices: From Ready-Made Dilemmas to <br /><b>BOSK INFRACON's
                                    Customized Excellence</b></p>

                            <p><b>The thought:</b>- why people are opting for ready made furniture or China furniture ?
                                for looks ? (main reason found was saving in time and avoiding hardships of traditional
                                furniture)<br />
                                - are the people getting their worth by buying the local readymade available furniture
                                from market which is mostly made of Engineering Wood (MDF or Particle Board)?<br />
                                - the looks may be good but what about the durability?<br />
                                - what about the after sales?<br />
                                <b>Thought Process:</b>- Can we manufacture quality modular furniture in our home town
                                which can be customized as per the requirements, is <b>durable</b>, is <b>time
                                    saving</b> and is <b>warranted</b>.
                                <br /><b>Result:</b>- Establishment of <b>BOSK INFRACON PRIVATE LIMITED</b> where
                                <b>Guaranteed Customized Modular furniture</b> is to be crafted on imported machines to
                                bring a satisfied smile on the users face.
                            </p>
                        </div>

                    </div>
                    <div class="col-md-6 who">
                        <img src="images/bg/1.jpg" alt="">
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