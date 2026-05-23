<?php
$page_title       = 'Our Projects | Bosk Furniture Interior Design Portfolio India';
$page_description = 'Explore completed Bosk Furniture interior design projects - modular kitchens, residential interiors and custom furniture installations across India.';
$page_keywords    = 'bosk furniture projects, interior design portfolio, modular kitchen projects, home interior projects india';
$page_canonical   = '/projects';
$page_breadcrumbs = [
    ['name' => 'Home',     'url' => '/'],
    ['name' => 'Projects', 'url' => '/projects']
];
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
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
                    <h1 class="text-center">Projects</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>Projects</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

        <!-- START SECTION PORTFOLIO -->
        <section class="portfolio">
            <div class="container">
                <!--<div class="filters-group">-->
                <!--    <ul>-->
                <!--        <li class="active" data-filter="*">Show All</li>-->
                <!--        <li data-filter=".people">Residential</li>-->
                <!--        <li data-filter=".landscapes">Commercial</li>-->
                <!--        <li data-filter=".web">Office</li>-->
                <!--        <li data-filter=".graphic">Hospitaly</li>-->
                <!--    </ul>-->
                <!--</div>-->
                <div class="row portfolio-items">
                    <?php
                        include_once"connect.php";
                                 
                                  $cmd1="select * from projects order by id DESC limit 8";
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
                  
                    
                    
                    <div class="item col-lg-4 col-sm-6 col-xs-12 landscapes last-item two">
                        <div class="single-portfolio">
                            <div class="portfolio-img mb-3">
                                 <a href="project-details.php?astringdata=<?php echo $encode_project_id; ?>"><img src="Admin/project_image/<?php echo $img1;?>" alt="" /></a>
                                <div class="portfolio-view">
                                    <!--<div class="item-wrap">-->
                                    <!--    <a class="img-poppu" href="project-details.php?astringdata=<?php echo $encode_project_id; ?>" data-rel="lightcase:myCollection:slideshow">-->
                                          
                                    <!--    </a>-->
                                    <!--</div>-->
                                </div>
                            </div>
                           
                            <div class="portfolio-text">
                                <a href="project-details.php?astringdata=<?php echo $encode_project_id; ?>"><h4><?php echo $project_name; ?></h4></a>
                            </div>
                        </div>
                         <a style="text-align:center;font-weight:bolder !important;color:black !important;" href="project-details.php?astringdata=<?php echo $encode_project_id; ?>"><h4><?php echo $project_name; ?></h4></a>
                    </div>
                    
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>
        <!-- END SECTION PORTFOLIO -->

         <?php include_once"design/footer.php";?>

        <!-- START PRELOADER -->
        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>
        </div>
    <!-- Wrapper / End -->
</body>

</html>
