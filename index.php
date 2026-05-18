<?php
// Start the session BEFORE any output so nav1.php's session_start() doesn't trigger
// a "headers already sent" warning. Guarded so it never collides with a prior start.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title       = 'Bosk Furniture - Premium Modular Furniture & Interior Design in India';
$page_description = 'Buy premium modular furniture online at Bosk Furniture - modular kitchens, wardrobes, sofas, beds, dining sets & custom interior solutions. Guaranteed quality across India.';
$page_keywords    = 'bosk furniture, modular furniture india, online furniture store, modular kitchen, wardrobe, sofa, bed, dining set, custom furniture, interior design india';
$page_canonical   = '/';
$og_image         = 'https://www.boskfurniture.com/images/og-default.jpg';
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
    <!-- ===== HOMEPAGE LOCAL BUSINESS SCHEMA ===== -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FurnitureStore",
      "name": "Bosk Furniture",
      "image": "https://www.boskfurniture.com/images/og-default.jpg",
      "url": "https://www.boskfurniture.com",
      "telephone": "+91-XXXXXXXXXX",
      "priceRange": "₹₹",
      "description": "Premium modular and custom furniture store in India offering modular kitchens, wardrobes, sofas, beds, dining sets and complete interior design solutions.",
      "address": {
        "@type": "PostalAddress",
        "addressCountry": "IN"
      },
      "areaServed": {
        "@type": "Country",
        "name": "India"
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
        "opens": "10:00",
        "closes": "20:00"
      }
    }
    </script>
    
    <style>
        .recent-img16{
            
        }
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
    </style>
</head>

<body class="homepage-1 int_white_bg">
    <!-- Wrapper -->
    <div id="wrapper" class="int_main_wraapper">
        <!-- START SECTION HEADINGS -->
        <!-- Header Container
        ================================================== -->
        <?php include_once"design/nav1.php";?>
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
                                    <p style="color:white !important;" class="mt-4"><b>Our experience ensures that your projects will be done right and with the upmost professionalism.</b></p>
                                </div>
                                <!--/ End Welcome Text -->
                                <a href="about-us.php" class="btn btn-default btn-theme-colored2 btn-xl mt-5">Read More</a> <a href="contact.php" class="btn btn-dark btn-theme-colored btn-xl mt-5">Contact Us</a>
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
                            <a href="project-details.php?astringdata=<?php echo $encode_project_id; ?>" class="recent-16" data-aos="fade-up">
                                <div class="recent-img16 img-fluid img-center" style="background-image: url(Admin/project_image/<?php echo $img1;?>)">
                                
                                </div>
                                <div class="recent-content"></div>
                                <div class="recent-details">
                                    <div class="recent-title"><?php echo $project_name;?></div>
                                    <!--<div class="recent-price">₹<?php echo $new_price;?></div>-->
                                    <!--<div class="house-details"><?php echo $pcategory;?></div>-->
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
                                    <div class=service-icon-box><img src="Admin/category_image/<?php echo $img;?>" alt=""></div>
                                    <div class="service-content-box mt-1">
                                        <h3><a href="shop.php?astringdata2=<?php echo $row2['name'];?>"><b><?php echo $name;?></b></a></h3>
                                        <p><?php echo $count;?> Products</p>
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
                            <p style="color:white !important;" class="text-center mb-4 p-0"><b>Ethical working and Integrity is our strength</b></p>
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
                                <div _ngcontent-bgi-c3="" class="icon color-fb7756"><img src="images/icons/i-5.svg" width="85" height="85" alt=""></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">UNIQUENESS</h3>
                                <p _ngcontent-bgi-c3="">The furniture we craft is exclusively as per your taste & hence has its own uniqueness.</p><a _ngcontent-bgi-c3="" class="read-more-btn" href="about-us.php">Read More</a></div>
                        </div>
                        <div _ngcontent-bgi-c3="" class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up">
                            <div _ngcontent-bgi-c3="" class="single-featured-box">
                                <div _ngcontent-bgi-c3="" class="icon color-facd60"><img src="images/icons/i-6.svg" width="85" height="85" alt=""></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">BEST FINISHING</h3>
                                <p _ngcontent-bgi-c3="">FINISHING- The furniture is crafted on machines, the edges are also covered with hot press Edge bands.
</p><a _ngcontent-bgi-c3="" class="read-more-btn" href="about-us.php">Read More</a></div>
                        </div>
                        <div _ngcontent-bgi-c3="" class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up">
                            <div _ngcontent-bgi-c3="" class="single-featured-box">
                                <div _ngcontent-bgi-c3="" class="icon color-1ac0c6"><img src="images/icons/i-7.svg" width="85" height="85" alt=""></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">COST EFFECTIVE</h3>
                                <p _ngcontent-bgi-c3="">If all the parameters are compared, our crafted furniture should be economical than other similar products.</p><a _ngcontent-bgi-c3="" class="read-more-btn" href="about-us.php">Read More</a></div>
                        </div>
                        <div _ngcontent-bgi-c3="" class="col-lg-3 col-sm-6 col-md-6 p-0" data-aos="fade-up">
                            <div _ngcontent-bgi-c3="" class="single-featured-box">
                                <div _ngcontent-bgi-c3="" class="icon"><img src="images/icons/i-8.svg" width="85" height="85" alt=""></div>
                                <h3 _ngcontent-bgi-c3="" class="mt-5">HYGIENE</h3>
                                <p _ngcontent-bgi-c3="">The furniture is being crafted at our factory, only erection and fitting is to be done at customer’s premises.
</p><a _ngcontent-bgi-c3="" class="read-more-btn" href="about-us.php">Read More</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section><br/><br/>
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
                    <!--            <a href="product.php?astringdata=<?php echo $encode_id; ?>"><img src="Admin/product_image/<?php echo $img1;?>" alt="" /></a>-->
                                
                    <!--        </div>-->
                    <!--    </div>-->
                       
                    <!--        <div class="shop-info bl mb-4">-->
                    <!--        <h3 style="color:black !important;" class="text-center"><a href="product.php?astringdata=<?php echo $encode_id; ?>" style="color:black !important;"><b><?php echo $pname;?></b></a></h3>-->
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
                    <!--        <p class="product-old-price text-center" style="margin-top:-3%;" >₹<?php echo $old_price;?></p>-->
                    <!--        <p class="recent-price text-center" style="margin-top:-2%;">₹<?php echo $new_price;?></p>-->
                    <!--        <div class="text-center">-->
                    <!--            <a class="btn1 btn-sm" style="font-size:1.1rem !important;" href="product.php?astringdata=<?php echo $encode_id; ?>">View Detail</a>-->
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
                            <p class="pt-2">There are countless elements which makes you, uniquely you. Furniture has a personality too! <br/>With customized furniture, the spaces can be made to speak the language that the owner wants it to. It can be crafted up to the optimum space available. We at the BOSK INFRACON PRIVATE LIMITED deliver it with highest accuracy a machine can give. Custom-crafted furniture made imported machines can have the perfect fit and be highly efficient. It can be designed to fit your space to the tee. </p>
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
                        <br/>
                        <p>Today visited this showroom, and Today treated very nicely, gone through entire products and found very quality products with transperent rate Analysis.be the customer Definitely will be the customer of this Showroom.<br/>Thank You..!</p><br/>
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Rajesh Deomurari</h3>
                        <!--<img src="images/testimonials/ts-2.jpg" alt="">-->
                        <h6 class="mt-2">Ahmedabad</h6>
                        <br/>
                        <p>A much required system.I was astonish to hear that planning furniture in house is so systematic.He has scientific approach And very effective thing is transperary in the work. He is after quality and workmanship,He has vision and good imagination power. I wish all my heart wish him a great Success.</p>
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Jay Patel</h3>
                        <!--<img src="images/testimonials/ts-6.jpg" alt="">-->
                        <h6 class="mt-2">Amreli</h6>
                        <br/>
                        <p>I am pleased with the explanation about products and material range was really exiting..I really recommended this service to others with explanations..I really like to apperieciate the amount of time spend to walk their different days of concepts..<br/>Thank You..</p><br/>
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Kaivalya Pathak</h3>
                        <!--<img src="images/testimonials/ts-4.jpg" alt="">-->
                        <h6 class="mt-2">Jamnagar</h6>
                        <br/>
                        <p>Came here for first time and we appericiate the concept and kind of dsesign you provide at minimal rate.We liked the ambiance as well as the staff and way they explained their design and work..Overall Great Visit..!!</p><br/><br/>
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Abhishek Mehta</h3>
                        <!--<img src="images/testimonials/ts-2.jpg" alt="">-->
                        <h6 class="mt-2">Junagadh</h6>
                        <br/>
                        <p>I am working in Import-Export department at bhavnagar.I am visiting at your gallery Bosk Furniture.I am happy to share my feedback that very simple and beautiful structure with color combination.I will contact to you in future whenever i required..Thanks..</p><br/>
                    </div>
                    <div class="test-1" data-aos="zoom-in">
                        <h3>Sandip Chauhan</h3>
                        <!--<img src="images/testimonials/ts-6.jpg" alt="">-->
                        <h6 class="mt-2">Vadodara</h6>
                        <br/>
                        <p>Showroom lights and color combination is very good..Very good over selection for color at showroom..For concept of furniture making i personally fell time saving compare to making all things on site..<br/>Thanks..</p><br/><br/>
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
                                         
                        $cmd4="select * from blog order by id DESC limit 4";
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
                        <div class="col-xl-6 col-md-12 col-xs-12 mt-5" data-aos="fade-right">
                            <div class="news-item news-item-sm">
                                <a href="details.php?astringdata=<?php echo $encodeblog_id; ?>" class="news-img-link">
                                    <div class="news-item-img">
                                        <img class="resp-img" src="Admin/blog_image/<?php echo $img;?>" alt="blog image">
                                    </div>
                                </a>
                                <div class="news-item-text">
                                    <a href="details.php?astringdata=<?php echo $encodeblog_id; ?>"><h3><?php echo $blog_title;?></h3></a>
                                    <span class="date"><?php echo $blog_date;?> &nbsp;/&nbsp; By Admin&nbsp;/&nbsp;<a href="details.php?astringdata=<?php echo $encodeblog_id; ?>" class="news-link">Read more...</a></span>
                                   
                                    <div class="news-item-descr mb-2">
                                        <p><?php echo $blog_description;?></p>
                                    </div>
                                    
                                </div>
                            </div>
                           
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
        <div class="partners bg-white-3 border-0" data-aos="zoom-in">
            <div class="container">
                <div class="owl-carousel style2">
                    <div class="owl-item"><img src="images/partners/1.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/2.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/3.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/4.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/5.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/6.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/7.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/8.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/9.png" alt=""></div>
                    <div class="owl-item"><img src="images/partners/10.png" alt=""></div>
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

    </div>
    <!-- Wrapper / End -->
</body>

</html>
