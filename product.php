<?php
// Guarded session_start so it never collides with another include's session_start.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");

// Safe defaults so the rest of the page never sees undefined variables.
$pname      = '';
$decoded_id = 0;

if (isset($_GET['astringdata'])) {

    $raw = $_GET['astringdata'];

    // The site links to this page in TWO styles:
    //   1) plain numeric id   -> product.php?astringdata=5     (related-products block, one shop.php button)
    //   2) base64-encoded id  -> product.php?astringdata=NQ==  (most pages: all_products / shop / order_details)
    // Accept both without breaking existing links.
    if (ctype_digit($raw)) {
        $decoded_id = (int) $raw;
    } else {
        $maybe = base64_decode($raw, true);
        $decoded_id = ($maybe !== false && ctype_digit($maybe)) ? (int) $maybe : 0;
    }

    if ($decoded_id > 0) {
        $cmd3    = "select * from products where id='" . $decoded_id . "'";
        $result3 = mysqli_query($con, $cmd3) or die(mysqli_error($con));
        while ($row = mysqli_fetch_array($result3)) {
            $pname           = $row['pname'];
            $seo_pcategory   = isset($row['pcategory'])   ? $row['pcategory']   : '';
            $seo_description = isset($row['description']) ? strip_tags($row['description']) : '';
            $seo_new_price   = isset($row['new_price'])   ? $row['new_price']   : '';
            $seo_img1        = isset($row['img1'])        ? $row['img1']        : '';
            $seo_sku         = isset($row['sku'])         ? $row['sku']         : '';
            $seo_stock       = isset($row['stock'])       ? $row['stock']       : 0;
        }
    }
}

// ---- Dynamic SEO meta from product data ----
$_seo_pname = isset($pname) && $pname !== '' ? $pname : 'Product';
$_seo_short = isset($seo_description) ? substr(trim(preg_replace('/\s+/', ' ', $seo_description)), 0, 155) : '';
if ($_seo_short === '') {
    $_seo_short = 'Buy ' . $_seo_pname . ' online at Bosk Furniture - premium quality furniture with free shipping across India.';
}
$page_title       = $_seo_pname . ' | Buy Online at Bosk Furniture India';
$page_description = $_seo_short;
$page_keywords    = $_seo_pname . ', buy ' . $_seo_pname . ' online, ' . (isset($seo_pcategory) ? $seo_pcategory . ', ' : '') . 'furniture india, bosk furniture';
$page_canonical   = '/product?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '');
$og_type          = 'product';
$page_breadcrumbs = [
    ['name' => 'Home',       'url' => '/'],
    ['name' => 'Shop',       'url' => '/all_products'],
    ['name' => $_seo_pname,  'url' => '/product?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '')]
];
if (!empty($seo_img1)) {
    $og_image = 'https://www.boskfurniture.com/Admin/product_image/' . $seo_img1;
}

// Build Product JSON-LD schema
$_seo_avail = (isset($seo_stock) && $seo_stock > 0) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
$page_schema = '
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": ' . json_encode($_seo_pname) . ',
  "image": ' . json_encode(!empty($seo_img1) ? 'https://www.boskfurniture.com/Admin/product_image/' . $seo_img1 : 'https://www.boskfurniture.com/images/og-default.jpg') . ',
  "description": ' . json_encode($_seo_short) . ',
  "sku": ' . json_encode(isset($seo_sku) ? $seo_sku : '') . ',
  "brand": {"@type":"Brand","name":"Bosk Furniture"},
  "category": ' . json_encode(isset($seo_pcategory) ? $seo_pcategory : 'Furniture') . ',
  "offers": {
    "@type": "Offer",
    "url": "https://www.boskfurniture.com/product.php?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '') . '",
    "priceCurrency": "INR",
    "price": ' . json_encode(isset($seo_new_price) ? (string)$seo_new_price : '0') . ',
    "availability": "' . $_seo_avail . '",
    "itemCondition": "https://schema.org/NewCondition",
    "seller": {"@type":"Organization","name":"Bosk Furniture"}
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"Home","item":"https://www.boskfurniture.com/"},
    {"@type":"ListItem","position":2,"name":"Shop","item":"https://www.boskfurniture.com/all_products.php"},
    {"@type":"ListItem","position":3,"name":' . json_encode($_seo_pname) . ',"item":"https://www.boskfurniture.com/product.php?astringdata=' . (isset($_GET['astringdata']) ? urlencode($_GET['astringdata']) : '') . '"}
  ]
}
</script>';

// Re-open the original guard so the HTML only renders when astringdata was supplied
if (isset($_GET['astringdata'])) {
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
    .button2 {
  background-color: #532A1A;
  border: none;
  color: white;
  padding: 6px 18px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.disabled2 {
  opacity: 0.6;
  cursor: not-allowed;
}
        ul.sinple-tab-menu li a {
	border: 1px solid #dedede;
	float: left;
	margin-left: 17px;
	margin-top: 10px;
	width: 82px !important;
}
ul.sinple-tab-menu li:first-child a{
    margin-left: 0;
}
ul.sinple-tab-menu li a.active{
    border: 1px solid #c6ac7c;
}
.product-simple-content .sinple-c-title h3 {
	font-size: 30px;
	font-weight: 900;
	margin-bottom: 20px;
	font-family:montserrat;
}
.checkbox span {
    color: #73c437;
    font-weight: 400;
}
.checkbox span i {
    color: #73c437;
    float: left;
    margin-right: 10px;
    margin-top: 5px;
}
.product-simple-content .product-price-star.star-2 {
	margin-bottom: 27px;
	margin-top: 18px;
}
.product-simple-content .product-price-star.star-2 span {
	font-weight: 300;
	margin-left: 10px;
    color: #333;
}
.product-simple-content > h4 {
	font-size: 30px;
	font-weight: 800;
	margin-bottom: 29px;
}
.product-simple-content .quick-add-to-cart {
    overflow: hidden;
}
.product-simple-content .quick-add-to-cart label {
	float: left;
	margin-right: 10px;
	margin-top: 8px;
}
.quick-add-to-cart .single_add_to_cart_button.hyper-page {
	background: #333333 none repeat scroll 0 0;
	border: medium none;
	color: #ffffff;
	display: inline-block;
	font-size: 13px;
	font-weight: 500;
	margin-left: 14px;
	padding: 10px 18px;
	text-transform: capitalize;
}
.quick-add-to-cart .single_add_to_cart_button.hyper-page:hover{
	background:#c2a773;
} 
.product-simple-content .numbers-row > input {
	border: 1px solid #dddddd;
	float: left;
	height: 40px;
	padding: 0 5px;
	text-align: center;
	width: 84px;
}
.product-simple-content .quick-add-to-cart .single_add_to_cart_button.hyper-page span {
	float: left;
	font-size: 18px;
	font-weight: 900;
	margin-right: 10px;
}
.product-simple-content .action-heiper {
	border-bottom: 1px solid #dddddd;
	margin-bottom: 30px;
	margin-top: 30px;
	padding-bottom: 20px;
}
.product-simple-content .action-heiper a {
	background: #aaa none repeat scroll 0 0;
	display: inline-block;
	font-size: 18px;
	height: 40px;
	line-height: 40px;
	text-align: center;
	width: 40px;
	color:#fff;
	margin-left:6px;
}
.product-simple-content .action-heiper a:first-child {
    margin-left: 0;
}
.product-simple-content .action-heiper a:hover{
	background:#C2A773;
	color:#fff;
}
.product-simple-content > p {
	font-size: 14px;
	font-weight: 300;
	line-height: 28px;
	font-family:montserrat;
}
.product-info-tab-menu {
	border-bottom: 2px solid #ededed;
	margin-bottom: 20px;
	padding-bottom: 12px;
}
ul.product-info-tab-menu li {
    display: inline-block;
    position: relative;
}
ul.product-info-tab-menu li a {
    color: #666;
    font-size: 20px;
    font-weight: 600;
    margin-right: 16px;
    text-transform: uppercase;
}
ul.product-info-tab-menu li a:hover, ul.product-info-tab-menu li a.active {
    color: #333333;
}
ul.product-info-tab-menu li a::before {
    background: #c2a773 none repeat scroll 0 0;
    bottom: -14px;
    content: "";
    height: 2px;
    position: absolute;
    width: 0;
    transition:all.5s;	
}
ul.product-info-tab-menu li:hover::before {
	transition: all 0.3s ease 0s;
	width: 86%;
}
ul.product-info-tab-menu li a.active::before{
	transition: all 0.3s ease 0s;
	width: 86%;
}
ul.product-info-tab-menu li a.active:hover::before{
	transition: all 0.5s ease 0s;
	width: 86%;
}
.product-info-tab-content > p {
	font-weight: 300;
	line-height: 24px;
	margin-bottom: 5px;
	font-family:montserrat;
}
.product-info-tab-content li {
  color: #333;
  font-weight: 300;
  line-height: 26px;
  position: relative;
  font-family:montserrat;
}
.product-info-tab-content li::before {
	color: #333333;
	content: "";

	font-size: 6px;
	padding: 6px;
}
.customer-review-top {
	border-bottom: 1px solid #dddddd;
	overflow: hidden;
	padding-bottom: 24px;
}
.customer-review-top > h3 {
	font-size: 45px;
	font-weight: 300;
	margin-bottom: 20px;
}
.customer-review-top > h4 {
	display: block;
	font-size: 30px;
	font-weight: 300;
	margin-bottom: 20px;
}
.cus-review-left {
	float: left;
	width: 30%;
}
.cus-review-left > p {
    margin-bottom: 18px;
}
.single-customer-rating span {
	color: #666666;
	display: inline-block;
	font-weight: 700;
	margin-bottom: 11px;
	margin-right: 19px;
	text-transform: capitalize;
}
.customer-review-bottom {
    margin-top: 50px;
}
.single-customer-rating i {
  color: #C2A773;
}
.customer-review-bottom h2{
    font-size: 32px;
	font-weight:500;
}
.customer-review-bottom.fix > p {
    margin-top: 12px;
}
.customer-review-bottom.fix > p span {
	color: #fb5f06;
	font-size: 19px;
	margin-top:20px;
}
.customer-review-form {
	margin-top: 40px;
	overflow: hidden;
	width: 60%;
}
.upsell-product {
	margin-bottom: 30px;
}
.upsell-product-title {
    margin-bottom: 30px;
    text-align: center;
}
.hyper-title {
	margin-bottom: 35px;
	position: relative;
}
.hyper-title::before {
	background: #dedede none repeat scroll 0 0;
	bottom: -10px;
	content: "";
	height: 1px;
	position: absolute;
	width: 100%;
}
.hyper-title h4::before {
	background: #c2a773 none repeat scroll 0 0;
	bottom: -10px;
	content: "";
	height: 2px;
	position: absolute;
	width: 21%;
}
.hyper-title::after {
	content: "/";
	position: absolute;
	right: 28px;
	top: 10px;
}
.feature-preduct-area.hyperion .owl-carousel .owl-controls .owl-nav div {
    display: inline-block;
    font-size: 18px;
    font-weight: 300;
    height: 30px;
    line-height: 24px;
    position: absolute;
    right: 0;
    text-align: center;
    top: -59px;
    width: 30px;
}
.feature-preduct-area.hyperion .owl-carousel .owl-controls .owl-nav div.owl-next {
    left: auto;
    right: 33px;
}
ul.sinple-tab-menu li a {
	border: 1px solid #dedede;
	float: left;
	margin-left: 17px;
	margin-top: 10px;
	width: 82px !important;
}
ul.sinple-tab-menu li:first-child a{
    margin-left: 0;
}
ul.sinple-tab-menu li a.active{
    border: 1px solid #c6ac7c;
}
}
img{
    width: 100%;
    display: block;
}
.img-display{
    overflow: hidden;
}
.img-showcase{
    display: flex;
    width: 100%;
    transition: all 0.5s ease;
}
.img-showcase img{
    min-width: 100%;
}
.img-select{
    display: flex;
}
.img-item{
    margin: 0.3rem;
}
.img-item:nth-child(1),
.img-item:nth-child(2),
.img-item:nth-child(3){
    margin-right: 0;
}
.img-item:hover{
    opacity: 0.8;
}


@media screen and (min-width: 992px){
    
    .product-imgs{
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
  
}
button:disabled,
button[disabled]{
  border: 1px solid #999999;
  background-color: #cccccc;
  color: #666666;
}
    </style>
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
                    <h1 class="text-center"><?php echo $pname;?></h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>PRODUCT</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->
        <?php
        // Safe defaults so the page still renders if the product id is missing/invalid.
        $product_id  = 0;
        $pname       = '';
        $pcategory   = '';
        $img1        = '';
        $img2        = '';
        $img3        = '';
        $img4        = '';
        $img5        = '';
        $description = '';
        $stock       = 0;
        $old_price   = '';
        $new_price   = '';
        $tags        = '';
        $sku         = '';

        if (!empty($decoded_id) && $decoded_id > 0) {
            $cmd    = "select * from products where id='" . (int)$decoded_id . "'";
            $result = mysqli_query($con, $cmd) or die(mysqli_error($con));
            $row    = mysqli_fetch_array($result);

            if ($row) {
                $product_id  = $row['id'];
                $pname       = $row['pname'];
                $pcategory   = $row['pcategory'];
                $img1        = $row['img1'];
                $img2        = $row['img2'];
                $img3        = $row['img3'];
                $img4        = $row['img4'];
                $img5        = $row['img5'];
                $description = $row['description'];
                $stock       = $row['stock'];
                $old_price   = $row['old_price'];
                $new_price   = $row['new_price'];
                $tags        = $row['tags'];
                $sku         = $row['sku'];
            }
        }
        ?>
        <!-- START SECTION BLOG -->
        <section class="shop blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
						<!-- product-simple-area-start -->
						<div class="product-simple-area ptb-80">
							<div class="row">
								<div class="col-md-7">
								
									
    <div class = "product-imgs">
      <div class = "img-display">
        <div class = "img-showcase">
          <img height="300px" width="300px" src = "Admin/product_image/<?php echo $img1;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          <img src = "Admin/product_image/<?php echo $img2;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          <img src = "Admin/product_image/<?php echo $img3;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          <img src = "Admin/product_image/<?php echo $img4;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          <!--<img src = "Admin/product_image/<?php echo $img5;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">-->
        </div>
      </div>
      <div class = "img-select">
        <div class = "img-item">
          <a href = "#" data-id = "1">
            <img height="300px" width="300px" src = "Admin/product_image/<?php echo $img1;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "2">
            <img src = "Admin/product_image/<?php echo $img2;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "3">
            <img src = "Admin/product_image/<?php echo $img3;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          </a>
        </div>
        <div class = "img-item">
          <a href = "#" data-id = "4">
            <img src = "Admin/product_image/<?php echo $img4;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">
          </a>
        </div>
        <!--<div class = "img-item">-->
        <!--  <a href = "#" data-id = "5">-->
        <!--    <img src = "Admin/product_image/<?php echo $img5;?>" alt = "<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture">-->
        <!--  </a>-->
        <!--</div>-->
      </div>
    </div>
    
  									
							   </div>
								<div class="col-md-5">
									<div class="product-simple-content">
										<div class="sinple-c-title">
											<h3><?php echo $pname;?></h3>
										</div>
										<?php
										if($stock >0){
										 ?>
										 <div class="checkbox">
											<span><i class="fa fa-check-square" aria-hidden="true"></i>In stock</span>
										</div>
										<?php
										}
										else{
									    ?>
										<div class="checkbox">
											<span style="color:red !important;"><i style="color:red !important;" class="fa fa-times" aria-hidden="true"></i>Out of Stock</span>
										</div>
										<?php
										}
										?>
										<span> SKU:<?php echo $sku;?></span>
										
									
											<h5 style="text-decoration:line-through;color:#808080;">₹<?php echo $old_price;?></h5><h4>₹<?php echo $new_price;?></h4>
									
										<div class="quick-add-to-cart">
										     <?php
										     include_once"connect.php";
										    
                                            if (isset($_SESSION['email'])) {
                                                $userEmail = $_SESSION['email'];
                                                // echo $userEmail;
                                            
                                                                                 
                                            $cmd1="select * from user where email='$userEmail'";
                                            $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
                                            $row1=mysqli_fetch_array($result1);
                                               
                                            $user_id = $row1['id'];
                                                
                                               
                                            ?>
											<form onsubmit="return cart(this);" id="myform" method="post" enctype="multipart/form-data" class="cart">
												<div class="numbers-row">
												    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">
    									        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id;?>">
													<label for="french-hens">Qty:</label>
													<input type="number"  name="quantity" id="quantity"  min="1" max="10" step="1" value="1">
												</div>
												<?php
												if($stock>0){
												?>
												<button name="submit" id="submit" class="single_add_to_cart_button hyper-page" type="submit"><span class="lnr lnr-cart"></span>Add to cart</button>
												<?php
												}
												else{
												   ?>
												   <button style="display:none;" name="submit" id="submit"  type="submit"><span class="lnr lnr-cart"  disabled></span>Add to cart</button><br/><br/><p style="color:red;">* You Can Not Add To Cart This Product Because It's Out of Stock.</p>
												   <?php
												}
												?>
												<div id="return"></div>
											</form>
											<?php
                                            }
                                            else{
                                                ?>
                                                	<form onsubmit="return cart(this);" id="myform" method="post" enctype="multipart/form-data" class="cart">
												<div class="numbers-row">
												 
													<label for="french-hens">Qty:</label>
													<input type="number"  name="quantity" id="quantity"  min="1" max="10" step="1" value="1">
												</div>
												
											
												<button class="button2 disabled2">Add To Cart</button>
												<p style="color:red;">* You Can Not Add To Cart This Product ,<br/>Login First..* <button style="background-color: #532A1A;" type="submit" class="btn btn-primary" ><a style="color:white;" href="login.php">Login</a></button></p>
												<div id="return"></div>
											</form>
                                                <?php
                                            }
											?>
										</div>
										<br/>
										<p><?php echo$description;?></p>
									</div>
								</div>
							</div>							
						</div>
						<div class="product-info-detailed pb-80">
							<div class="row">
								<!--<div class="col-lg-12">-->
								<!--	<div class="product-info-tab">-->
										<!-- Nav tabs -->
								<!--		<ul class="nav product-info-tab-menu" role="tablist">-->
								<!--			<li><a class="active" href="#details" data-bs-toggle="tab">details</a></li>-->
										
								<!--		</ul>-->
											<!-- Tab panes -->
								<!--		<div class="tab-content">-->
								<!--			<div class="tab-pane show active" id="details">-->
								<!--				<div class="product-info-tab-content">-->
								<!--					<p>Chilly weather is just an excuse to throw on your toasty, handsome new Oslo Trek Hoodie. It features an adjustable drawstring hood and a kangaroo pocket for extra hand warmth. The ultra-soft, cozy lining will have you wishing for more brisk days.</p>-->
								<!--					<ul>-->
								<!--						<li style="list-style-position: outside;"> Brown hoodie with black detail.</li>-->
								<!--						<li style="list-style-position: outside;">Pullover.</li>-->
								<!--						<li style="list-style-position: outside;">Adjustable drawstring hood.</li>-->
								<!--						<li style="list-style-position: outside;">Ribbed cuffs/waistband.</li>-->
								<!--						<li style="list-style-position: outside;">Machine wash/dry.</li>-->
								<!--					</ul>-->
								<!--				</div>-->
								<!--			</div>-->
										
								<!--		</div>										-->
								<!--	</div>-->
								<!--</div>-->
							</div>
						</div>
						
					</div>
                    <aside class="col-lg-3 col-md-12">
                        <div class="widget">
                           
                            <div class="recent-post">
                                <h3 class="mb-4"><b>Best Sellers</b></h3>
                                 <?php
                                include_once"connect.php";
                                         
                                $cmd2="select * from products order by id Asc limit 3";
                                $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                while($row2=mysqli_fetch_array($result2))
                                {     
                                    $product_id1 = $row2['id'];
                                    $pname2=$row2['pname'];
                                    $pcategory2=$row2['pcategory'];
                                    $img12=$row2['img1'];
                                    $img22=$row2['img2'];
                                    $img32=$row2['img3'];
                                    $img42=$row2['img4'];
                                    $img52=$row2['img5'];
                                    $description2=$row2['description'];
                                    $stock2=$row2['stock'];
                                    $old_price2=$row2['old_price'];
                                    $new_price2=$row2['new_price'];
                                    $tags2=$row2['tags'];
                                   
                                ?>
                                <div class="recent-main">
                                    <div class="recent-img">
                                        <a href="product.php?astringdata=<?php echo $row2['id'];; ?>"><img src="Admin/product_image/<?php echo $img12;?>" alt=""></a>
                                    </div>
                                    <div class="info-img">
                                        <a href="product.php?astringdata=<?php echo $row2['id'];; ?>"><h6><?php echo $pname2;?></h6></a>
                                        <p>₹<?php echo $new_price2;?></p>
                                    </div>
                                </div><br/>
                               <?php
                                }
                                ?>
                               
                            </div><br/>
                            <div class="recent-post">
                                <h3 class="mb-4"><b>Popolar Tags</b></h3>
                                <div class="tags">
                                    <span><a href="#" class="btn btn-outline-primary"><?php echo$tags2;?></a></span>
                                   
                                </div>
                               
                            </div>
                            <div class="recent-post py-5 shp-cat">
                                <h3 class="mb-4"><b>Category</b></h3>
                                <ul>
                                    <?php
                                         include_once"connect.php";
                                         
                                          $cmd4="select * from category";
                                          $result4=mysqli_query($con,$cmd4) or die(mysqli_error($con));
                                          while($row4=mysqli_fetch_array($result4))
                                          {     
                                              $categoryid = $row4['id'];
                                              $name=$row4['name'];
                                             
                                          ?>
                                    <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i><?php echo $name;?></a></li>
                                    <?php
                                          }
                                    ?>
                                </ul>
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
        <script src="js/owl.carousel.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/inner-script.js"></script>
        <script>
            const imgs = document.querySelectorAll('.img-select a');
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener('click', (event) => {
        event.preventDefault();
        imgId = imgItem.dataset.id;
        slideImage();
    });
});

function slideImage(){
    const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

    document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
}

window.addEventListener('resize', slideImage);
        </script>
        <script>
            $(window).on('scroll load', function() {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });

        </script>

    </div>
    <!-- Wrapper / End -->
     <script src="toastr/toastr.min.js"></script>
    <script src="js/add/addtocart.js"></script>
</body>

</html>
<?php

}
?>