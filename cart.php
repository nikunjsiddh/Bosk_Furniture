<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");

    
$page_title       = 'Your Shopping Cart | Bosk Furniture';
$page_description = 'Review the furniture items in your shopping cart and proceed to secure checkout at Bosk Furniture India.';
$page_keywords    = 'shopping cart, bosk furniture cart, checkout furniture';
$page_canonical   = '/cart.php';
$page_robots      = 'noindex, follow';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php"?>
    <style>
     @import "compass/css3";
body{
    background-color:white;
}
 .product-image {
	 float: left;
	 width: 20%;
}
 .product-details {
	 float: left;
	 width: 37%;
}
 .product-price {
	 float: left;
	 width: 12%;
}
 .product-quantity {
	 float: left;
	 width: 10%;
}
 .product-removal {
	 float: left;
	 width: 9%;
}
 .product-line-price {
	 float: left;
	 width: 12%;
	 text-align: right;
}
/* This is used as the traditional .clearfix class */
 .group:before, .shopping-cart:before, .column-labels:before, .product:before, .totals-item:before, .group:after, .shopping-cart:after, .column-labels:after, .product:after, .totals-item:after {
	 content: '';
	 display: table;
}
 .group:after, .shopping-cart:after, .column-labels:after, .product:after, .totals-item:after {
	 clear: both;
}
 .group, .shopping-cart, .column-labels, .product, .totals-item {
	 zoom: 1;
}
/* Apply clearfix in a few places */
/* Apply dollar signs */
 .product .product-price:before, .product .product-line-price:before, .totals-value:before {
	 content: '₹';
}
/* Body/Header stuff */
 
 h1 {
	 font-weight: 100;
}
 label {
	 color: #000;
	 font-weight:bolder;
}
 .shopping-cart {
	 margin-top: -45px;
}
/* Column headers */
 .column-labels label {
	 padding-bottom: 15px;
	 margin-bottom: 15px;
	 border-bottom: 1px solid #eee;
}
  .column-labels .product-removal {
	 text-indent: 0px;
}
.column-labels .product-image, .column-labels .product-details{
	 text-indent: 48px;
}
/* Product entries */
 .product {
	 margin-bottom: 20px;
	 padding-bottom: 10px;
	 border-bottom: 1px solid #eee;
}
 .product .product-image {
	 text-align: center;
}
 .product .product-image img {
	 width: 100px;
}
 .product .product-details .product-title {
	 margin-right: 20px;
	 font-family: 'Open Sans', sans-serif;
	 font-size: 1.6rem;
}
 .product .product-details .product-description {
	 margin: 5px 20px 5px 0;
	 line-height: 1.4em;
}
 .product .product-quantity input {
	 width: 40px;
}
 .product .remove-product {
	 border: 0;
	 padding: 4px 8px;
	 background-color: #532A1A;
	 color: #fff;
	 font-family: 'Open Sans', sans-serif;
	 font-size: 12px;
	 border-radius: 3px;
}
 .product .remove-product:hover {
	 background-color: #a44;
}
.ji{
   
  width: 100%;
  border: 2px solid #532A1A;
 
  float:right;
  box-shadow: 5px 10px;
}
/* Totals section */
 .totals .totals-item {
	 float: right;
	 clear: both;
	 width: 100%;
	 margin-bottom: 10px;
	
}
 .totals .totals-item label {
	 float: left;
	 clear: both;
	 width: 79%;
	 text-align: right;
}
 .totals .totals-item .totals-value {
	 float: right;
	 width: 21%;
	 text-align: right;
	 font-weight:bolder;
}
 .totals .totals-item-total {
	 font-family: 'Open Sans', sans-serif;
}
 .checkout {
	 float: right;
	 border: 0;
	 margin-top: 20px;
	 padding: 6px 25px;
	 background-color: #532A1A;
	 color: #fff;
	 font-size: 25px;
	 border-radius: 3px;
}
 .checkout:hover {
	 background-color: #808080;
}
/* Make adjustments for tablet */
 @media screen and (max-width: 650px) {
	 .shopping-cart {
		 margin: 0;
		 padding-top: 20px;
		 border-top: 1px solid #eee;
	}
	 .column-labels {
		 display: none;
	}
	 .product-image {
		 float: right;
		 width: auto;
	}
	 .product-image img {
		 margin: 0 0 10px 10px;
	}
	 .product-details {
		 float: none;
		 margin-bottom: 10px;
		 width: auto;
	}
	 .product-price {
		 clear: both;
		 width: 70px;
	}
	 .product-quantity {
		 width: 100px;
	}
	 .product-quantity input {
		 margin-left: 20px;
	}
	 .product-quantity:before {
		 content: 'x';
	}
	 .product-removal {
		 width: auto;
	}
	 .product-line-price {
		 float: right;
		 width: 70px;
	}
}
/* Make more adjustments for phone */
 @media screen and (max-width: 350px) {
	 .product-removal {
		 float: right;
	}
	 .product-line-price {
		 float: right;
		 clear: left;
		 width: auto;
		 margin-top: 10px;
	}
	 .product .product-line-price:before {
		 content: 'Item Total: $';
	}
	 .totals .totals-item label {
		 width: 60%;
	}
	 .totals .totals-item .totals-value {
		 width: 40%;
	}
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
                    <h1 class="text-center">SHOPPING CART</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="index.php">Home</a><span>»</span><span>SHOPPING CART</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS --><br/><br/><br/><br/><br/>
        <?php
        include_once"connect.php";
 if (isset($_SESSION['email'])) {
      $userEmail = $_SESSION['email']; 
       
        $cmd7="select * from user where email='$userEmail'";
        $result7=mysqli_query($con,$cmd7) or die(mysqli_error($con));
        $row7=mysqli_fetch_array($result7);
           
            $user_id = $row7['id'];
            $email=$row7['email'];
                                              
            $cmd8="select * from cart where user_id='$user_id'";
            $result8=mysqli_query($con,$cmd8) or die(mysqli_error($con));
            $no_of_rows=(int)(mysqli_num_rows($result8));
            if($no_of_rows == 0){
                ?>
                <center><p class="mb-2" style="font-size:3.2rem;">Your Cart Is Empty</p><br/><button class="btn btn-primary mb-5" type="submit" style="background-color:#532A1A;"><a style="color:white;" href="shop.php">Shop Now</a></button></center>
            <?php    
            }else{
                
           
        ?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-8">
        <div class="shopping-cart">

  <div class="column-labels">
    <label style="color:black !important;font-weight:bolder;" class="product-image">Image</label>
    <label style="color:black !important;font-weight:bolder;" class="product-details">Name</label>
    <label style="color:black !important;font-weight:bolder;" class="product-price">Price</label>
    <label style="color:black !important;font-weight:bolder;" class="product-quantity">Quantity</label>
    <label style="color:black !important;font-weight:bolder;" class="product-removal">Remove</label>
    <label style="color:black !important;font-weight:bolder;" class="product-line-price">Total</label>
  </div>
<?php

    $userEmail = $_SESSION['email']; 
$totalPrice = 0;
$subTotal=0;
$cmd="select * from user where email='$userEmail'";
$result=mysqli_query($con,$cmd) or die(mysqli_error($con));
$row=mysqli_fetch_array($result);
   
    $user_id = $row['id'];
    $email=$row['email'];
                                      
    $cmd1="select * from cart where user_id='$user_id'";
    $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
    while($row1=mysqli_fetch_array($result1))
    {     
        $cart_id = $row1['id'];
      
        $product_id=$row1['product_id'];
        $quantity=$row1['quantity'];
        
    $cmd2="select * from products where id='$product_id'";
    $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
    while($row2=mysqli_fetch_array($result2))
    {     
        $pname = $row2['pname'];
        $img1 = $row2['img1'];
        $description = $row2['description'];
        $sku = $row2['sku'];
        $old_price = $row2['old_price'];
        $new_price = $row2['new_price'];
         $total_price = $quantity * $new_price;
         $totalPrice += $total_price;
          
       
?>
<form  id="quantityForm">
    <?php

                                  
$cmd3="select * from user where email='$userEmail'";
$result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
$row3=mysqli_fetch_array($result3);
   
    $user_id = $row['id'];
    $email=$row['email'];
    
   
?>
    
    <input type="hidden" name="price" value="<?php echo $new_price;?>">
  <div class="product">
     
    <div class="product-image">
      <img src="Admin/product_image/<?php echo $img1;?>">
    </div>
    <div class="product-details">
      <div class="product-title"><b><?php echo $pname;?></b></div>
      <p class="product-description"><?php echo $description;?></p>
    </div>
    <div class="product-price"><b><?php echo $new_price;?></b></div>
    <div class="product-quantity">
        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>">
          <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id;?>">
      <input type="number" data-product-id="<?php echo $product_id;?>" data-user-id="<?php echo $user_id;?>" name="quantity" id="quantity"  class="quantity-input" value="<?php echo $quantity;?>" min="1">
     
    </div>
    <div class="product-removal">
      <button onclick="deletecart(<?php echo $cart_id;  ?>)" class="remove-product"><i class="fa fa-trash"></i></button>
    </div>
    <?php
    $total_price = $quantity * $new_price;
    $subTotal+=$total_price;
    $tax=$subTotal*0.18;
    $shipping=$subTotal*0.02;
    $total1=$subTotal+$tax+$shipping;
    ?>
    <div class="product-line-price"><b><?php echo $total_price;?></b></div>
  </div>
 
  
<?php
}
}
?>

  </div>
    </div>
    <div style="margin-top:-3%;" class="col-md-4">
        <div class="ji">
 <table class="table table-borderless">
  
  <tbody>
    <tr>
      <th scope="row">Subtotal</th>
      <td class="totals-value" id="cart-subtotal" style="float:right;"><?php echo $subTotal; ?></td>
     
    </tr>
    <tr>
      <th scope="row">Gst & Tax</th>
      <td class="totals-value" id="cart-tax" style="float:right;"><?php echo $tax;?></td>
      
    </tr>
    <tr>
      <th scope="row">Shipping</th>
      <td class="totals-value" id="cart-shipping" style="float:right;"><?php echo $shipping;?></td>
      
    </tr>
    <tr>
      <th scope="row">Total</th>
      <td class="totals-value" id="cart-total" style="float:right;"><?php echo $total1;?></td>
      
    </tr>
  </tbody>
</table><hr/>
  <a  type="submit" class="checkout mr-2" href="checkout.php">checkout</a><br/><br/><br/><br/>
    </div>  
      
    </div>
</div>
</form>



</div><br/><br/>
<?php
 }
}
else{
    ?>
    <center><p class="mb-2" style="font-size:3.2rem;">Your Cart Is Empty</p><br/><button class="btn btn-primary mb-5" type="submit" style="background-color:#532A1A;"><a style="color:white;" href="login.php">Login / Register</a></button></center>
    <?php
   
}
?>
        <!-- START FOOTER -->
        <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <!-- START PRELOADER -->
        <?php include_once"design/pre_loader.php";?>
        <!-- END PRELOADER -->

        <!-- ARCHIVES JS -->
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
         <script src="js/add/addorderdetails.js"></script>
        <script>
            $(window).on('scroll load', function() {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });

        </script>
        <script>
            /* Set rates + misc */
var taxRate = 0.18;
var shippingRate = 0.02; 
var fadeTime = 300;


/* Assign actions */
$('.product-quantity input').change( function() {
  updateQuantity(this);
});

$('.product-removal button').click( function() {
  removeItem(this);
});


/* Recalculate cart */
function recalculateCart()
{
  var subtotal = 0;
  
  /* Sum up row totals */
  $('.product').each(function () {
    subtotal += parseFloat($(this).children('.product-line-price').text());
  });
  
  /* Calculate totals */
  var tax = subtotal * taxRate;
  var shipping = subtotal * shippingRate;
//   var shipping = (subtotal > 0 ? shippingRate : 0);
  var total = subtotal + tax + shipping;
  
  /* Update totals display */
  $('.totals-value').fadeOut(fadeTime, function() {
    $('#cart-subtotal').html(subtotal.toFixed(2));
    $('#cart-tax').html(tax.toFixed(2));
    $('#cart-shipping').html(shipping.toFixed(2));
    $('#cart-total').html(total.toFixed(2));
    if(total == 0){
      $('.checkout').fadeOut(fadeTime);
    }else{
      $('.checkout').fadeIn(fadeTime);
    }
    $('.totals-value').fadeIn(fadeTime);
  });
}


/* Update quantity */
function updateQuantity(quantityInput)
{
  /* Calculate line price */
  var productRow = $(quantityInput).parent().parent();
  var price = parseFloat(productRow.children('.product-price').text());
  var quantity = $(quantityInput).val();
  var linePrice = price * quantity;
  
  /* Update line price display and recalc cart totals */
  productRow.children('.product-line-price').each(function () {
    $(this).fadeOut(fadeTime, function() {
      $(this).text(linePrice.toFixed(2));
      recalculateCart();
      $(this).fadeIn(fadeTime);
    });
  });  
}



/* Remove item from cart */

        </script>
    </div>
  <!--<script>-->
  <!--      $(document).ready(function() {-->
  <!--          $('#quantity').on('input', function() {-->
  <!--              var newQuantity = $(this).val();-->
  <!--               var productId = $('#product_id').val();-->
  <!--              var userId = $('#user_id').val();-->

                <!--// Send an AJAX request to update_quantity.php-->
  <!--              $.ajax({-->
  <!--                  type: 'POST',-->
  <!--                  url: 'back/editquantity.php',-->
  <!--                  data: { product_id: productId, quantity: newQuantity, user_id: userId },-->
  <!--                  success: function(response) {-->
                        <!--console.log(response); // Log the response from the server-->
  <!--                  },-->
  <!--                  error: function(xhr, status, error) {-->
  <!--                      console.error("AJAX request failed:", status, error);-->
  <!--                      alert("AJAX request failed. Check the console for more information.");-->
  <!--                  }-->
  <!--              });-->
  <!--          });-->
  <!--      });-->
  <!--  </script>-->
    <script>
    $(document).ready(function() {
        $('.quantity-input').on('input', function() {
            var newQuantity = $(this).val();
            var productId = $(this).data('product-id'); // Get productId from the data attribute
            var userId = $(this).data('user-id'); 

            // Send an AJAX request to update_quantity.php
            $.ajax({
                type: 'POST',
                url: 'back/editquantity.php',
                data: { product_id: productId, quantity: newQuantity, user_id: userId },
                success: function(response) {
                    console.log(response); // Log the response from the server
                },
               error: function(xhr, status, error) {
    console.error("AJAX request failed:", status, error);
    console.log(xhr.responseText); // Log the responseText for additional details
    alert("AJAX request failed. Check the console for more information.");
}

            });
        });
    });
</script>



  <script src="js/add/deletecart.js"></script>
 
</body>

</html>
