<!DOCTYPE HTML>
<html class="no-js" lang="zxx">

<head>
    <?php include_once"design/header.php";?>

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
                    <h1 class="text-center">BLOG</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>BLOG</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

        <!-- START SECTION BLOG -->
        <section class="blog-section">
            <div class="container">
                <div class="news-wrap">
                    <div class="row">
                         <?php
                        include_once"connect.php";
                                         
                        $cmd="select * from blog";
                        $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                        while($row=mysqli_fetch_array($result))
                        {     
                            $id = $row['id'];
                            $blog_title=$row['blog_title'];
                            $blog_description=$row['blog_description'];
                            $blog_date=$row['blog_date'];
                            $img=$row['img'];
                        ?>
                        <div class="col-lg-12 col-md-12 col-xs-12 mt-5">
                            <div class="news-item news-item-sm">
                                <a href="details.php?astringdata=<?php echo $id; ?>" class="news-img-link">
                                    <div class="news-item-img">
                                        <img class="resp-img" src="Admin/blog_image/<?php echo $img;?>" alt="blog image">
                                    </div>
                                </a>
                                <div class="news-item-text">
                                    <a href="details.php?astringdata=<?php echo $id; ?>"><h3><?php echo $blog_title;?></h3></a>
                                    <!--<div class="dates">-->
                                    <!--    <span class="date"><?php echo $blog_date;?></span>-->
                                    <!--    <ul class="action-list pl-0">-->
                                    <!--        <li class="action-item pl-2"><i class="fa fa-heart"></i> <span>306</span></li>-->
                                    <!--        <li class="action-item"><i class="fa fa-comment"></i> <span>34</span></li>-->
                                    <!--        <li class="action-item"><i class="fa fa-share-alt"></i> <span>122</span></li>-->
                                    <!--    </ul>-->
                                    <!--</div>-->
                                    <div class="news-item-descr">
                                        <p><?php echo $blog_description;?></p>
                                    </div>
                                    <div class="news-item-bottom">
                                        <a href="details.php?astringdata=<?php echo $id; ?>" class="news-link">Read more...</a>
                                        <!--<div class="admin">-->
                                        <!--    <p>By, Karl Smith</p>-->
                                        <!--    <img src="images/testimonials/ts-1.jpg" alt="">-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
                           
                        </div><br/><br/>
                       <?php
                        }
                       ?>
                    </div>
                    
                    
                    
                   
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
</body>

</html>
