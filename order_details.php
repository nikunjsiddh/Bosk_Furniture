<?php
// Guarded session_start so it never collides and never triggers
// "headers already sent" warnings from included partials.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("connect.php");
if(isset($_GET['astringdata']) && isset($_GET['astringdata1']))
	{
	    $order_id = mysqli_real_escape_string($con,$_GET['astringdata']);
	     $user_id = mysqli_real_escape_string($con,$_GET['astringdata1']);
	   //  echo $user_id;
	   $decoded_user_id = base64_decode($user_id);
	   //echo $decoded_user_id;
$page_title       = 'Order Details | Bosk Furniture';
$page_description = 'View detailed information about your Bosk Furniture order including products, status and delivery information.';
$page_canonical   = '/order_details';
$page_robots      = 'noindex, nofollow';
?>
<!DOCTYPE HTML>
<html class="no-js" lang="en-IN">

<head>
    <?php include_once"design/header.php";?>
   <link rel="stylesheet" type="text/css" href="css/print-styles.css" media="print">
    <style media="print">
    body {
        background-color: white !important;
    }
    /* Add other styles with sufficient specificity */
</style>
   <script>
   function printDocument() {
    var printContents = document.getElementById("Invoice-Simple").innerHTML;
    var printContainer = document.createElement("div");
    printContainer.innerHTML = printContents;

    // Open a new window and set its content to the print container
    var printWindow = window.open('', '_blank');
    printWindow.document.body.appendChild(printContainer);

    // Print the contents of the new window
    printWindow.print();
}

</script>
    <style>
        body{
            background-color:white;
        }
        .list-group {
	 border-color: #d0d5dc !important;
}
 .list-group .list-group-item {
	 border-color: #d0d5dc !important;
}
 h1, h2, h3, h4, h5, h6 {
	 font-weight: 500 !important;
}
 a.account-card {
	 text-decoration: none;
	 color: unset;
}
 a.account-card i.fa {
	 font-size: 42px;
	 width: 45px;
}
 a.account-card .card {
	 background: #f9fafb;
	 border: 1px solid #d0d5dc;
}
 a.account-card .card:hover {
	 background: #fff;
}
 a.account-card .card:active {
	 background: #f0f2f5;
}
 .bg-yellow {
	 background: #f5d847;
	 color: #222c3a;
}
 .list-group-item-action {
	 background: #f9fafb;
}
 .list-group-item-action .fa {
	 width: 22px;
}
 .list-group-item-action .fa.fa-angle-right {
	 font-size: 20px;
	 position: absolute;
	 right: 5px;
	 top: 14px;
}
 .coupon {
	 background: #f9fafb;
	 border: 2px dashed #d0d5dc !important;
}
 .reward-status-box {
	 position: relative;
	 width: 100%;
	 color: #fff;
	 background: #1b8cb2;
	 border: 2px solid #38b7e1;
	 border-radius: 5px;
}
 .reward-status-box .reward-status {
	 width: 60%;
	 background: #38b7e1;
	 padding: 15px;
}
 .reward-status-box .current-status {
	 position: absolute;
	 right: 15px;
	 top: 15px;
	 color: #fff;
}
 .reward-status-box .current-status-2 {
	 position: absolute;
	 right: 15px;
	 top: 41px;
	 color: #fff;
}
 .text-orange {
	 color: #ec9532 !important;
}
 .text-carbon {
	 color: #222c3a !important;
}
 .text-pebble {
	 color: #79879a !important;
}
 .text-gray {
	 color: #a2abb9 !important;
}
 .text-cloud {
	 color: #d0d5dc !important;
}
 .text-blue {
	 color: #49aed0 !important;
}
 .text-gray {
	 color: #a2abb9 !important;
}
 .text-pale-sky {
	 color: #a2abb9 !important;
}
 .bg-black {
	 background: #111822 !important;
}
 .bg-snow {
	 background: #f9fafb !important;
}
 .bg-fog {
	 background: #f0f2f5 !important;
}
 .bb1-cloud {
	 border-bottom: 1px solid #d0d5dc;
}
 .fs-14 {
	 font-size: 14px !important;
}
 .fs-22 {
	 font-size: 22px !important;
}
 .tanga-header .navbar-brand {
	 margin-bottom: 5px;
}
 .tanga-header .nav-link {
	 color: #a2abb9;
}
 .tanga-header .nav-link:hover {
	 color: #fff;
}
 .tanga-header .nav-link:active {
	 color: #a2abb9;
}
 .tanga-navbar {
	 overflow-x: auto;
	 -webkit-overflow-scrolling: touch;
	 -ms-overflow-style: -ms-autohiding-scrollbar;
}
 .tanga-navbar:-webkit-scrollbar {
	 display: none;
}
 .tanga-navbar .nav-link {
	 white-space: nowrap;
	 color: #79879a;
}
 .tanga-navbar .nav-link:hover {
	 color: #354050;
}
 .tanga-navbar .nav-link:active {
	 color: #79879a;
}
 .btn-primary {
	 background: #c62931;
	 border-color: #c62931;
	 cursor: pointer;
}
 .btn-primary:hover {
	 background: #d94950;
	 border-color: #d94950;
}
 .btn-secondary {
	 background: #fff !important;
	 color: #354050 !important;
	 border-color: #d0d5dc !important;
	 cursor: pointer;
}
 .btn-secondary:hover {
	 color: #354050 !important;
	 background: #f9fafb !important;
}
 .btn-secondary:active {
	 color: #79879a !important;
	 background: #f0f2f5 !important;
}
 .btn-secondary:focus {
	 color: #79879a !important;
	 background: #f0f2f5 !important;
	 outline: 0 !important;
}
 .mobile-nav {
	 position: fixed;
	 bottom: 0;
	 z-index: 50;
	 display: block;
	 width: 100%;
	 background: #111822;
}
 .mobile-nav a {
	 text-decoration: none !important;
	 cursor: pointer;
	 color: #a2abb9;
	 font-size: 12px;
	 float: left;
	 width: 20%;
	 display: inline-block;
	 text-align: center;
	 margin: 0 !important;
	 padding: 8px 0px 5px 0px;
}
 .mobile-nav a.active {
	 background: #222c3a;
	 color: #fff;
}
 .mobile-nav a i {
	 font-size: 23px;
	 display: block;
	 margin: 0 auto;
	 margin-bottom: 2px;
}
 .fs-18 {
	 font-size: 18px !important;
}
 .fs-22 {
	 font-size: 22px !important;
}
 .bg-snow {
	 background: #f9fafb !important;
}
 .card {
	 border-color: #d0d5dc !important;
}
 .text-pebble {
	 color: #79879a !important;
}
 .text-charcoal {
	 color: #354050 !important;
}
 .bottom-drawer {
	 position: fixed;
	 bottom: 56px;
	 width: 100%;
	 border-top: 1px solid #d0d5dc;
}
 .bg-white {
	 background: #fff !important;
}
 .list-group {
	 border-color: #d0d5dc !important;
}
 .list-group-item {
	 border-color: #d0d5dc !important;
}
 .text-red {
	 color: #c62931 !important;
}
 .text-green {
	 color: #00a362 !important;
}
 .text-link-blue {
	 color: #3373cc !important;
}
 .form-control {
	 background: #f9fafb;
	 border-color: #d0d5dc !important;
}
 .bd-2-cloud {
	 border: 2px dashed #d0d5dc;
}
 .b-1-green {
	 border: 2px solid #00a362 !important;
}
 .br-8 {
	 border-radius: 5px;
}
 .address-radio .address-label {
	 padding: 1rem;
	 margin-bottom: 0 !important;
}
 .address-radio [type="radio"]:checked, .address-radio [type="radio"]:not(:checked) {
	 position: absolute;
	 opacity: 0;
}
 .address-radio [type="radio"]:checked + label, .address-radio [type="radio"]:not(:checked) + label {
	 position: relative;
	 padding-left: 50px;
	 width: 100%;
	 cursor: pointer;
	 line-height: 20px;
	 display: inline-block;
	 color: #354050;
}
 .address-radio [type="radio"]:checked + label:before, .address-radio [type="radio"]:not(:checked) + label:before {
	 content: '';
	 position: absolute;
	 left: 1rem;
	 top: 1rem;
	 width: 20px;
	 height: 20px;
	 border: 2px solid #d0d5dc;
	 border-radius: 50%;
	 background: #fff;
}
 .address-radio [type="radio"]:checked + label:after, .address-radio [type="radio"]:not(:checked) + label:after {
	 content: '';
	 width: 12px;
	 height: 12px;
	 background: #00a362;
	 position: absolute;
	 top: 20px;
	 left: 20px;
	 border-radius: 50%;
	 transition: all 0.2s ease;
}
 .address-radio [type="radio"]:not(:checked) + label:after {
	 opacity: 0;
	 transform: scale(0);
}
 .address-radio [type="radio"]:checked + label:after {
	 opacity: 1;
	 transform: scale(1);
}
 .address-radio [type="radio"]:not(:checked) ~ label p {
	 display: none;
}
 .address-radio [type="radio"]:checked ~ label p {
	 display: unset;
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
                    <h1 class="text-center">Order Detail</h1>
                </div>
            </div>
        </section>
        <div class="road">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <a href="/">Home</a><span>»</span><span><a href="profile#orders">My Orders</a></span><span>»</span><span>Order Detail</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION HEADINGS -->

        

  <?php
     $cmd1="select * from user where id='$decoded_user_id'";
     $result1=mysqli_query($con,$cmd1)or die(mysqli_error($con));
     $row1=mysqli_fetch_array($result1);
     $userssid=$row1['id'];
     $encode_user_id=base64_encode($userssid);
     $firstname=$row1['firstname'];
     $lastname=$row1['lastname'];
     $name=$firstname.' '.$lastname;
     $email=$row1['email'];
     $addressline1=$row1['addressline1'];
     $addressline2=$row1['addressline2'];
     $pincode=$row1['pincode'];
     $state=$row1['state'];
     $city=$row1['city'];
     $country=$row1['country'];
     $phone=$row1['phone'];
                                            
    $cmd="select * from orders where order_id='$order_id'";
    $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
    $row=mysqli_fetch_array($result);
    $address=$row['address'];
    $date_time=$row['date_time'];
    $phone=$row['phone'];
                                          
    ?>     
<div id="Invoice-Simple" class="container mt-3 mt-md-5">
  
  <div class="row">
    <div class="col-12">
      <div class="list-group mb-2">
        <div class="list-group-item p-3 bg-snow" style="position: relative;">
          <div class="row w-100 no-gutters">
            <div class="col-6 col-md">
              <h6 class="text-charcoal mb-0 w-100">Order Number</h6>
              <a href="" class="text-pebble mb-0 w-100 mb-2 mb-md-0"><b><?php echo $order_id;?></b></a>
            </div>
            <div class="col-6 col-md">
              <h6 class="text-charcoal mb-0 w-100">Date</h6>
              <p class="text-pebble mb-0 w-100 mb-2 mb-md-0"><?php echo $date_time;?></p>  
            </div>
            <!--<div class="col-6 col-md"> -->
            <!--  <h6 class="text-charcoal mb-0 w-100">Total</h6>-->
            <!--  <p class="text-pebble mb-0 w-100 mb-2 mb-md-0"><?php echo $totalPrice1;?></p> -->
            <!--</div>-->
            <div class="col-6 col-md"> 
              <h6 class="text-charcoal mb-0 w-100">Shipped To</h6>
              <p class="text-pebble mb-0 w-100 mb-2 mb-md-0"><?php echo $address;?></p> 
            </div>
            <div class="col-12 col-md-3">
              <a href="invoice?astringdata=<?php echo $order_id;?>&astringdata1=<?php echo $encode_user_id;?>"  class="btn btn-primary w-100">Download Invoice</a>
            </div>
          </div>
          
        </div>
        <div class="list-group-item p-3 bg-white">
          <div class="row no-gutters">
           
            <div class="col-12 col-md-12">
              <a href="" class="btn btn-secondary w-100 mb-2">Track Shipment</a>
              
            </div>
            <?php
            include_once("connect.php");
            $cmd2="select * from order_items where order_id='$order_id'";
            $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
            while($row2=mysqli_fetch_array($result2))
            {     
                $product_id = $row2['product_id'];
                $encode_product_id=base64_encode($product_id);                            
                $price=$row2['price'];
                $quantity=$row2['quantity'];
                                                            
                                                            
                $cmd3="select * from products where id='$product_id' ";
                $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
                while($row3=mysqli_fetch_array($result3))
            {     
                    $pname = $row3['pname'];
                                                      
                    $pcategory=$row3['pcategory'];
                    $img1=$row3['img1'];
                    $new_price=$row3['new_price'];
                    $total_price = $quantity * $new_price;
                    $totalPrice1 += $total_price; 
                                                           
            ?>
            <div class="row no-gutters mt-3">
              <div class="col-3 col-md-1">
                <img class="img-fluid pr-3" src="admin/product_image/<?php echo $img1;?>" alt="<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?> - Bosk Furniture order item" loading="lazy" decoding="async">
              </div>
              <div class="col-9 col-md-3 pr-0 pr-md-3">
                  
                <h6 class="text-charcoal mb-2 mb-md-1">
                  <a href="" class="text-charcoal"><b><?php echo $pname;?></b></a>
                </h6>
                
                <h6 class="text-charcoal text-left mb-0 mb-md-2"><b>₹ <?php echo $new_price;?></b></h6>
              </div>
              <div class="col-9 col-md-3 pr-0 pr-md-3">
                  
                <h6 class="text-charcoal mb-2 mb-md-1">
                  <a href="" class="text-charcoal"><b>Product's Quantity</b></a>
                </h6>
                
                <h6 class="text-charcoal text-left mb-0 mb-md-2"><b><?php echo $quantity;?> PC</b></h6>
              </div>
              <div class="col-9 col-md-3 pr-0 pr-md-3">
                  
                <h6 class="text-charcoal mb-2 mb-md-1">
                  <a href="" class="text-charcoal"><b>Sub Total</b></a>
                </h6>
                
                <h6 class="text-charcoal text-left mb-0 mb-md-2"><b>₹ <?php echo $total_price;?></b></h6>
              </div>
              
              <div class="col-12 col-md-2 hidden-sm-down">
                <a href="product?astringdata=<?php echo $encode_product_id;?>" class="btn btn-secondary w-100 mb-2">Buy It Again</a>
                <a href="return_request?astringdata=<?php echo $encode_product_id;?>&astringdata1=<?php echo $decoded_user_id;?>&astringdata2=<?php echo $order_id;?>" class="btn btn-secondary w-100">Request a Return</a>
              </div>
            </div>
            <?php
            }
            }
            ?>
            <hr/>
            
          </div>
          
        
      </div>
      
    </div>
    <div class="row no-gutters mt-3">
             
              <div class="col-12 col-md-6">
                 <div class="card mb-3">
                  <h5 style="color:black;" class="card-header"><b>Shipping From:</b></h5>
                  <div class="card-body">
                   
                    <p style="line-height:8px !important;" class="card-text mb-3 mt-2 ml-2">Bosk Furniture</p><p class="ml-2" style="line-height:8px !important;">5,Aryamaan Complex,</p><p style="line-height:8px !important;" class="ml-2">Near Meghani Circle,Sir Patannni Road,</p><p class="ml-2"style="line-height:8px !important;">Bhavnagar-364001,Gujarat,India.</p>
                    
                  </div>
                </div>  
              </div>
              <div style="border:none !important;" class="col-12 col-md-6 pr-0">
                  
                <div class="card mb-3">
                  <h5 style="color:black;" class="card-header"><b>Shipping to:</b></h5>
                  <div class="card-body">
                    
                    <p style="line-height:8px !important;" class="card-text mb-3 ml-2 mt-2 "><?php echo $name;?></p><p class="ml-2" style="line-height:8px !important;"><?php echo $addressline1;?>,</p><p style="line-height:8px !important;" class="ml-2"><?php echo $addressline2;?>,</p><p class="ml-2"style="line-height:8px !important;"><?php echo $city?>,<?php echo $pincode?>,<?php echo $state?>,<?php echo $country;?></p>
                    
                  </div>
                </div>  
              </div>
    </div>


<?php
    $total_price = $quantity * $new_price;
    $subTotal+=$totalPrice1;
    $tax=$subTotal*0.18;
    $shipping=$subTotal*0.02;
    $total1=$subTotal+$tax+$shipping;
?>    
<div class="col-12 col-md-12">
      <div class="pt-md-0">
        <div class="list-group mb-3">
          <div class="list-group-item  bg-snow">
            <h6 class="mb-0"><b>Order Summary</b></h6>
          </div>
          <div class="list-group-item py-2 px-3 bg-white">
            <div class="row w-100 no-gutters">
              <div style="color:black !important;" class="col-6 text-pebble">
                <b>Subtotal</b>
              </div>
              <div class="col-6 text-right text-charcoal">
               <b>₹ <?php echo $totalPrice1; ?></b>
              </div>
            </div>
          </div>
          <div class="list-group-item py-2 px-3 bg-white">
            <div class="row w-100 no-gutters">
              <div style="color:black !important;" class="col-6 text-pebble">
               <b>Gst & Tax</b>
              </div>
              <div class="col-6 text-right text-charcoal">
               <b>₹ <?php echo $tax;?></b>
              </div>
            </div>
          </div>
          <div class="list-group-item py-2 px-3 bg-white">
            <div class="row w-100 no-gutters">
              <div style="color:black !important;" class="col-6 text-pebble">
                <b>Shipping</b>
              </div>
              <div class="col-6 text-right text-charcoal">
                <b>₹ <?php echo $shipping;?></b>
              </div>
            </div>
          </div>
         
          <div class="list-group-item py-2 px-3 bg-snow">
            <div class="row w-100 no-gutters">
              <div style="color:black !important;" class="col-8 text-charcoal">
                <b>Total</b>
              </div>
              <div class="col-4 text-right text-green">
                <b>₹ <?php echo $total1;?></b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


</div>
<!--<center>-->
<!--<div class="box bg-3 mb-2">-->
<!--                <a href="masonry-box-project-4.php" class="button button--wayra button--border-thick button--text-upper button--size-s">Download Invoice</a>-->
<!--            </div>    -->
<!--</center>-->
       

       <?php include_once"design/footer.php";?>

        <a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <!-- END FOOTER -->

        <?php include_once"design/pre_loader.php";?>
        <?php include_once"design/script.php";?>

    </div>
    <!-- Wrapper / End -->
</body>

</html>
<?php
}
?>