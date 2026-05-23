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

    /* ============================================================
       HEADER LAYOUT — compact flex row.

       menu.css ships a tangle of legacy rules that fight each other:
         - #header { padding: 22px 0 80px 0 }      → 102px tall
         - #logo  { margin-top: -31px }            → pulls logo up
         - #logo.logo-white img { margin-top:-1.3vw; margin-bottom:-2.7vw; margin-left:95px }
         - #navigation { margin-top: 9px; margin-left: 77px }
         - 8+ media queries with NEGATIVE margin-left on #navigation
           (-5.9vw → -11.9vw) and even margin-left:-74.7vw on the
           logo image, all of which drag the menu *under* the logo.

       The cloned sticky header inherits everything, so on scroll the
       logo and first menu item ("Home") overlap.

       We replace the whole mess with a single flex row of a fixed,
       sane height for both the in-flow header and the sticky clone.
       ============================================================ */

    /* The row itself — taller so the large logo fits comfortably */
    #header.head-tr,
    #header.cloned {
        padding: 0 !important;
        height: 140px !important;
        min-height: 140px !important;
        background-color: #fff !important;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
    }
    #header.cloned {
        height: 130px !important;
        min-height: 130px !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.10);
    }

    #header .int_content_wraapper {
        height: 100% !important;
        padding-left: 24px !important;
        padding-right: 24px !important;
    }

    #header .left-side {
        width: 100% !important;
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        float: none !important;
    }

    /* Logo — fixed width, vertically centred, real gap before the nav */
    #header #logo,
    #header.cloned #logo {
        float: none !important;
        display: inline-flex !important;
        align-items: center !important;
        margin: 0 40px 0 0 !important;
        padding: 0 !important;
        flex: 0 0 auto !important;
    }
    #header #logo a,
    #header.cloned #logo a {
        display: inline-flex !important;
        align-items: center !important;
        line-height: 0 !important;
    }
    #header #logo img,
    #header.cloned #logo img,
    #header #logo.logo-white img,
    #header.cloned #logo.logo-white img {
        margin: 0 !important;
        padding: 0 !important;
        max-height: 120px !important;
        width: auto !important;
        height: auto !important;
        max-width: 240px !important;
        display: block !important;
        float: none !important;
    }
    #header.cloned #logo img,
    #header.cloned #logo.logo-white img {
        max-height: 112px !important;
        max-width: 230px !important;
    }

    /* Navigation — sits flush against the logo gap, no negative pulls */
    #header #navigation,
    #header.cloned #navigation {
        float: none !important;
        display: inline-flex !important;
        align-items: center !important;
        margin: 0 !important;
        padding: 0 !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
    }
    #header #navigation > ul,
    #header.cloned #navigation > ul {
        margin: 0 !important;
        padding: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        float: none !important;
    }
    #header #navigation > ul > li,
    #header.cloned #navigation > ul > li {
        float: none !important;
        display: inline-flex !important;
        align-items: center !important;
    }
    #header #navigation > ul > li > a,
    #header.cloned #navigation > ul > li > a {
        padding: 10px 14px !important;
        line-height: 1.2 !important;
    }

    /* Hide the legacy 80px-tall bottom slack and any clearfix gaps */
    #header .clearfix { display: none !important; }

    /* Mobile hamburger — keep on the right, vertically centred */
    #header .mmenu-trigger {
        margin-left: auto !important;
        display: none;
        align-items: center;
    }
    @media (max-width: 991px) {
        #header .mmenu-trigger { display: inline-flex !important; }
        #header #navigation { display: none !important; }
        #header.head-tr,
        #header.cloned {
            height: 90px !important;
            min-height: 90px !important;
        }
        #header #logo img,
        #header.cloned #logo img,
        #header #logo.logo-white img,
        #header.cloned #logo.logo-white img {
            max-height: 72px !important;
            max-width: 170px !important;
        }
        #header #logo,
        #header.cloned #logo { margin-right: 16px !important; }
    }

    /* Tighter gap on medium desktops instead of the negative-margin trick */
    @media (max-width: 1400px) {
        #header #logo,
        #header.cloned #logo { margin-right: 28px !important; }
        #header #navigation > ul > li > a,
        #header.cloned #navigation > ul > li > a { padding: 10px 12px !important; }
    }
    @media (max-width: 1200px) {
        #header #logo,
        #header.cloned #logo { margin-right: 20px !important; }
        #header #navigation > ul > li > a,
        #header.cloned #navigation > ul > li > a { padding: 10px 10px !important; }
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

                                                include_once("connect.php");

                                                $hi      = 0;
                                                $user_id = 0;
                                                $email   = '';

                                                if (isset($_SESSION['email'])) {
                                                    $userEmail = mysqli_real_escape_string($con, $_SESSION['email']);

                                                    $cmd    = "select * from user where email='$userEmail'";
                                                    $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
                                                    $row    = mysqli_fetch_array($result);

                                                    if ($row) {
                                                        $user_id = $row['id'];
                                                        $email   = $row['email'];

                                                        $cmd1    = "select * from cart where user_id='$user_id'";
                                                        $result1 = mysqli_query($con, $cmd1) or die(mysqli_error($con));
                                                        $hi      = mysqli_num_rows($result1);
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