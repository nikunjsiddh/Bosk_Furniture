<?php
$page_title       = 'My Wishlist - Saved Furniture Favourites | Bosk Furniture';
$page_description = 'View and manage your saved furniture favourites in your Bosk Furniture wishlist - modular kitchens, wardrobes, sofas, beds and more.';
$page_keywords    = 'wishlist, saved furniture, bosk furniture favourites';
$page_canonical   = '/wishlist';
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
 .product-removal1 {
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
	 content: '$';
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
  .column-labels .product-removal1 {
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
	 font-family: 'HelveticaNeue-Medium', 'Helvetica Neue Medium';
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
	 font-family: 'HelveticaNeue-Medium', 'Helvetica Neue Medium';
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
	 font-family: 'HelveticaNeue-Medium', 'Helvetica Neue Medium';
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
	 background-color: #494;
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
	.product-removal1 {
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
	.product-removal1 {
		 float: right;
		 margin-top: 1%;
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
                    <h1 class="text-center">WISHLIST</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="/">Home</a><span>»</span><span>WISHLIST</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS --><br/><br/><br/><br/><br/>
<div class="container">

   
        <div class="shopping-cart">

  <div class="column-labels">
    <label style="color:black !important;font-weight:bolder;" class="product-image">Image</label>
    <label style="color:black !important;font-weight:bolder;" class="product-details">Name</label>
    <label style="color:black !important;font-weight:bolder;" class="product-price">Price</label>
    <label style="color:black !important;font-weight:bolder;" class="product-quantity">In Stock</label>
    <label style="color:black !important;font-weight:bolder;" class="product-removal">Remove</label>
    <label style="color:black !important;font-weight:bolder;" class="product-removal1">Add to Cart</label>
  </div>

  <div class="product">
    <div class="product-image">
      <img src="images/interior/p-1.png" loading="lazy" decoding="async">
    </div>
    <div class="product-details">
      <div class="product-title">Dingo Dog Bones</div>
      <p class="product-description">The best dog bones of all time. Holy crap. Your dog will be begging for these things! I got curious once and ate one myself. I'm a fan.</p>
    </div>
    <div class="product-price">12.99</div>
    <div class="product-quantity">
      In Stock
    </div>
    <div class="product-removal">
      <button style="margin-top: 8%" class="remove-product">
        Remove
      </button>
    </div>
    <div class="product-removal1"><a style="background-color:#532A1A;color:white;margin-top:1%" href="cart.html" class="btn btn__bg">Add to
                                                    Cart</a></div>
  </div>
  <div class="product">
    <div class="product-image">
      <img src="images/interior/p-1.png" loading="lazy" decoding="async">
    </div>
    <div class="product-details">
      <div class="product-title">Dingo Dog Bones</div>
      <p class="product-description">The best dog bones of all time. Holy crap. Your dog will be begging for these things! I got curious once and ate one myself. I'm a fan.</p>
    </div>
    <div class="product-price">12.99</div>
    <div class="product-quantity">
      Out Of Stock
    </div>
    <div class="product-removal">
      <button style="margin-top: 8%" class="remove-product">
        Remove
      </button>
    </div>
    <div class="product-removal1"><a style="background-color:#532A1A;color:white;margin-top:1%" href="cart.html" class="btn btn__bg disabled">Add
                                                    to Cart</a></div>
  </div>
  <div class="product">
    <div class="product-image">
      <img src="images/interior/p-1.png" loading="lazy" decoding="async">
    </div>
    <div class="product-details">
      <div class="product-title">Dingo Dog Bones</div>
      <p class="product-description">The best dog bones of all time. Holy crap. Your dog will be begging for these things! I got curious once and ate one myself. I'm a fan.</p>
    </div>
    <div class="product-price">12.99</div>
    <div class="product-quantity">
      In Stock
    </div>
    <div class="product-removal">
      <button style="margin-top: 8%" class="remove-product">
        Remove
      </button>
    </div>
    <div class="product-removal1"><a style="background-color:#532A1A;color:white;margin-top:1%" href="cart.html" class="btn btn__bg">Add to
                                                    Cart</a></div>
  </div>
  <div class="product">
    <div class="product-image">
      <img src="images/interior/p-1.png" loading="lazy" decoding="async">
    </div>
    <div class="product-details">
      <div class="product-title">Dingo Dog Bones</div>
      <p class="product-description">The best dog bones of all time. Holy crap. Your dog will be begging for these things! I got curious once and ate one myself. I'm a fan.</p>
    </div>
    <div class="product-price">12.99</div>
    <div class="product-quantity">
     In Stock
    </div>
    <div class="product-removal">
      <button style="margin-top: 8%" class="remove-product">
        Remove
      </button>
    </div>
    <div class="product-removal1"><a style="background-color:#532A1A;color:white;margin-top:1%" href="cart.html" class="btn btn__bg">Add to
                                                    Cart</a></div>
  </div>

  <div class="product">
    <div class="product-image">
      <img src="images/interior/p-1.png" loading="lazy" decoding="async">
    </div>
    <div class="product-details">
      <div class="product-title">Nutro™ Adult Lamb and Rice Dog Food</div>
      <p class="product-description">Who doesn't like lamb and rice? We've all hit the halal cart at 3am while quasi-blackout after a night of binge drinking in Manhattan. Now it's your dog's turn!</p>
    </div>
    <div class="product-price">45.99</div>
    <div class="product-quantity">
      In Stock
    </div>
    <div class="product-removal">
      <button style="margin-top: 8%" class="remove-product">
        Remove
      </button>
    </div>
    <div class="product-removal1"><a style="background-color:#532A1A;color:white;margin-top:1%" href="cart.html" class="btn btn__bg">Add to
                                                    Cart</a></div>
  </div>
  </div>
   
    </div>


        <!-- START FOOTER -->
        <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <!-- START PRELOADER -->
        <?php include_once"design/pre_loader.php";?>
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
        <script>
            $(window).on('scroll load', function() {
                $("#header.cloned #logo img").attr("src", $('#header #logo img').attr('data-sticky-logo'));
            });

        </script>
        <script>
            /* Set rates + misc */
var taxRate = 0.05;
var shippingRate = 15.00; 
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
  var shipping = (subtotal > 0 ? shippingRate : 0);
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
function removeItem(removeButton)
{
  /* Remove row from DOM and recalc cart total */
  var productRow = $(removeButton).parent().parent();
  productRow.slideUp(fadeTime, function() {
    productRow.remove();
    recalculateCart();
  });
}
        </script>
    </div>
    <!-- Wrapper / End -->
</body>

</html>
