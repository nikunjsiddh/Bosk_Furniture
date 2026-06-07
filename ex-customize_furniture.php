<?php
// Start the session BEFORE any output so nav1.php's session_start() doesn't trigger
// a "headers already sent" warning.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title       = 'Customize Your Furniture | Bespoke Furniture Design - Bosk Furniture';
$page_description = 'Customize your dream furniture with Bosk Furniture - bespoke modular kitchens, wardrobes, sofas and complete home interiors tailored to your space across India.';
$page_keywords    = 'customize furniture india, bespoke furniture, custom modular furniture, made to order furniture, bosk furniture customization';
$page_canonical   = '/ex-customize_furniture';
$page_breadcrumbs = [
    ['name' => 'Home',              'url' => '/'],
    ['name' => 'Customize Furniture', 'url' => '/ex-customize_furniture']
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
    
    <style>
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
    </style>
</head>

<body class="homepage-1 int_white_bg inner-page">
    <!-- Wrapper -->
    <div id="wrapper" class="int_main_wraapper">
        <!-- START SECTION HEADINGS -->
        <!-- Header Container
        ================================================== -->
        <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <!-- SLIDER START -->
       <section class="headings">
            <div class="text-heading">
                <div class="container">
                    <h1 class="text-center">Customize Modest Furniture</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>Customize Modest Furniture</span>
                    </div>
                </div>
            </div>
        </div>

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
                            <a href="project-details.php?astringdata=<?php echo $encode_project_id; ?>" class="recent-16" data-aos="fade-up">
                                <div class="recent-img16 img-fluid img-center" style="background-image: url(admin/project_image/<?php echo $img1;?>)">
                                
                                </div>
                                <div class="recent-content"></div>
                                <div class="recent-details">
                                    <div class="recent-title"><?php echo $project_name;?></div>
                                    <!--<div class="recent-price">{price}</div>-->
                                    <!--<div class="house-details">{category}</div>-->
                                </div>
                                <div class="view-proper">View Details</div>
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

<section id="contact" class="contact">
            <div class="container">
                <div class="section-title ml-3">
                    <h3>Have a Question About Modest Customize Furniture?</h3>
                    <h2>CONTACT US</h2>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form  class="contact-form" onsubmit="return modest_customize(this);" id="MyForm" method="post"  novalidate>
                            
                           
                            <div class="form-group">
                                <input type="text" required class="form-control input-custom input-full" name="name" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" required class="form-control input-custom input-full"  name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control input-custom input-full" name="phone" placeholder="Contact Number">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control textarea-custom input-full" id="ccomment" name="msg" required rows="8" placeholder="Message"></textarea>
                            </div>
                            <div class="box bg-3">
                                <button type="submit" name="submit" id="submit-contact" style="color:white;background-color:#532A1A;border:2px solid #532A1A;" class="mt-5 btn btn-primary btn-lg">Submit</button>
                            </div>
                        </form>
                        <div id="return"></div>
                    </div>
                    <!--<div class="col-md-4 info-touch">-->
                    <!--    <h4>Keep In Touch</h4>-->
                    <!--    <div class="my-info">-->
                    <!--        <div class="in1">-->
                    <!--            <div class="address">-->
                    <!--                <p style="line-height:1.3rem;"><i class="fa fa-map-marker" aria-hidden="true"></i>5,Aryamaan Complex,</p><p style="line-height:1.3rem;margin-top:-3.2rem;margin-left:4.0rem;"><br/>Near Meghani Circle,<br/>Sir Patannni Road,<br/>Bhavnagar-364001,<br/>Gujarat,India.</p>-->
                    <!--            </div>-->
                    <!--            <div class="email">-->
                    <!--                <p><i class="fa fa-envelope" aria-hidden="true"></i>boskinfracon@gmail.com</p>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--        <div class="in1">-->
                    <!--            <div class="phone">-->
                    <!--                <p><i class="fa fa-phone" aria-hidden="true"></i>+91 8866647777</p>-->
                    <!--            </div>-->
                    <!--            <div class="whatssap">-->
                    <!--                <p><i class="fa fa-whatsapp" aria-hidden="true"></i>+91 9737817777</p>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
        </section>

        <!-- START FOOTER -->
        <?php include_once"design/footer.php";?>

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
            tpj(document).ready(function() {
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
                navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
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
          <script src="js/add/modest_customize.js"></script>
    </div>
    <!-- Wrapper / End -->
</body>

</html>
