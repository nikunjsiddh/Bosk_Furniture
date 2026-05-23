<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");
if (isset($_SESSION['email'])) {
    $userEmail = $_SESSION['email'];
    
$page_title       = 'Secure Checkout | Bosk Furniture';
$page_description = 'Complete your secure furniture order at Bosk Furniture India with safe payment options and free shipping on eligible items.';
$page_keywords    = 'checkout, secure payment, furniture order, bosk furniture';
$page_canonical   = '/checkout';
$page_robots      = 'noindex, follow';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php
    include_once"design/header.php";
    ?>
    <style>
 body{
     background-color:white;
 }
/* ---------24.Checkout-Page-Start ---------*/
.coupon-area{}
.coupon-accordion{}
.coupon-accordion h3 {
	background-color: #f7f6f7;
	border-top: 3px solid #1e85be;
	color: #515151;
	font-size: 14px;
	font-weight: 500;
	list-style: outside none none !important;
	margin: 0 0 2em !important;
	padding: 1em 2em 1em 3.5em !important;
	position: relative;
	width: auto;
}
.coupon-accordion h3::before {
	color: #1e85be;
	content: "";
	display: inline-block;
    font-family: 'Open Sans', sans-serif;
	left: 1.5em;
	position: absolute;
	top: 1em;
}
.coupon-accordion span {
    cursor: pointer;color: #555;
}
.coupon-accordion span:hover, p.lost-password a:hover {
    color: #c2a773;
}
.coupon-content {
	border: 1px solid #e5e5e5;
	display: none;
	margin-bottom: 20px;
	padding: 20px;
}
.coupon-info{}
.coupon-info p.coupon-text{
	margin-bottom:15px
}
.coupon-info p{
	margin-bottom:0;
}
.coupon-info p.form-row-first{}
.coupon-info p.form-row-first label,.coupon-info p.form-row-last label{
	display: block;
}
.coupon-info p.form-row-first label span.required, .coupon-info p.form-row-last label span.required {
	color: #C2A773;
	font-weight: 700;
}
.coupon-info p.form-row-first input,.coupon-info p.form-row-last input{
	border: 1px solid #e5e5e5;
	height: 36px;
	margin: 0 0 14px;
	max-width: 100%;
	padding: 0 0 0 10px;
	width: 370px;
}
.coupon-info p.form-row-last{}
.coupon-info p.form-row input[type="submit"]:hover, p.checkout-coupon input[type="submit"]:hover {
    background: #C2A773;
}
.coupon-info p.form-row input[type="checkbox"] {
	position: relative;
	top: 2px;
}
.form-row > label {
    margin-top: 7px;
}
p.lost-password{
	margin-top: 15px;
}
p.lost-password a{
	color: #666;
}
p.checkout-coupon{}
p.checkout-coupon input[type=text]{
	height: 36px;
	padding-left: 10px;
	width: 170px;
}
p.checkout-coupon input[type=submit]{
	background: #333 none repeat scroll 0 0;
	border: medium none;
	border-radius: 0;
	color: #fff;
	height: 36px;
	margin-left: 6px;
	padding: 5px 10px;transition: all 0.3s ease 0s;
}
.coupon-checkout-content {
	margin-bottom: 30px;
	display:none;
}
.checkout-area{}
.checkbox-form{}
.checkbox-form h3 {
	border-bottom: 1px solid #e5e5e5;
	font-size: 30px;
	margin: 0 0 20px;
	padding-bottom: 10px;
	text-transform: uppercase;
	width: 100%;
}
.country-select{
	margin-bottom: 30px;
	position: relative;
}
.country-select label,.checkout-form-list label{
	color: #333;
	font-family: 'Open Sans', sans-serif;
	margin: 0 0 5px;
	display:block;
}
.country-select label span.required, .checkout-form-list label span.required {
	color: #C2A773;
}
.country-select select{
	-moz-appearance: none;
	-webkit-appearance: none;
	border: 1px solid #ddd;
	height: 32px;
	padding-left: 10px;
	width: 100%;
}
.country-select::before {
	content: "";
	display: inline-block;
	font-family: 'Open Sans', sans-serif;
	font-size: 20px;
	position: absolute;
	right: 12px;
	top: 31px;
}
.checkout-form-list{margin-bottom: 30px;}
.checkout-form-list label{color: #333;}
.checkout-form-list label span.required{}
.checkout-form-list input[type=text],.checkout-form-list input[type=password],.checkout-form-list input[type=email]{   
	border: 1px solid #e5e5e5;
	border-radius: 0;
	height: 42px;
	width: 100%;
	padding: 0 0 0 10px;
	background: #fff none repeat scroll 0 0;
}
.checkout-form-list{}
.checkout-form-list input[type=checkbox]{
	display: inline-block;
	margin-right: 10px;
	position: relative;
	top: 2px;
}
.create-acc label {
	color: #333;
	display: inline-block;
}
.checkout-form-list input[type=password]{}
.create-account{
	display:none
}
.ship-different-title{}
.ship-different-title h3 label{
	display: inline-block;
	margin-right: 20px;
	font-size: 25px;
}
.ship-different-title input{}
.order-notes{}
.order-notes textarea{
	height: 90px;
	padding: 15px;width:100%
}
#ship-box-info{
	display:none
}
.your-order{
	background: #f2f2f2 none repeat scroll 0 0;
	padding: 30px 40px 45px;
}
.your-order h3{
	border-bottom: 1px solid #d8d8d8;
	font-size: 30px;
	margin: 0 0 20px;
	padding-bottom: 10px;
	text-transform: uppercase;
	width: 100%;
}
.your-order-table table{
	background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
	border: medium none;
	width: 100%;
}
.your-order-table table th, .your-order-table table td {
	border-bottom: 1px solid #d8d8d8;
	border-right: medium none;
	font-size: 14px;
	padding: 15px 0;
	text-align: center;
	width:500px;
}
.your-order-table table th{
	border-top: medium none;
	font-family: 'Open Sans', sans-serif;
	font-weight: normal;
	text-align: center;
	text-transform: uppercase;
	vertical-align: middle;
	white-space: nowrap;
	width: 250px;
}
.your-order-table table .shipping ul li input{
	position: relative;
	top: 2px;
}
.your-order-table table .shipping  th{
	vertical-align: top;
}
.your-order-table table .order-total th{
	border-bottom: medium none;
	font-size: 18px;
}
.your-order-table table .order-total td{
	border-bottom: medium none;
}
.your-order-table table tr.cart_item:hover{
	background:#F9F9F9
}
.your-order-table table tr.order-total td span {
	color: #c2a773;
	font-size: 20px;
}
.your-order-table table{}
.payment-method {
    margin-top: 40px;
}
.payment-method .panel {
    box-shadow: none;
}
.payment-method .panel-title > a {
  color: #6f6f6f;
}
.payment-method .card {
    border: medium none;
}
.payment-method .card .card-header {
	background-color: #F2F2F2;
}
.card-title {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 16px;
    color: inherit;
}
.payment-method .card-body.payment-content {
    background: #f2f2f2 none repeat scroll 0 0;
}
.payment-method .panel-img img {
	margin-left: 10px;
	width: 50%;
} 
.order-button-payment{}
.order-button-payment input {
  background: #C2A773;
  border: medium none;
  color: #ffffff;
  font-size: 17px;
  font-weight: 600;
  height: 50px;
  margin: 20px 0 0;
  padding: 0;
  text-transform: uppercase;
  transition: all 0.3s ease 0s;
  width: 100%;
}
.order-button-payment input:hover{
	background:#000
}
.order-button-payment{}
.order-button-payment button {
  background: #C2A773;
  border: medium none;
  color: #ffffff;
  font-size: 17px;
  font-weight: 600;
  height: 50px;
  margin: 20px 0 0;
  padding: 0;
  text-transform: uppercase;
  transition: all 0.3s ease 0s;
  width: 100%;
}
.order-button-payment button:hover{
	background:#000
}
.menu-search-box input::-webkit-input-placeholder {
    /* Chrome */
    color: #fff;
    opacity: 1;
}
.menu-search-box input::-moz-placeholder {
    /* Firefox 19+ */
    color: #fff;
    opacity: 1;
}
.search-box input::-webkit-input-placeholder,.sideber-form input::-webkit-input-placeholder,.checkout-form-list input::-webkit-input-placeholder,.checkout-form-list textarea::-webkit-input-placeholder,.checkout-coupon input::-webkit-input-placeholder,.menu-search-box.scnd-fix input::-webkit-input-placeholder,.search-box-3-hover input::-webkit-input-placeholder{
    /* Chrome */
    color: #555;
    opacity: 1;
}
.search-box input::-moz-placeholder,.sideber-form input::-moz-placeholder,.checkout-form-list input::-moz-placeholder,.checkout-form-list textarea::-moz-placeholder,.checkout-coupon input::-moz-placeholder,.menu-search-box.scnd-fix input::-moz-placeholder,.search-box-3-hover input::-moz-placeholder {
    /* Firefox 19+ */
    color: #555;
    opacity: 1;
}
.coupon input::-webkit-input-placeholder,.form-group.contuct_f input::-webkit-input-placeholder {
    /* Chrome */
    color: #777;
    opacity: 1;
}
.coupon input::-moz-placeholder,.form-group.contuct_f input::-moz-placeholder {
    /* Firefox 19+ */
    color: #777;
    opacity: 1;
}
.btn:focus, .btn:active:focus, .btn.active:focus, .btn.focus, .btn.focus:active, .btn.active.focus {
  outline: medium none;
}
.btn:active, .btn.active {
  box-shadow: none;
}
.btn-default:focus, .btn-default.focus {
  background-color: none;
}
table td.product-name{width: 270px;}
button.disabled {
  /* your styling here */
  opacity: 0.5; /* example: reduce opacity to indicate disabled state */
  cursor: not-allowed; /* example: change cursor to indicate disabled state */
}
    </style>
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
                    <h1 class="text-center">CHECKOUT</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>CHECKOUT</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS --><br/><br/><br/>
        
      	
        <?php
            include_once"connect.php";

            // ---- Safe defaults so the page never sees undefined variables ----
            $user_id      = 0;
            $id           = 0;
            $email        = '';
            $firstname    = '';
            $lastname     = '';
            $dob          = '';
            $password     = '';
            $addressline1 = 'NA';
            $addressline2 = '';
            $pincode      = '';
            $country      = '';
            $state        = '';
            $city         = '';
            $phone        = '';
            $img          = '';

            // Initialize totals used by the order summary loop below.
            $totalPrice   = 0;
            $subTotal     = 0;
            $tax          = 0;
            $shipping     = 0;
            $total1       = 0;
            $total_price  = 0;
            $quantity     = 0;
            $new_price    = 0;

            // Safely look up the logged-in user.
            $safeEmail = mysqli_real_escape_string($con, $userEmail);
            $cmd1   = "select * from user where email='$safeEmail' limit 1";
            $result1 = mysqli_query($con, $cmd1) or die(mysqli_error($con));
            if ($row1 = mysqli_fetch_array($result1)) {
                $user_id      = $row1['id'];
                $id           = $row1['id'];
                $email        = $row1['email'];
                $firstname    = $row1['firstname'];
                $lastname     = $row1['lastname'];
                $dob          = $row1['dob'];
                $password     = $row1['password'];
                $addressline1 = !empty($row1['addressline1']) ? $row1['addressline1'] : 'NA';
                $addressline2 = $row1['addressline2'];
                $pincode      = $row1['pincode'];
                $country      = $row1['country'];
                $state        = $row1['state'];
                $city         = $row1['city'];
                $phone        = $row1['phone'];
                $img          = $row1['img'];
            }
                ?>
       <!-- checkout-area start -->
		<div class="checkout-area pb-50">
			<div class="container">
				<form class="row" id="orderForm" onsubmit="return order(this);"  method="post" enctype="multipart/form-data">
				    <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
					<div class="col-lg-6">
						<div class="checkbox-form">						
							<h3 style="font-weight:bolder;">Billing Details</h3>
							<?php
							if($addressline1 == 'NA')
							{
							?>
							
							<p style="color:red;">"No Address Available,Please Add Address."</p>
							<button style="background-color:#532A1A;" type="button" class="btn btn-primary btn-lg" value=""><a style="color:white;" href="profile.php">Add Address</a></button>
							<?php
							}
							else{
							 ?>
							
							<h5 style="color:black;"><b>Shipping Address:</b></h5>
							<p><?php echo $firstname.' '.$lastname;?>,<br/><?php echo $addressline1;?>,<br/><?php echo $addressline2;?>,<br/><?php echo $city;?>,<?php echo $pincode;?>,<br/><?php echo $state;?>,<br/><?php echo $country;?>.<br/></p>
							<button style="background-color:#532A1A;" type="button" class="btn btn-primary btn-lg" value=""><i class="fa fa-pencil"></i>&nbsp;&nbsp;<a style="color:white;" href="profile.php">Change / Edit Address</a></button>
							<?php
							}
							?>
							
																			
						</div>
					</div>	
					<div class="col-lg-6">
						<div class="your-order">
							<h3 style="font-weight:bolder;">Your order</h3>
							<div class="your-order-table table-responsive">
								<table>
									<thead>
										<tr>
										    <th style="font-weight:bolder;display:none;" width=500px>Image</th>
											<th style="font-weight:bolder;display:none;" class="product-name">Product</th>
											<th style="font-weight:bolder;display:none;" class="product-total">Total</th>
										</tr>							
									</thead>
									<tbody>
									    <?php
									    $cmd2="select * from cart where user_id='$user_id'";
                                        $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                        while($row2=mysqli_fetch_array($result2))
                                        {     
                                            $cart_id = $row2['id'];
                                          
                                            $product_id=$row2['product_id'];
                                            $quantity=$row2['quantity'];
                                            
                                        $cmd3="select * from products where id='$product_id'";
                                        $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
                                        while($row3=mysqli_fetch_array($result3))
                                        {     
                                            $pname = $row3['pname'];
                                            $img1 = $row3['img1'];
                                            $description = $row3['description'];
                                            $sku = $row3['sku'];
                                            $old_price = $row3['old_price'];
                                            $new_price = $row3['new_price'];
                                             $total_price = $quantity * $new_price;
                                             $totalPrice += $total_price;
                                           
                                    
									    ?>
										<tr class="cart_item">
										    <td>
												<img class="img1" src="Admin/product_image/<?php echo $img1;?>">
											</td>
											<td class="product-name">
												<?php echo $pname;?> <strong class="product-quantity"> x <?php echo $quantity;?></strong>
											</td>
											<td class="product-total">
												<span class="amount">₹<?php echo $new_price;?></span>
											</td>
										</tr>
									
									</tbody>
									 <?php
                                        $total_price = $quantity * $new_price;
                                        $subTotal+=$total_price;
                                        $tax=$subTotal*0.18;
                                        $shipping=$subTotal*0.02;
                                        $total1=$subTotal+$tax+$shipping;
                                       
                                        }
                                        }
                                        ?>
									<tfoot>
									   
										<tr class="cart-subtotal">
											<th colspan="2" style="font-weight:bolder;">Cart Subtotal</th>
											
											<td><span class="amount">₹<?php echo $subTotal; ?></span></td>
										</tr>
											<tr class="shipping">
											<th colspan="2" style="font-weight:bolder;">GST & Tax</th>
											
											<td><span class="amount">₹<?php echo $tax;?></span></td>
										</tr>
										<tr class="shipping">
											<th colspan="2" style="font-weight:bolder;">Shipping</th>
											
											<td><span class="amount">₹<?php echo $shipping;?></span></td>
										</tr>
										<tr class="order-total">
											<th colspan="2" style="font-weight:bolder;">Order Total</th>
											
											<td style="color:black;"><strong><span class="amount">₹<?php echo $total1;?></span></strong>
											</td>
										</tr>								
									</tfoot>
								</table>
							</div>
							<div class="payment-method">
								<!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">-->
								<!--	<div class="card">-->
								<!--		<div class="card-header" role="tab" id="headingOne">-->
								<!--			<h4 class="card-title">-->
								<!--				<a style="color:black !important;font-weight:bolder;" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">-->
								<!--				Direct Bank Transfer-->
								<!--				</a>-->
								<!--			</h4>-->
								<!--		</div>-->
								<!--		<div id="collapseOne" class="collapse show" data-parent="#accordion" aria-labelledby="headingOne">-->
								<!--			<div class="card-body payment-content">-->
								<!--				Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won't be shipped until the funds have cleared in our account.-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--	<div class="card">-->
								<!--		<div class="card-header" role="tab" id="headingTwo">-->
								<!--			<h4 class="card-title">-->
								<!--				<a style="color:black !important;font-weight:bolder;" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">-->
								<!--				Cheque Payment-->
								<!--				</a>-->
								<!--			</h4>-->
								<!--		</div>-->
								<!--		<div id="collapseTwo" class="collapse" data-parent="#accordion" aria-labelledby="headingTwo">-->
								<!--			<div class="card-body payment-content">-->
								<!--				Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--	<div class="card">-->
								<!--		<div class="card-header" role="tab" id="headingThree">-->
								<!--			<h4 class="card-title panel-img">-->
								<!--			<a style="color:black !important;font-weight:bolder;" role="button" data-bs-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">-->
								<!--			PayPal <img src="images/payment_c.png" alt="" />-->
								<!--			</a>-->
								<!--			</h4>-->
								<!--		</div>-->
								<!--		<div id="collapseThree" class="collapse" data-parent="#accordion" aria-labelledby="headingThree">-->
								<!--			<div class="card-body payment-content">-->
								<!--				Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--</div>-->
    								<?php
    							if($addressline1 == 'NA')
    							{
    							?>
    							<p style="color:red;">*You Can Not Continue Without Adding The Address,<br/>Please Add Address*</p>
    							<div class="order-button-payment">
    								<button style="background-color:#532A1A;" type="button" class="btn btn-primary btn-lg" value=""><a style="color:white;" href="profile.php">Add Address</a></button>
    								</div>
								<div class="order-button-payment">
									<button type="submit" value="" class="disabled" disabled>Place order</button>
								</div>
								<?php
    							}
    							else{
    							    ?>
    							    <div class="order-button-payment">
									<button type="submit" name="submit" id="submit" type="submit" value="Place order">Place order</button>
								</div>
    							<?php    
    							}
    							?>
							</div>
						</div>
					</div>
				</form>
				<div id="return"></div>
			</div>
		</div><br/><br/><br/>
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
        <script src="js/jquery.easing.min.js"></script>
        <script src="js/smooth-scroll.min.js"></script>
        <script src="js/isotope.pkgd.min.js"></script>
        <script src="js/lightcase.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/inner-script.js"></script>
        <script src="js/add/addorderdetails.js"></script>
        <script>
            $(window).on('scroll load', function() {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });

        </script>

    </div>
    <!-- Wrapper / End -->
</body>

</html>
<?php
}
?>