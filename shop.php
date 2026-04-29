<?php 
include_once("connect.php");
if(isset($_GET['astringdata2']))
{
$categoryname = mysqli_real_escape_string($con,$_GET['astringdata2']);
$encodedData = str_replace('+', ' ', $_GET['astringdata2']);
$decodedcategoryname = urldecode($encodedData);
// echo $decodedcategoryname;
	    
	   
?>
<!DOCTYPE HTML>
<html class="no-js" lang="zxx">

<head>
    <?php include_once"design/header.php";?>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
     <link rel="stylesheet" href="toastr/toastr.css">
   <style>
.hi:hover {
    color: white !important;
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
                    <h1 class="text-center"><?php echo $decodedcategoryname; ?></h1>
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
                        <li  data-filter=".people"><a class="hi" style="color:#532A1A;" href="">Show All</a></li>
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
                                
                                $cmd3="select * from products where pcategory='$decodedcategoryname'";
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
                                
                           <div class="col-lg-3 col-md-6">
                              <div class="featured-item">
                                 <div class="featured-item-img">
                                    <a href="#">
                                       <a href="product.php?astringdata=<?php echo $encode_product_id; ?>"><img src="Admin/product_image/<?php echo $img1;?>"></a>
                                    </a>
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
                                       <a  href="product.php?astringdata=<?php echo $id; ?>" type="button"  data-name="Oxford" style="color:#fff !important;background-color:#532A1A !important;" d class="btn btn-primary">View Details</a>
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
<?php
}
?>