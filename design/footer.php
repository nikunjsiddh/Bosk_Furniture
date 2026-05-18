<!-- START FOOTER -->
<footer style="background-color:white !important;" class="first-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="netabout">
                        <a href="index.php" class="logo">
                            <img src="images/logo-white.png" alt="netcom">
                        </a>
                        <p><b>Registered Office Location</b></p>
                    </div>
                    <div class="contactus">
                        <ul>
                            <li>
                                <div class="info">
                                    <i style="margin-top:0.2rem;" class="fa fa-map-marker" aria-hidden="true"></i>
                                    <p class="in-p">5,Aryamaan Complex,<br />Near Meghani Circle,<br />Sir Patanni
                                        Road,<br />Bhavnagar-364001,<br />Gujarat,India.</p>
                                </div>
                            </li>
                            <li>
                                <div class="info">
                                    <i style="margin-top:0.2rem;" class="fa fa-phone" aria-hidden="true"></i>
                                    <p class="in-p">+91 8866647777</p>
                                </div>
                            </li>
                            <li>
                                <div class="info">
                                    <i style="margin-top:0.2rem;" class="fa fa-envelope" aria-hidden="true"></i>
                                    <p class="in-p ti">boskinfracon@gmail.com</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="navigation">
                        <h3>Navigation</h3>
                        <div class="nav-footer">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="all_products.php">Shop</a></li>
                                <li><a href="about-us.php">About Us</a></li>
                                <li><a href="blog-full-list.php">Blog</a></li>
                                <li><a href="design-order-process.php">How it Works</a></li>
                                <li><a href="contact.php">Contact Us</a></li>
                                <li><a href="profile.php">My Account</a></li>
                            </ul>
                            <ul class="nav-right">

                                <li><a href="cart.php">Cart</a></li>
                                <li><a href="testimonial.php">Testimonial</a></li>
                                <li><a href="warranty.php">warranty</a></li>
                                <li><a href="warranty_policy.php">warranty policy</a></li>
                                <li><a href="care_and_maintenance_policy.php">Care & Maintainence Policy</a></li>
                                <li><a href="hardware_warranty.php">Hardware Policy</a></li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget">
                        <h3>Categories</h3>
                        <div class="twitter-widget contuct">
                            <div class="twitter-area">
                                <?php
                                         include_once"connect.php";
                                         
                                          $cmd="select * from category limit 8";
                                          $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                          while($row=mysqli_fetch_array($result))
                                          {     
                                              $id = $row['id'];
                                              $name=$row['name'];
                                              $img=$row['img'];
                                          ?>
                                <div class="single-item">
                                    <div class="icon-holder">
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </div>
                                    <div class="text">
                                        <b>
                                            <h5><a href="shop.php?astringdata2=<?php echo $row['name'];?>">
                                                    <?php echo $name;?>
                                                </a> </h5>
                                        </b>
                                        <!--<h4>about 5 days ago</h4>-->
                                    </div>
                                </div>
                                <?php
                                          }
                                        ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="newsletters">
                        <h3>Newsletters</h3>
                        <p>Sign Up for Our Newsletter to get Latest Updates and Offers. Subscribe to receive news in
                            your inbox.</p>
                    </div>
                    <form onsubmit="return newsletter(this);" id="newsletter" class="bloq-email mailchimp form-inline"
                        method="post">
                        <label for="subscribeEmail" class="error"></label>
                        <div class="email">
                            <input style="background-color:#000 !important;color:white !important;" type="email"
                                name="newsemail" id="newsemail" placeholder="Enter Your Email">
                            <input type="submit" value="Subscribe">
                            <p class="subscription-success"></p>
                        </div>

                    </form><br /><br /><br /><br />
                    <div id="return1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="second-footer">
        <div class="container">
            <p style="color:black;">2020 © Copyright - All Rights Reserved.</p>
            <p style="color:black">Powered By <a style="color:black" href="https://softwingz.com/">SOFTWINGZ
                    INFOTECH</a></p>
        </div>
    </div>

</footer>
<script src="js/add/newsletter.js"></script>