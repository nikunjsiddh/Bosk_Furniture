<?php
// Session must start before ANY output (HTML, whitespace, BOM, etc.).
// nav.php also tries to start a session — we guard it there to avoid a duplicate call.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title       = 'Shop All Furniture Online | Bosk Furniture India';
$page_description = 'Browse the complete Bosk Furniture collection - modular kitchens, wardrobes, sofas, beds, dining sets and more. Premium furniture online across India with free shipping.';
$page_keywords    = 'all furniture, shop furniture online india, modular furniture, sofa, bed, wardrobe, dining table, bosk furniture catalogue';
$page_canonical   = '/all_products.php';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
     <link rel="stylesheet" href="toastr/toastr.css">
   <style>
   .hi:hover {
    color: white !important;
}
 .hi2:hover {
    color: #ffffff !important;
}
/*a,*/
/*a:hover {*/
/*  text-decoration: none !important;*/
/*}*/
/*img {*/
/*  max-width: 100%;*/
/*}*/
hr {
  margin-top: 0 !important;
  margin-bottom: 0 !important;
}
.pt-100 { padding-top: 100px; }
.pt-45 { padding-top: 45px; }
#not_found {
  text-align: center;
  color: red;
}
.grand-total {
  margin-top: 1rem;
  text-align: center;
  font-weight: 600;
}
.table {
  margin-bottom: 0 !important;
}
.default-btn {
  padding: 12px 25px 10px;
  text-align: center;
  color: var(--whiteColor) !important;
  font-size: var(--fontSize);
  transition: var(--transition);
  display: inline-block;
  align-items: center;
  justify-content: center;
  position: relative;
  border-radius: 8px;
  z-index: 0;
  background: var(--pinkColor);
  overflow: hidden;
  white-space: nowrap;
  border: 0;
}
.default-btn:before {
  content: '';
  position: absolute;
  top: 0;
  bottom: 0;
  left: 50%;
  width: 550px;
  height: 550px;
  margin: auto;
  background: var(--lightblueColor);
  border-radius: 8px;
  z-index: -1;
  transform-origin: top center;
  transform: translateX(-50%) translateY(-5%) scale(0.4);
  transition: transform .9s;
}
.default-btn:hover {
  color: var(--whiteColor) !important;
}
.default-btn:hover:before {
  transition: transform 1s;
  transform: translateX(-45%) translateY(0) scale(1);
  transform-origin: bottom center;
}
.btn-success {
  background-color: #F96B6A !important;
  border-color: #F96B6A !important;
}
.featured-area {
  background-color: #ffffff;
}
.featured-tab-area .tabs {
  margin: 0;
  padding: 0;
  list-style: none;
  float: right;
}
.featured-tab-area .tabs li {
  display: inline-block;
  line-height: initial;
  margin-right: 20px;
}
.featured-tab-area .tabs li a {
  display: inline-block;
  position: relative;
  color: var(--titleColor);
  padding: 13px 26px 10px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}
.featured-tab-area .tabs li.active a {
  background-color: var(--pinkColor);
  color: var(--whiteColor);
}
.featured-tab-area .tabs li.current a {
  background-color: var(--pinkColor);
  color: var(--whiteColor);
}
.featured-tab-area-ml .tabs {
  margin-top: 0 !important;
  float: left;
}
.tab .tabs_item {
  display: none;
}
.tab .tabs_item:first-child {
  display: block;
}
.featured-item {
  margin-bottom: 30px;
  background-color: var(--whiteColor);
  border-radius: 5px;
  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
}

.featured-item .featured-item-img {
  position: relative;
  z-index: 1;
  transition: 0.3s linear;
  overflow: hidden;
}
.featured-item .featured-item-img a {
  display: block;
}
.featured-item .featured-item-img a img {
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  border: 4px solid var(--whiteColor);
  transition: 0.3s linear;
}

.featured-item .featured-item-img a img:hover {
  scale: 1.08;
} 

.featured-item .content {
  padding: 20px 15px;
}
.featured-item .content h3 {
  margin-bottom: 10px;
}
.featured-item .content h3 a {
  color: var(--titleColor);
  -webkit-transition: var(--transition);
  transition: var(--transition);
  font-weight: bold;
}
.featured-item .content .content-in {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 12px 10px;
  border-radius: 3px;
}
.featured-item .content .content-in i {
  color: #ffcc00;
}
.featured-item .content .content-in span {
  font-size: 15px;
  color: var(--titleColor);
  font-weight: 500;
}
.featured-item .content .content-in h4 {
  font-size: 15px;
  color: var(--titleColor);
  font-weight: 500;
  margin-bottom: 0;
}
.featured-item .content .featured-content-list {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 0 0;
}
.featured-tab-area .tabs li {
  margin-right: 5px;
}
#staticBackdropLabel {
  font-weight: bold;
}
/* responsive css */
@media only screen and (max-width: 767px) {
  .featured-tab-area .tabs {
    margin: 20px 0 0;
    float: none;
    text-align: left;
  }
  .featured-tab-area .tabs li:last-child {
    margin-right: 5px;
  }
  .featured-tab-area .tabs li a {
    font-size: 14px;
    padding: 12px 16px 9px;
  }
  .featured-item .content {
    padding: 20px 10px;
  }
  .featured-item .content h3 {
    font-size: 19px;
  }
  .featured-item .content .content-in span {
    font-size: 14px;
  }
  .featured-item .content .content-in h4 {
    font-size: 14px;
  }
  .featured-item .content .featured-content-list {
    padding: 12px 0 0;
  }
}
@media only screen and (min-width: 576px) and (max-width: 767px) {
  .featured-item .content {
    padding: 20px 15px;
  }
}
@media only screen and (min-width: 768px) and (max-width: 991px) {
  .featured-tab-area .tabs li a {
    font-size: 14px;
    padding: 12px 16px 9px;
  }
  .featured-item .featured-item-img .featured-user {
    top: 20px;
  }
  .featured-item .featured-item-img .featured-user .featured-user-option img {
    margin-right: 7px;
    width: 25px !important;
    height: 25px !important;
  }
  .featured-item .featured-item-img .featured-user .featured-user-option span {
    font-size: 13px;
    padding-top: 2px;
  }
  .featured-item .featured-item-img .featured-item-clock {
    font-size: 18px;
  }
  .featured-item .content {
    padding: 20px 10px;
  }
  .featured-item .content h3 {
    font-size: 19px;
  }
  .featured-item .content .content-in span {
    font-size: 14px;
  }
  .featured-item .content .content-in h4 {
    font-size: 14px;
  }
  .featured-item .content .featured-content-list {
    padding: 12px 0 0;
  }
  .featured-item .content .featured-content-list p {
    font-size: 14px;
  }
  .featured-item .content .featured-content-list p i {
    font-size: 16px;
  }
}
@media only screen and (min-width: 992px) and (max-width: 1199px) {
  .featured-tab-area .tabs li {
    margin-right: 5px;
  }
  .featured-tab-area .tabs li a {
    font-size: 14px;
    padding: 12px 16px 9px;
  }
  .featured-item .content h3 {
    font-size: 16px;
  }
}
@media only screen and (min-width: 1200px) and (max-width: 1299px) {
  .featured-tab-area .tabs li a {
    font-size: 14px;
    padding: 12px 16px 9px;
  }
  .featured-item .content {
    padding: 20px 20px;
  }
  .featured-item .content .content-in {
    padding: 10px 5px 8px;
  }
  .featured-item .content h3 {
    font-size: 18px;
  }
}

/* product quantity Css*/

/* Reset for the demo */
 
 .button1 {
	 padding: 0;
	 margin: 0;
	 border-style: none;
	 touch-action: manipulation;
	 display: inline-block;
	 border: none;
	 background: none;
	 cursor: pointer;
}
/* End Reset for the demo */
/* Sass Config */
/* Contrast : 7.2:1 */
/* End Sass Config */
 .qty {
	 display: flex;
	 flex-wrap: wrap;
	 justify-content: center;
	 text-align: center;
}
 .qty label {
	 flex: 1 0 100%;
}
 .qty input {
	 width: 7rem;
	 height: 2rem;
	 font-size: 1.3rem;
	 text-align: center;
	 border: 1px solid #532A1A ;
}
 .qty .button1 {
	 width: 2rem;
	 height: 2rem;
	 color: #fff;
	 font-size: 2rem;
	 background: #532A1A ;
}
 .qty .button1.qtyminus {
	 margin-right: 0.3rem;
}
 .qty .button1.qtyplus {
	 margin-left: 0.3rem;
}

   /* ============ PRODUCT GRID REDESIGN ============ */
   .featured-area.portfolio .filters-group { margin-bottom: 10px; }
   .featured-area.portfolio .filters-group ul {
       list-style: none;
       padding: 0;
       margin: 0;
       display: flex;
       flex-wrap: wrap;
       gap: 10px;
       justify-content: center;
   }
   .featured-area.portfolio .filters-group ul li {
       margin: 0 !important;
       padding: 0 !important;
       background: transparent !important;
       border-radius: 30px;
       overflow: hidden;
       transition: transform .25s ease, box-shadow .25s ease;
   }
   .featured-area.portfolio .filters-group ul li a {
       display: inline-block;
       padding: 10px 22px;
       border-radius: 30px;
       background: #fff;
       color: #532A1A !important;
       font-weight: 600;
       font-size: 14px;
       letter-spacing: .3px;
       border: 1.5px solid #ecdfd7;
       transition: all .3s ease;
       text-decoration: none;
   }
   .featured-area.portfolio .filters-group ul li a:hover {
       background: #532A1A !important;
       color: #fff !important;
       border-color: #532A1A;
       transform: translateY(-2px);
       box-shadow: 0 8px 18px rgba(83, 42, 26, 0.25);
   }
   .featured-area.portfolio .filters-group ul li.active a {
       background: #532A1A !important;
       color: #fff !important;
       border-color: #532A1A;
   }

   /* Card */
   .featured-area.portfolio .featured-item {
       position: relative;
       margin-bottom: 30px;
       background: #fff;
       border-radius: 14px;
       overflow: hidden;
       box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
       transition: transform .4s cubic-bezier(.25,.8,.25,1),
                   box-shadow .4s ease;
       display: flex;
       flex-direction: column;
       height: 100%;
   }
   .featured-area.portfolio .featured-item:hover {
       transform: translateY(-10px);
       box-shadow: 0 22px 40px rgba(0, 0, 0, 0.16);
   }

   /* Image */
   .featured-area.portfolio .featured-item .featured-item-img {
       position: relative;
       overflow: hidden;
       aspect-ratio: 4 / 3;
       background: #f6f3f0;
       border-radius: 14px 14px 0 0;
   }
   /* Only the image-wrapping anchor should fill the box. The wishlist
      and quick-view anchors are absolutely positioned and must keep
      their own dimensions. */
   .featured-area.portfolio .featured-item .featured-item-img > a:not(.product-wishlist):not(.product-quickview) {
       display: block;
       width: 100%;
       height: 100%;
   }
   .featured-area.portfolio .featured-item .featured-item-img img {
       width: 100%;
       height: 100%;
       object-fit: cover;
       border: 0 !important;
       border-radius: 0 !important;
       transition: transform .8s cubic-bezier(.25,.8,.25,1), filter .4s ease;
   }
   .featured-area.portfolio .featured-item:hover .featured-item-img img {
       transform: scale(1.12);
       filter: brightness(.92);
   }
   .featured-area.portfolio .featured-item .featured-item-img::after {
       content: "";
       position: absolute;
       inset: 0;
       background: linear-gradient(to top, rgba(83,42,26,.55) 0%, rgba(0,0,0,0) 55%);
       opacity: 0;
       transition: opacity .4s ease;
       pointer-events: none;
   }
   .featured-area.portfolio .featured-item:hover .featured-item-img::after { opacity: 1; }

   /* Discount badge */
   .featured-area.portfolio .product-badge {
       position: absolute;
       top: 14px;
       left: 14px;
       background: #532A1A;
       color: #fff;
       padding: 6px 12px;
       border-radius: 20px;
       font-size: 11px;
       font-weight: 700;
       letter-spacing: .5px;
       z-index: 3;
       box-shadow: 0 4px 12px rgba(0,0,0,.18);
   }
   /* Wishlist heart */
   .featured-area.portfolio .product-wishlist {
       position: absolute !important;
       top: 14px !important;
       right: 14px !important;
       left: auto !important;
       width: 38px !important;
       height: 38px !important;
       border-radius: 50% !important;
       background: #fff !important;
       color: #532A1A !important;
       display: flex !important;
       align-items: center !important;
       justify-content: center !important;
       z-index: 3;
       cursor: pointer;
       box-shadow: 0 4px 12px rgba(0,0,0,.15);
       opacity: 0;
       transform: translateY(-8px);
       transition: opacity .35s ease, transform .35s ease, background .25s ease, color .25s ease;
       text-decoration: none !important;
       font-size: 15px;
       padding: 0 !important;
   }
   .featured-area.portfolio .featured-item:hover .product-wishlist {
       opacity: 1;
       transform: translateY(0);
   }
   .featured-area.portfolio .product-wishlist:hover {
       background: #532A1A;
       color: #fff;
   }

   /* Quick-view button overlay */
   .featured-area.portfolio .product-quickview {
       position: absolute !important;
       left: 50% !important;
       bottom: 14px !important;
       top: auto !important;
       right: auto !important;
       width: auto !important;
       height: auto !important;
       transform: translate(-50%, 20px);
       background: #fff !important;
       color: #532A1A !important;
       padding: 9px 22px !important;
       border-radius: 30px !important;
       font-size: 12px !important;
       font-weight: 600 !important;
       letter-spacing: 1px;
       text-transform: uppercase;
       z-index: 3;
       opacity: 0;
       transition: opacity .35s ease, transform .35s ease, background .3s ease, color .3s ease;
       text-decoration: none !important;
       box-shadow: 0 6px 18px rgba(0,0,0,.22);
       display: inline-block !important;
       line-height: 1.2 !important;
   }
   .featured-area.portfolio .featured-item:hover .product-quickview {
       opacity: 1;
       transform: translate(-50%, 0);
   }
   .featured-area.portfolio .product-quickview:hover {
       background: #532A1A;
       color: #fff;
   }

   /* Card content */
   .featured-area.portfolio .featured-item .content {
       padding: 20px 20px 22px;
       display: flex;
       flex-direction: column;
       flex-grow: 1;
   }
   .featured-area.portfolio .featured-item .content h3 {
       font-size: 17px;
       font-weight: 700;
       margin: 0 0 12px;
       line-height: 1.35;
       transition: color .3s ease;
   }
   .featured-area.portfolio .featured-item .content h3 a {
       color: #222;
       text-decoration: none;
   }
   .featured-area.portfolio .featured-item:hover .content h3 a {
       color: #532A1A;
   }
   .featured-area.portfolio .featured-item .content hr {
       border: 0;
       border-top: 1px dashed #eee;
       margin: 0 0 12px !important;
   }
   .featured-area.portfolio .featured-item .content-in {
       display: flex !important;
       align-items: baseline !important;
       justify-content: flex-start !important;
       gap: 12px;
       padding: 0 !important;
       margin-bottom: 12px;
   }
   .featured-area.portfolio .featured-item .content-in h4 {
       margin: 0 !important;
       font-weight: 700 !important;
   }
   .featured-area.portfolio .featured-item .content-in h4:first-child {
       font-size: 14px !important;
       color: #999 !important;
       font-weight: 500 !important;
       text-decoration: line-through !important;
   }
   .featured-area.portfolio .featured-item .content-in h4:last-child {
       font-size: 20px !important;
       color: #532A1A !important;
       text-decoration: none !important;
   }

   /* View Details button */
   .featured-area.portfolio .featured-item .featured-content-list {
       padding: 0 !important;
       margin-top: auto;
   }
   .featured-area.portfolio .featured-item .featured-content-list .btn {
       display: inline-flex !important;
       align-items: center;
       gap: 8px;
       width: 100%;
       justify-content: center;
       padding: 11px 18px !important;
       font-size: 13px !important;
       font-weight: 600 !important;
       letter-spacing: 1px;
       text-transform: uppercase;
       border-radius: 8px !important;
       background: #532A1A !important;
       color: #fff !important;
       border: 0 !important;
       position: relative;
       overflow: hidden;
       transition: background .35s ease, transform .25s ease, box-shadow .25s ease;
   }
   .featured-area.portfolio .featured-item .featured-content-list .btn:hover {
       background: #2d160c !important;
       transform: translateY(-2px);
       box-shadow: 0 10px 22px rgba(83, 42, 26, 0.35);
   }
   .featured-area.portfolio .featured-item .featured-content-list .btn::after {
       content: "→";
       transition: transform .3s ease;
   }
   .featured-area.portfolio .featured-item .featured-content-list .btn:hover::after {
       transform: translateX(5px);
   }

   /* "No products" state */
   .featured-area.portfolio .tab_content #not_found,
   .featured-area.portfolio .tab_content center p {
       font-size: 1.4rem !important;
       margin: 2rem auto !important;
       color: #666 !important;
   }

   @media (max-width: 575px) {
       .featured-area.portfolio .featured-item .content { padding: 16px 16px 18px; }
       .featured-area.portfolio .featured-item .content h3 { font-size: 15px; }
       .featured-area.portfolio .featured-item .content-in h4:last-child { font-size: 18px !important; }
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
                    <h1 class="text-center">All Products</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>PRODUCTS</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

       <!-- START SECTION PORTFOLIO -->
       
<main>
      
      <section>
         <div class="featured-area pt-100 pb-70 portfolio">
            <div class="container">
                <div class="filters-group">
                    <ul>
                        <li style="background-color:#521A2A;color:white;" class="active" data-filter="*"><a class="hi2" style="color:#ffffff;" href="">Show All</a></li>
                          
                        <?php
                        include_once"connect.php";
                                         
                            $cmd="select * from category";
                            $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                            while($row=mysqli_fetch_array($result))
                            {     
                                $id = $row['id'];
                                $name=$row['name'];
                                $img=$row['img'];
                        ?>
                        <li style="color:white !important;" data-filter=".people"><a class="hi" style="color:#532A1A;" href="shop.php?astringdata2=<?php echo $row['name'];?>"><?php echo $name;?></a></li>
                        <?php
                                }
                        ?>
                    </ul>
                </div>
               <div class="tab featured-tab-area">
                
                  <div class="tab_content current active pt-45">
                     
                     <div class="tabs_item current">
                        <div class="row justify-content-center">
                            <?php
                                
                                $cmd3="select * from products";
                                $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
                                $no_of_rows=(mysqli_num_rows($result3));
                                // echo $no_of_rows;
                                if($no_of_rows == 0){
                                        ?>
                                        <center><p class="" style="font-size:3.2rem;margin-bottom:6.2rem;"><b>No Products Available</b></p></center>
                                <?php        
                                    }
                                    else{
                                while($row3=mysqli_fetch_array($result3))
                                {     
                                    $id = $row3['id'];
                                    $product_id=$row3['id'];
                                    $pname=$row3['pname'];
                                    $pcategory=$row3['pcategory'];
                                    $img1=$row3['img1'];
                                    $img2=$row3['img2'];
                                    $img3=$row3['img3'];
                                    $img4=$row3['img4'];
                                    $img5=$row3['img5'];
                                    $description=$row3['description'];
                                    $stock=$row3['stock'];
                                    $old_price=$row3['old_price'];
                                    $new_price=$row3['new_price'];
                                    $tags=$row3['tags'];
                                    
                                    $encode_product_id=base64_encode($product_id);    
                                   
                                ?>
                                
                           <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                              <div class="featured-item">
                                 <div class="featured-item-img">
                                    <?php
                                        $oldP = (float) $old_price;
                                        $newP = (float) $new_price;
                                        $discount = ($oldP > 0 && $newP > 0 && $newP < $oldP)
                                            ? round((($oldP - $newP) / $oldP) * 100)
                                            : 0;
                                        if ($discount > 0) {
                                            echo '<span class="product-badge">-' . $discount . '% OFF</span>';
                                        }
                                    ?>
                                    <a href="product.php?astringdata=<?php echo $encode_product_id; ?>" class="product-wishlist" title="Add to wishlist" onclick="event.preventDefault();">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="product.php?astringdata=<?php echo $encode_product_id; ?>">
                                       <img src="Admin/product_image/<?php echo $img1;?>" alt="<?php echo htmlspecialchars($pname); ?>">
                                    </a>
                                    <a href="product.php?astringdata=<?php echo $encode_product_id; ?>" class="product-quickview">Quick View</a>
                                 </div>
                                 <div class="content">
                                    <h3><a href="product.php?astringdata=<?php echo $encode_product_id; ?>"><?php echo$pname;?></a></h3>
                                    <hr>
                                   <?php
                                        // include_once"connect.php";
                                                                             
                                        // $cmd1="select * from user where email='$userEmail'";
                                        // $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
                                        // $row1=mysqli_fetch_array($result1);
                                           
                                        // $user_id = $row1['id'];
                                            
                                           
                                       ?>
                                    <form  onsubmit="return cart(this);" id="myform" method="post" enctype="multipart/form-data" class="cart">
    									<!--<p class="qty">-->
    									<!--    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>">-->
    									<!--    <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id;?>">-->
    									    
             <!--                   			<label for="qty">Quantity:</label>-->
             <!--                   			<a  class="qtyminus button1" aria-hidden="true">&minus;</a>-->
             <!--                   			<input type="number" name="quantity" id="quantity" min="1" max="10" step="1" value="1">-->
             <!--                   			<a  class="qtyplus button1" aria-hidden="true">&plus;</a>-->
             <!--                   		</p>-->
    									
								    
                                    <div class="content-in">
                                        <h4 style="text-decoration: line-through;">Rs. <?php echo$old_price;?></h4>
                                       <h4>Rs. <?php echo $new_price;?></h4>
                                       
                                    </div>
                                    <hr>
                                    <div class="featured-content-list">
                                       <a  href="product.php?astringdata=<?php echo $encode_product_id; ?>" type="button"  data-name="Oxford" style="color:#fff !important;background-color:#532A1A !important;" d class="btn btn-primary">View Details</a>
                                    </div>
                                    <!--<div class="featured-content-list">-->
                                    <!--   <button  name="submit" id="submit"  data-name="Oxford" style="color:#fff !important;background-color:#532A1A !important;" d class="btn btn-primary"> Add to cart</button>-->
                                    <!--</div>-->
                                    <div id="return"></div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        <?php
                                    }
                            	}
                        ?>
                     
                        </div>
                     </div>
                     

                     <p id="not_found"></p>
                  </div>
               </div>
            </div>
         </div>
      </section>


      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Your Cart</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <table class="show-cart table">
        
                  </table>
                  <div class="grand-total">Total price: ₹<span class="total-cart"></span></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <!-- <button type="button" class="btn btn-danger clear-all">Clear All</button> -->
                </div>
            </div>
         </div>
      </div>
   </main>

        <!-- END SECTION PORTFOLIO -->

        <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <script>
        var shoppingCart = (function () {

    cart = [];

    function Item(name, price, count) {
      this.name = name;
      this.price = price;
      this.count = count;
    }

    // Save cart
    function saveCart() {
      localStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    // Load cart
    function loadCart() {
      cart = JSON.parse(localStorage.getItem('shoppingCart'));
    }
    if (localStorage.getItem("shoppingCart") != null) {
      loadCart();
    }


    var obj = {};

    // Add to cart
    obj.addItemToCart = function (name, price, count) {
      for (var item in cart) {
        if (cart[item].name === name) {
          cart[item].count++;
          saveCart();
          return;
        }
      }
      var item = new Item(name, price, count);
      cart.push(item);
      saveCart();
    }
    // Set count from item
    obj.setCountForItem = function (name, count) {
      for (var i in cart) {
        if (cart[i].name === name) {
          cart[i].count = count;
          break;
        }
      }
    };
    // Remove item from cart
    obj.removeItemFromCart = function (name) {
      for (var item in cart) {
        if (cart[item].name === name) {
          cart[item].count--;
          if (cart[item].count === 0) {
            cart.splice(item, 1);
          }
          break;
        }
      }
      saveCart();
    }

    // Remove all items from cart
    obj.removeItemFromCartAll = function (name) {
      for (var item in cart) {
        if (cart[item].name === name) {
          cart.splice(item, 1);
          break;
        }
      }
      saveCart();
    }

    // Clear cart
    obj.clearCart = function () {
      cart = [];
      saveCart();
    }

    // Count cart 
    obj.totalCount = function () {
      var totalCount = 0;
      for (var item in cart) {
        totalCount += cart[item].count;
      }
      return totalCount;
    }

    // Total cart
    obj.totalCart = function () {
      var totalCart = 0;
      for (var item in cart) {
        totalCart += cart[item].price * cart[item].count;
      }
      return Number(totalCart.toFixed(2));
    }

    // List cart
    obj.listCart = function () {
      var cartCopy = [];
      for (i in cart) {
        item = cart[i];
        itemCopy = {};
        for (p in item) {
          itemCopy[p] = item[p];
        }
        itemCopy.total = Number(item.price * item.count).toFixed(2);
        cartCopy.push(itemCopy)
      }
      return cartCopy;
    }
    return obj;
  })();


  // Add item
  $('.default-btn').click(function (event) {
    // alert('working');
    event.preventDefault();
    var name = $(this).data('name');
    var price = Number($(this).data('price'));
    shoppingCart.addItemToCart(name, price, 1);
    displayCart();
  });

  // Clear items
  $('.clear-cart').click(function () {
    shoppingCart.clearCart();
    displayCart();
  });


  function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {
      output += "<tr>"
        + "<td>" + cartArray[i].name + "</td>"
        + "<td>(" + cartArray[i].price + ")</td>"
        + "<td><div class='input-group'>"
        + "<input type='number' class='item-count form-control' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
        + "</div></td>"
        + "<td><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + ">X</button></td>"
        + " = "
        + "<td>" + cartArray[i].total + "</td>"
        + "</tr>";
    }
    $('.show-cart').html(output);
    $('.total-cart').html(shoppingCart.totalCart());
    $('.total-count').html(shoppingCart.totalCount());
  }

  // Delete item button

  $('.show-cart').on("click", ".delete-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.removeItemFromCartAll(name);
    displayCart();
  })

  // Item count input
  $('.show-cart').on("change", ".item-count", function (event) {
    var name = $(this).data('name');
    var count = Number($(this).val());
    shoppingCart.setCountForItem(name, count);
    displayCart();
  });
  displayCart();

//////// ui script start /////////
// Tabs Single Page
$('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
$('.tab ul.tabs li a').on('click', function (g) {
    var tab = $(this).closest('.tab'), 
    index = $(this).closest('li').index();
    tab.find('ul.tabs > li').removeClass('current');
    $(this).closest('li').addClass('current');
    tab.find('.tab_content').find('div.tabs_item').not('div.tabs_item:eq(' + index + ')').slideUp();
    tab.find('.tab_content').find('div.tabs_item:eq(' + index + ')').slideDown();
    g.preventDefault();
});

// search function
$('#search_field').on('keyup', function() {
  var value = $(this).val();
  var patt = new RegExp(value, "i");

  $('.tab_content').find('.col-lg-3').each(function() {
    var $table = $(this);
    
    if (!($table.find('.featured-item').text().search(patt) >= 0)) {
      $table.not('.featured-item').hide();
    }
    if (($table.find('.col-lg-3').text().search(patt) >= 0)) {
      $(this).show();
      document.getElementById('not_found').style.display = 'none';
    } else {
      document.getElementById("not_found").innerHTML = " Product not found..";
      document.getElementById('not_found').style.display = 'block';
    }
    
  });
  
});
    </script>
    <script>
        /*
* @Adilade Input Quantity Increment
* 
* Free to use - No warranty
*/

var input = document.querySelector('#qty');
var btnminus = document.querySelector('.qtyminus');
var btnplus = document.querySelector('.qtyplus');

if (input !== undefined && btnminus !== undefined && btnplus !== undefined && input !== null && btnminus !== null && btnplus !== null) {
	
	var min = Number(input.getAttribute('min'));
	var max = Number(input.getAttribute('max'));
	var step = Number(input.getAttribute('step'));

	function qtyminus(e) {
		var current = Number(input.value);
		var newval = (current - step);
		if(newval < min) {
			newval = min;
		} else if(newval > max) {
			newval = max;
		} 
		input.value = Number(newval);
		e.preventDefault();
	}

	function qtyplus(e) {
		var current = Number(input.value);
		var newval = (current + step);
		if(newval > max) newval = max;
		input.value = Number(newval);
		e.preventDefault();
	}
		
	btnminus.addEventListener('click', qtyminus);
	btnplus.addEventListener('click', qtyplus);
  
} // End if test
    </script>
     <script src="toastr/toastr.min.js"></script>
    <script src="js/add/addtocart.js"></script>
    <!-- Wrapper / End -->
</body>

</html>