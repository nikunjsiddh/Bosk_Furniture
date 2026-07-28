<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");
if(isset($_GET['astringdata']) && isset($_GET['astringdata1']) && isset($_GET['astringdata2']))
	{
	    $product_id = mysqli_real_escape_string($con,$_GET['astringdata']);
	    $decode_product_id = base64_decode($product_id);
	    $user_id = mysqli_real_escape_string($con,$_GET['astringdata1']);
	    $order_id = mysqli_real_escape_string($con,$_GET['astringdata2']);
	   //echo $decoded_user_id;
$page_title       = 'Return Request | Bosk Furniture Returns India';
$page_description = 'Submit a return request for your Bosk Furniture order. Quick, easy and customer-friendly returns process across India.';
$page_keywords    = 'furniture return, return request, bosk furniture returns, return policy india';
$page_canonical   = '/return_request';
$page_robots      = 'noindex, follow';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="toastr/toastr.css">
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
                    <h1 class="text-center">Return Request</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="/">Home</a><span>»</span><span>Return Request</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->
       
        <!-- START SECTION CONTACT -->
        <section id="contact" class="contact">
            <div class="container">
                <div class="section-title ml-3">
                    <h3>Return Request?</h3>
                    <h2>CONTACT US</h2>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <form onsubmit="return rq(this);" id="myform" method="post" enctype="multipart/form-data" class="contact-form" >
                            <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
                            <input type="hidden" name="product_id" value="<?php echo $decode_product_id;?>">
                            <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
                            <div class="form-group">
                                <input type="text" required class="form-control input-custom input-full" name="firstname" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" required class="form-control input-custom input-full" name="lastname" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input-custom input-full" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control input-custom input-full" name="img1" placeholder="no file choosen">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control input-custom input-full" name="img2" placeholder="no file choosen">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control input-custom input-full" name="img3" placeholder="no file choosen">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control input-custom input-full" name="img4" placeholder="no file choosen">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control input-custom input-full" name="img5" placeholder="no file choosen">
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control input-custom input-full" name="phone" placeholder="Contact Number">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control textarea-custom input-full" id="ccomment" name="msg" required rows="8" placeholder="Message"></textarea>
                            </div>
                            <div class="box bg-3 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg" name="submit" id="submit" style="background-color:#532A1A;color:white;">Submit</button>
                            </div>
                        </form>
                        <div id="return"></div>
                    </div>
                    <div class="col-md-4 info-touch">
                        <h4>Keep In Touch</h4>
                        <div class="my-info">
                            <div class="in1">
                                <div class="address">
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i> 95 South Park Ave.</p>
                                </div>
                                <div class="email">
                                    <p><i class="fa fa-envelope" aria-hidden="true"></i> info@blanca.com</p>
                                </div>
                            </div>
                            <div class="in1">
                                <div class="phone">
                                    <p><i class="fa fa-phone" aria-hidden="true"></i> (234) 0200 17813</p>
                                </div>
                                <div class="whatssap">
                                    <p><i class="fa fa-whatsapp" aria-hidden="true"></i> (234) 0200 17813</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END SECTION CONTACT -->

       

      <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        
       
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
       <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mmenu.min.js"></script>
        <script src="js/mmenu.js"></script>
        <script src="js/jquery.easing.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/lightcase.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/inner-script.js"></script>
        <script>
            $(window).on('scroll load', function() {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });

        </script>


    </div>
    <!-- Wrapper / End -->
   
    <script src="js/add/return_request.js"></script>
    <script src="toastr/toastr.min.js"></script>
</body>

</html>
<?php
}
?>