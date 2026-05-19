<?php
// Only start a session if one isn't already active.
// This prevents "session already started" notices and "headers already sent"
// warnings when this nav is included from pages that have already output HTML.
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}
?>
<style>
    .table-image {

        td,
        th {
            vertical-align: middle;
        }
    }

    .minicart-icon .item-count {
        background: #532A1A;
        color: #ffffff;
        position: absolute;
        bottom: 22px;
        right: -2px;
        width: 19px;
        height: 19px;
        line-height: 20px;
        border-radius: 50%;
        font-size: 12px;
        text-align: center;
    }

    @media only screen and (max-width: 600px) {
        .element {
            display: none;
            /* Hide the element on smaller screens */
        }
    }

    @media only screen and (max-width: 1292px) {
        #logo.logo-white img {
            margin-right: 122% !important;
            width: 166px !important;
        }
    }

    @media only screen and (max-width: 991px) {
        #logo.logo-white img {
            margin-top: -41px !important;
            margin-right: 122% !important;
            width: 166px !important;
        }
    }

    @media only screen and (max-width: 667px) {
        #logo.logo-white img {
            margin-top: -41px !important;
            margin-right: 76% !important;
            width: 166px !important;
        }
    }

    @media only screen and (max-width: 567px) {
        #logo.logo-white img {
            margin-top: -41px !important;
            margin-right: 76% !important;
            width: 166px !important;
        }
    }

    @media only screen and (max-width: 434px) {
        #logo.logo-white img {
            margin-top: -34px !important;
            margin-right: 71% !important;
        }
    }

    @media only screen and (max-width: 341px) {
        #logo.logo-white img {
            margin-top: -24px !important;
            margin-right: 71% !important;
        }
    }
</style>

<header id="header-container">
    <!-- Header -->
    <div id="header" class="head-tr bottom ">
        <div class="container-fluid int_content_wraapper">
            <!-- Left Side Content -->
            <div class="left-side">
                <!-- Logo -->
                <div id="logo" class="col-lg-2 logo-white">
                    <a href="index.php"><img src="images/logo-black.png" alt=""></a>
                </div>
                <!-- Mobile Navigation -->
                <div class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
                <!-- Main Navigation -->
                <nav id="navigation" class="style-1 white">
                    <ul id="responsive">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li><a href="all_products.php">Shop</a>
                            <!--<ul>-->
                            <?php
                                        //  include_once"connect.php";
                                         
                                        //   $cmd="select * from category";
                                        //   $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                        //   while($row=mysqli_fetch_array($result))
                                        //   {     
                                        //       $id = $row['id'];
                                        //       $name=$row['name'];
                                        //       $img=$row['img'];
                                          ?>
                            <!--<li><a href="shop.php?astringdata2=<?php echo $row['name'];?>"><?php echo $name;?></a>-->
                            <!--</li>-->
                            <?php
                                        //   }
                                        ?>
                            <!--</ul>-->
                        </li>

                        <li>
                            <a href="about-us.php">About Us</a>
                        </li>
                        <li>
                            <a href="blog-full-list.php">Blog</a>
                        </li>
                        <li>
                            <a href="design-order-process.php">How We Works</a>
                        </li>
                        <li>
                            <a href="contact.php">Contact Us</a>
                        </li>
                        <?php
                                                include_once"connect.php";
                                                $hi = 0;
                                                $user_id = 0;
                                                $email = '';
                                                if (isset($_SESSION['email'])) {
                                                    $userEmail = mysqli_real_escape_string($con, $_SESSION['email']);
                                                    $cmd = "select * from user where email='$userEmail'";
                                                    $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
                                                    $row = mysqli_fetch_array($result);

                                                    if ($row) {
                                                        $user_id = $row['id'];
                                                        $email   = $row['email'];

                                                        $cmd1 = "select * from cart where user_id='$user_id'";
                                                        $result1 = mysqli_query($con, $cmd1) or die(mysqli_error($con));
                                                        $hi = mysqli_num_rows($result1);
                                                    }
                                                    ?>
                        <li><a href="cart.php">
                                <div class="minicart-icon wishlist-icon">
                                    Cart <i class="fa fa-shopping-cart"></i>
                                    <span class="item-count element">
                                        <?php echo $hi;?>
                                    </span>
                                </div>
                            </a>

                        </li>
                        <li><a href="profile.php">Account <i class="fa fa-user"></i></a>
                            <ul>
                                <li><a href="profile.php">My Account</a>
                                </li>
                                <li><a href="logout.php">logout</a>
                                </li>

                            </ul>
                            <!--<ul>-->
                            <!--    <li><br/>-->
                            <!--    <center><img class="rounded-circle shadow-4-strong" src="images/1.jpg"  width="200" height="100"> </center><br/> -->
                            <!--   <center> <p><b>Welcome , Aayushi Vora</b></p></center>-->
                            <!--    <div class="row">-->
                            <!--            <div class="col-md-1"></div>-->
                            <!--            <div class="col-md-5"><a href="profile.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">View Profile</a></div>-->
                            <!--            <div class="col-md-5"><a href="profile.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">Edit Profile</a></div>-->
                            <!--            <div class="col-md-1"></div>-->
                            <!--        </div><br/>-->
                            <!--    </li>-->

                            <!--</ul>-->
                        </li>
                        <?php
                                                }else{
                                                    ?>
                        <li><a href="cart.php">
                                <div class="minicart-icon wishlist-icon">
                                    Cart <i class="fa fa-shopping-cart"></i>
                                    <span class="item-count element">0</span>
                                </div>
                            </a>

                        </li>
                        <li><a href="profile.php">Account <i class="fa fa-user"></i></a>
                            <ul>
                                <li><a href="profile.php">My Account</a>
                                </li>
                                <li><a href="login.php">Login/Register</a>
                                </li>
                            </ul>
                            <!--<ul>-->
                            <!--    <li><br/>-->
                            <!--    <center><img class="rounded-circle shadow-4-strong" src="images/1.jpg"  width="200" height="100"> </center><br/> -->
                            <!--   <center> <p><b>Welcome , Aayushi Vora</b></p></center>-->
                            <!--    <div class="row">-->
                            <!--            <div class="col-md-1"></div>-->
                            <!--            <div class="col-md-5"><a href="profile.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">View Profile</a></div>-->
                            <!--            <div class="col-md-5"><a href="profile.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">Edit Profile</a></div>-->
                            <!--            <div class="col-md-1"></div>-->
                            <!--        </div><br/>-->
                            <!--    </li>-->

                            <!--</ul>-->
                        </li>
                        <?php
                                                }
                                ?>



                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->
            </div>
            <!-- Left Side Content / End -->

        </div>
    </div>
    <!-- Header / End -->

</header>

<!--<style>-->
<!-- .table-image {-->
<!--  td, th {-->
<!--    vertical-align: middle;-->
<!--  }-->
<!--}-->
<!--.-->
<!--</style>-->
<!--<header id="header-container" class="header head-tr">-->
<!-- Header -->
<!--            <div id="header" class="head-tr bottom">-->
<!--                <div class="container">-->
<!-- Left Side Content -->
<!--                    <div class="left-side">-->
<!-- Logo -->
<!--                        <div id="logo" class="col-lg-2 logo-white">-->
<!--                            <a href="index.php"><img src="images/logo-white-1.png" data-sticky-logo="images/logo-black.png" alt=""></a>-->
<!--                        </div>-->
<!-- Mobile Navigation -->
<!--                        <div class="mmenu-trigger">-->
<!--                            <button class="hamburger hamburger--collapse" type="button">-->
<!--                                <span class="hamburger-box">-->
<!--							<span class="hamburger-inner"></span>-->
<!--                                </span>-->
<!--                            </button>-->
<!--                        </div>-->
<!-- Main Navigation -->
<!--                        <nav id="navigation" class="style-1 head-tr">-->
<!--                            <ul id="responsive">-->
<!--                                <li>-->
<!--                                    <a href="index.php">Home</a>-->
<!--                                </li>-->

<!--                                <li><a href="shop.php">Products</a>-->
<!--                                    <ul>-->
<!--                                        <li><a href="shop.php">All Products</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="residental-interior.php">Residential Interior</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="commercial-interior.php">Commercial Interior</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="office-interior.php">Office Interior</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="hospitality-design.php">Hospitality Design</a>-->
<!--                                        </li>-->
<!--                                        <li><a href="modern-furniture.php">Modern Furniture</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->

<!--                                <li>-->
<!--                                    <a href="about-us.php">About Us</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="blog-full-list.php">Blog</a>-->
<!--                                </li>-->

<!--                                <li>-->
<!--                                    <a href="contact.php">Contact Us</a>-->
<!--                                </li>-->
<!--                                <li><a href="cart.php"><i class="fa fa-shopping-cart"></i></a>-->
<!--                                    <ul>-->
<!--                                        <li>-->
<!--                                        <table class="table table-image">-->
<!--                                		  <thead>-->
<!--                                		    <tr>-->
<!--                                		      <th scope="col">Index</th>-->
<!--                                		      <th scope="col">Image</th>-->
<!--                                		      <th scope="col">Name</th>-->
<!--                                		      <th scope="col">Price</th>-->

<!--                                		    </tr>-->
<!--                                		  </thead>-->
<!--                                		  <tbody>-->
<!--                                		    <tr>-->
<!--                                		      <th scope="row">1</th>-->
<!--                                		      <td class="w-25">-->
<!--                                			      <img src="images/interior/p-1.png" class="img-fluid img-thumbnail" alt="Sheep">-->
<!--                                		      </td>-->
<!--                                		      <td>Product 1</td>-->
<!--                                		      <td>200</td>-->

<!--                                		    </tr>-->
<!--                                		    <tr>-->
<!--                                		      <th scope="row">2</th>-->
<!--                                		      <td class="w-25">-->
<!--                                			      <img src="images/interior/p-1.png" class="img-fluid img-thumbnail" alt="Sheep">-->
<!--                                		      </td>-->
<!--                                		      <td>Product 2</td>-->
<!--                                		      <td>300</td>-->

<!--                                		    </tr>-->
<!--                                		  </tbody>-->
<!--                                		</table>   -->
<!--                                        </li>-->
<!--                                        <center>-->
<!--                                        <li>-->
<!--                                            <a style="color:#532A1A !important;" href="residental-interior.php">Subtotal - 1500</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color:#532A1A !important;" href="residental-interior.php">Gst & Tax - 500</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color:#532A1A !important;" href="residental-interior.php">Shipping - 50</a>-->
<!--                                        </li>-->
<!--                                         <li>-->
<!--                                            <a style="color:#532A1A !important;" href="residental-interior.php">Total - 2050</a>-->
<!--                                        </li>-->

<!--                                        <li style="disply:inline;">-->
<!--                                            <div class="row">-->
<!--                                                <div class="col-md-1"></div>-->
<!--                                                <div class="col-md-5"><a href="cart.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">View Cart</a></div>-->
<!--                                                <div class="col-md-5"><a href="checkout.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">Checkout</a></div>-->
<!--                                                <div class="col-md-1"></div>-->
<!--                                            </div><br/>-->


<!--                                        </li>-->
<!--                                        </center>-->
<!--<li><button class="btn btn-primary"><a href="checkout.php">Checkout</a></button>-->
<!--</li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li><a href="profile.php"><i class="fa fa-user"></i></a>-->
<!--                                    <ul>-->
<!--                                        <li><a href="profile.php">My Account <i class="fa fa-eye"></i> </a>-->
<!--                                        </li>-->
<!--                                        <li><a href="profile.php">Edit Profile <i class="fa fa-pencil"></i> </a>-->
<!--                                        </li>-->
<!--                                        <li><a href="login.php">logout <i class="fa fa-sign-out"></i></a>-->
<!--                                        </li>-->

<!--                                    </ul>-->
<!--<ul>-->
<!--    <li><br/>-->
<!--    <center><img class="rounded-circle shadow-4-strong" src="images/1.jpg"  width="200" height="100"> </center><br/> -->
<!--   <center> <p><b>Welcome , Aayushi Vora</b></p></center>-->
<!--    <div class="row">-->
<!--            <div class="col-md-1"></div>-->
<!--            <div class="col-md-5"><a href="profile.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">View Profile</a></div>-->
<!--            <div class="col-md-5"><a href="profile.php" style="text-align:center;color:white !important;" class="btn btn-dark btn-theme-colored btn-xl">Edit Profile</a></div>-->
<!--            <div class="col-md-1"></div>-->
<!--        </div><br/>-->
<!--    </li>-->

<!--</ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="wishlist.php"><i class="fa fa-heart"></i></a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </nav>-->

<!--                        <div class="clearfix"></div>-->
<!-- Main Navigation / End -->
<!--                    </div>-->
<!-- Left Side Content / End -->

<!--                </div>-->
<!--            </div>-->
<!-- Header / End -->

<!--        </header>-->