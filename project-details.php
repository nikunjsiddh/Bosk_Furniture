<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");
if(isset($_GET['astringdata']))
	{
	    $project_post_id = mysqli_real_escape_string($con,$_GET['astringdata']);
	    $decoded_id = base64_decode($project_post_id);
	    
	    $cmd3="select * from projects where id='$decoded_id'";
        $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
        while($row=mysqli_fetch_array($result3))
        {
            $project_name=$row['project_name'];
            // echo $project_name;

        }

// ---- Dynamic SEO for project ----
$_seo_proj        = isset($project_name) && $project_name !== '' ? $project_name : 'Project';
$page_title       = $_seo_proj . ' | Bosk Furniture Interior Design Projects India';
$page_description = 'Explore the ' . $_seo_proj . ' interior design project by Bosk Furniture - showcasing modular furniture, custom interiors and quality craftsmanship across India.';
$page_keywords    = $_seo_proj . ', interior design project, modular furniture project, bosk furniture portfolio india';
$page_canonical   = '/project-details.php?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '');
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
</head>

<body class="inner-page">
    <!-- Wrapper -->
    <div id="wrapper">
       <?php include_once"design/nav.php";?>
        <div class="clearfix"></div>
        <!-- Header Container / End -->

        <section class="headings">
            <div class="text-heading">
                <div class="container">
                    <h1 class="text-center"><?php echo $project_name;?></h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>PROJECT DETAILS</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->
        <?php
        include_once"connect.php";
        $cmd="select * from projects where id='$decoded_id'";
        $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
               $row = mysqli_fetch_assoc($result);                        
                $id = $row['id'];
                $project_name=$row['project_name'];
                $pro_desc=$row['pro_desc'];
                $interior_detail=$row['interior_detail'];
                $img1=$row['img1'];
                $img2=$row['img2'];
                                     
        ?>
        <!-- START SECTION PROJECTS SINGLE -->
        <section class="service-details">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 project-info">
                        <div class="row">
                            <div class="col-md-12 hover-effect">
                                <a href="blog-details.html">
                                    <figure><img src="Admin/project_image/<?php echo $img1;?>" alt=""></figure>
                                </a>
                                <div class="project-text">
                                    <h3 class="mt-3">Design Planning</h3>
                                    
                                    <p class="mb-4"><?php echo $pro_desc;?></p>

                                    <h3 class="mt-4">Interior Detail</h3>
                                    <img src="Admin/project_image/<?php echo $img2;?>" class="mb-3" alt="">
                                    <p class="mb-4"><?php echo $interior_detail;?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <aside class="col-lg-3 col-md-12">
                        <div class="widget-service-details car">
                           
                            <div class="business-service py-5">
                                <h5 class="font-weight-bold mb-4">Recent Works</h5>
                                <?php
                                 include_once"connect.php";
                                 $count=0;
                                  $cmd="select * from projects order by id desc limit 12";
                                  $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                  while($row=mysqli_fetch_array($result))
                                  {     
                                      $id = $row['id'];
                                      $count=$count+1;
                                      $project_name=$row['project_name'];
                                      $pro_desc=$row['pro_desc'];
                                      $interior_detail=$row['interior_detail'];
                                      $img1=$row['img1'];
                                      $img2=$row['img2'];
                                      $encode_project_id=base64_encode($id);
                                     
                                  ?>
                                <div class="recent-main">
                                    <div class="recent-img">
                                        <a href="project-details.php?astringdata=<?php echo $encode_project_id; ?>"><img src="Admin/project_image/<?php echo $img1;?>" alt=""></a>
                                    </div>
                                    <div class="info-img">
                                        <a href="project-details.php?astringdata=<?php echo $encode_project_id; ?>"><h6><?php echo $project_name;?></h6></a>
                                        <a style="text-decoration:underline;" href="project-details.php?astringdata=<?php echo $encode_project_id; ?>"><b>Learn More</b></a>
                                    </div>
                                </div><br/>
                                <?php
                                  }
                                ?>
                               
                               
                            </div>
                            <div class="business-service">
                                <h5 class="font-weight-bold mb-4">Popolar Tags</h5>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Renovation</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Interior</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Building</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Electrician</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Exterior Design</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Plumber</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Carpenter</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Construction</a></span>
                                </div>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary">Remodeling</a></span>
                                    <span><a href="#" class="btn btn-outline-primary">Painting</a></span>
                                </div>
                            </div>
                            </div>
                    </aside>
                </div>
            </div>
        </section>
        <!-- END SECTION PROJECTS SINGLE -->

       <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <!-- Wrapper / End -->
</body>

</html>
<?php

}
?>