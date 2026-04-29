<?php
include_once("connect.php");
if(isset($_GET['astringdata']))
	{
	    $blogid = mysqli_real_escape_string($con,$_GET['astringdata']);
	   // $encodeblogid = base64_decode($blogid);
	    
	    $cmd3="select * from blog where id='$encodeblogid'";
        $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
        while($row3=mysqli_fetch_array($result3))
        {
            $blog_title=$row3['blog_title'];
           
        }

?>
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
     <?php
        $cmd="select * from blog where id='$blogid'";
        $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
        $row=mysqli_fetch_array($result);
            // $id = $row['id'];
            $blog_title=$row['blog_title'];
            $blog_description=$row['blog_description'];
            $blog_date=$row['blog_date'];
            $img=$row['img'];
                 
        ?>
       
        
        <!-- START SECTION BLOG -->
        <section class="blog blog-section bg-white list-side">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 blog-pots">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="news-item details no-mb2">
                                    <a href="#" class="news-img-link">
                                        <div class="news-item-img">
                                            <img class="img-responsive" src="Admin/blog_image/<?php echo $img;?>" alt="blog image">
                                        </div>
                                    </a>
                                    <div class="news-item-text details pb-0">
                                        <a href="#"><h3><?php echo $blog_title?></h3></a>
                                        <!--<div class="dates">-->
                                        <!--    <span class="date"><?php echo $blog_date;?> &nbsp;/</span>-->
                                        <!--    <ul class="action-list pl-0">-->
                                        <!--        <li class="action-item pl-2"><i class="fa fa-heart"></i> <span>306</span></li>-->
                                        <!--        <li class="action-item"><i class="fa fa-comment"></i> <span>34</span></li>-->
                                        <!--        <li class="action-item"><i class="fa fa-share-alt"></i> <span>122</span></li>-->
                                        <!--    </ul>-->
                                        <!--</div>-->
                                        <div class="news-item-descr big-news details visib mb-0">
                                            <p class=""><?php echo $blog_description;?></p>

                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="comments">
                           
                          
                          
                           
                        </section>
                        <section class="leve-comments wpb">
                            <h3 class="mb-5">Leave a Comment</h3>
                            <div class="row">
                                <div class="col-md-12 data">
                                    <form onsubmit="return contact_us(this);" id="MyForm" method="post">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" placeholder="First Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="number" name="phone" class="form-control" placeholder="Contact Number" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 form-group">
                                            <textarea class="form-control" name="msg" id="exampleTextarea" rows="8" placeholder="Message" required></textarea>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-lg mt-2">Post Comment</button>
                                    </form>
                                     <div id="return"></div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <aside class="col-lg-3 col-md-12">
                        <div class="widget">
                           
                           
                            
                            <div class="recent-post pt-5">
                                <h5 class="font-weight-bold mb-4">Recent Posts</h5>
                                 <?php
                                include_once"connect.php";
                                                 
                                $cmd1="select * from blog limit 7";
                                $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
                                while($row1=mysqli_fetch_array($result1))
                                {     
                                    $id = $row1['id'];
                                    //  $encodeblog_id=base64_encode($id);
                                    $blog_title=$row1['blog_title'];
                                    $blog_description=$row1['blog_description'];
                                    $blog_date=$row1['blog_date'];
                                    $img=$row1['img'];
                                ?>
                               
                               
                                <div class="recent-main no-mb mt-3">
                                    <div class="recent-img">
                                        <a href="details.php?astringdata=<?php echo $id; ?>"><img src="Admin/blog_image/<?php echo $img;?>" alt=""></a>
                                    </div>
                                    <div class="info-img">
                                        <a href="details.php?astringdata=<?php echo $id; ?>"><h6><?php echo $blog_title;?></h6></a>
                                        <a href="details.php?astringdata=<?php echo $id; ?>"><p>Read More..</p></a>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
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
</body>

</html>
<?php
}
?>