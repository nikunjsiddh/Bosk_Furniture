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
	     $decode_user_id =base64_decode($user_id);
	   
?>
<!DOCTYPE HTML>
<html lang="en-IN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invoice | Bosk Furniture Order</title>
        <meta name="description" content="View your Bosk Furniture order invoice.">
        <meta name="robots" content="noindex, nofollow">
        <link rel="canonical" href="https://www.boskfurniture.com/invoice">
        <link rel="icon" href="images/fevicon.png" type="image/png"> <!-- Favicon-->
        <style>
            @import url('https://fonts.googleapis.com/css?family=Roboto+Slab:400,700|Rubik:400,500,700');
/* 
font-family: 'Rubik', sans-serif;
font-family: 'Roboto Slab', serif;
*/
*{
	font-family: 'Rubik', sans-serif !important;
}

.slide-down-enter,
.slide-down-leave
{
    -webkit-transition:200ms cubic-bezier(0.250, 0.250, 0.750, 0.750) all;
    -moz-transition:200ms cubic-bezier(0.250, 0.250, 0.750, 0.750) all;
    -ms-transition:200ms cubic-bezier(0.250, 0.250, 0.750, 0.750) all;
    -o-transition:200ms cubic-bezier(0.250, 0.250, 0.750, 0.750) all;
    transition:200ms cubic-bezier(0.250, 0.250, 0.750, 0.750) all;
    display:block;
    overflow:hidden;
    position:relative;
}

.items-table .row {
  border-bottom:1px solid #ddd;
  line-height:3em;
}
.items-table .row:last-child {
  border-bottom:none;
  line-height:3em;
}

.slide-down-enter.slide-down-enter-active,
.slide-down-leave {
    opacity:1;
    height:46px;
}

.slide-down-leave.slide-down-leave-active,
.slide-down-enter {
    opacity:0;
    height:0px;
}


.invoice-number-container * {
  font-weight:400;
}

.items-table .row:nth-child(even) {
  background:#f9f9f9;
}
.items-table input {
  line-height:1.5em;
}
.actions {
  padding-top:1em;
}
input:focus {
  outline: 0;
}
.col-xs-5.input-container input {
    width: 100%;
}
.heading {
  background-color:#532A1A;
  color:#FFF;
  margin-bottom:1em;
  text-align:center;
  line-height:2.5em;
  font-size: 16px;
}
.branding {
  padding-bottom:2em;
  border-bottom:1px solid #ddd;
}
.logo-container {
  text-align:right;
}
.infos .right {
  text-align:right;
}
.infos .right input {
  text-align:right;
}
.infos .input-container {
  padding:3px 0;
}

.header.row {
  font-weight:bold;
  border-bottom:1px solid #ddd;
  border-top:1px solid #ddd;
}

input, textarea{
  border: 1px solid #FFF; 
}

.container input:hover, .container textarea:hover,
.table-striped > tbody > tr:nth-child(2n+1) > td input:hover,
.container input:focus, .container textarea:focus,
.table-striped > tbody > tr:nth-child(2n+1) > td input:focus{
  border: 1px solid #CCC;
}

.table-striped > tbody > tr:nth-child(2n+1) > td input{
    background-color: #F9F9F9;
    border: 1px solid #F9F9F9;
}


.signature p {
    font-size: 13px;
    font-family: 'Roboto Slab', serif;
    letter-spacing: 1px;
    line-height: 1.4 !important;
    margin-top: 80px;
}
@media print {
    .noPrint {
        display:none;
    }
    .remove-item-container{
        visibility:hidden;
    }
    .add-item-container{
        visibility:hidden;
    }
	* { -webkit-print-color-adjust: exact; }
		html { background: none; padding: 0; }
		body { box-shadow: none; margin: 0; }
		span:empty { display: none; }
		.add, .cut { display: none; }
	  	.central_btn{display: none;}

}


body{
  padding:20px;
}

.infos input{
  width: 300px;
}

.align-right input{
  text-align:right;
  width: 300px;
}

div.container{
  width: 800px;
}

#imgInp{
  display: none;
}

.copy {
  font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif;
  width: 100%;
  margin: 40px 0 20px 0;
  font-size: 10px;
  color: rgba(0, 0, 0, 0.5);
  text-align: center;
  color: #404040;
  cursor: default;
  line-height: 1.4em;
}

.copy .love {
  display: inline-block;
  position: relative;
  color: #ce0c15;
}


.ui-datepicker .ui-datepicker-title span.ui-datepicker-month {
    font-family: 'Rubik', sans-serif;
    font-weight: 400;
    font-size: 15px;
}
.ui-datepicker .ui-datepicker-title span.ui-datepicker-year {
    font-family: 'Rubik', sans-serif;
    font-weight: 400;
    font-size: 15px;
}
th .ui-datepicker-week-end {
    font-family: 'Rubik', sans-serif;
    font-weight: 400;
    font-size: 15px;
    padding-top: 12px;
}
.ui-datepicker table th {
    font-family: 'Rubik', sans-serif;
    font-weight: 400;
    font-size: 13px;
}
.ui-datepicker td {
    font-size: 13px;
    font-family: 'Rubik', sans-serif;
}
.ui-datepicker td a.ui-state-default.ui-state-highlight.ui-state-active {
    background: #ffffff;
    color: #3F51B5;
    border: 1px solid #3F51B5;
    text-align: center;
}
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next {
    position: absolute;
    top: -4px;
    width: 1.8em;
    height: 1.8em;
}
.ui-datepicker table thead tr th:nth-child(2) {
    background: #F44336;
    color: #fff;
}
.ui-datepicker th {
    padding: 5px;
    text-align: center;
    font-weight: bold;
    border: 0;
    border-radius: 0;
}
.ui-datepicker table tbody tr td:nth-child(2) a.ui-state-default {
    border: 1px solid #f44336;
    text-align: center;
    background: #f44336;
    color: #fff;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    border: 1px solid #00BCD4;
    background: #00BCD4 50% 50% repeat-x;
    font-weight: normal;
    color: #ffffff;
    text-align: center;
}
.ui-datepicker table th {
    font-family: 'Rubik', sans-serif;
    font-weight: 400;
    font-size: 13px;
    background: #3c3c3c;
    color: #fff;
    border-right: 2px solid #fff;
}
.ui-datepicker .ui-datepicker-header {
    position: relative;
    padding: .2em 0;
    border: none;
    background: none;
}
.ui-datepicker table tbody tr a.ui-state-default.ui-state-active {
    background: #fff !important;
    color: #00bcd4 !important;
}
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus {
    border: none;
    background: none;
    font-weight: normal;
    color: #FFC107;
}
        </style>
    </head>
    <body>
        <head>
  <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
 
  <link rel='stylesheet' href='https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'>
</head>
<body>
  <div class="container" width="800px" id="invoice" >
    <div class="row">
      <div class="col-xs-12 heading">
        INVOICE
      </div>
    </div>
                                            <?php
                                             $currentDateTime = date('Y-m-d H:i:s');
                                             $cmd2="select * from admin";
                                             $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
                                             $row2=mysqli_fetch_array($result2);
                                             $email=$row2['email'];
                                             $phone=$row2['phone'];
                                             $firstname=$row2['firstname'];
                                             $lastname=$row2['lastname'];
                                             $adminname=$firstname.' '.$lastname;
                                                  
                                            $cmd1="select * from user where id='$decode_user_id'";
                                            $result1=mysqli_query($con,$cmd1)or die(mysqli_error($con));
                                            $row1=mysqli_fetch_array($result1);
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
                                            
                                            $microtime = microtime(); // Get current microtime
                                            $rand = mt_rand(); // Get a random number
                                            $input = $email . $microtime . $rand; // Concatenate email, microtime, and random number
                                            $Invoice_ID = md5($input);
                                            
                                            $cmd="select * from orders where order_id='$order_id'";
                                            $result=mysqli_query($con,$cmd) or die(mysqli_error($con));
                                            $row=mysqli_fetch_array($result);
                                            $address=$row['address'];
                                            //   $user_id=$row['user_id'];
                                            $date_time=$row['date_time'];
                                            $phone=$row['phone'];
                                          
                                            
                                  
                                          
                                ?>
    <div class="row branding">
      <div class="col-xs-6">
        <div class="invoice-number-container">
          <label for="invoice-number">Invoice id: <?php echo $Invoice_ID;?></label><br>
          <label for="invoice-number">Date:<?php echo $currentDateTime;?> </label> 
        </div>
      </div>
      <div class="col-xs-6 logo-container">
        
        <img src="images/logo-white.png" alt="Bosk Furniture logo" width="220" />
        <div>
         
        </div>
      </div>
    </div>
    <div class="row infos">
      <div class="col-xs-6">
          <p>Shipping From:</p>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $adminname;?>,</p></div>
        <div class="input-container"><p style="line-height:11px !important;">5,Aryamaan Complex,Near Meghani Circle,</p></div>
        <div class="input-container"><p style="line-height:11px !important;">Bhavnagar-364001,Gujarat,India.</p></div>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $email;?></p></div>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $phone;?></p></div>
        <div class="input-container" data-ng-hide='printMode' style="visibility:hidden">
          <select ng-model='currencySymbol' ng-options='currency.symbol as currency.name for currency in availableCurrencies'></select>
        </div>
      </div>
      <div class="col-xs-6 right">
          <p>Shipped To:</p>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $name;?>,</p></div>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $addressline1;?>,</p></div>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $addressline2;?>,</p></div>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $city;?>,<?php echo $pincode;?>,</p></div>
        <div class="input-container"><p style="line-height:11px !important;"><?php echo $state;?>,<?php echo $country;?></p></div>
      </div>
    </div>
    <div class="items-table">
      <div class="row header">
        
        <div class="col-xs-5">Name</div>
        <div class="col-xs-2">Quantity</div>
        <div class="col-xs-3">Price</div>
        <div class="col-xs-2 text-right">Item Total</div>
      </div>
      <?php
        include_once("connect.php");
        $cmd2="select * from order_items where order_id='$order_id'";
        $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
        while($row2=mysqli_fetch_array($result2))
        {     
            $product_id = $row2['product_id'];
        //   echo $product_id;
            $price=$row2['price'];
            $quantity=$row2['quantity'];
                                                            
                                                            
            $cmd3="select * from products where id='$product_id' ";
            $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
            while($row3=mysqli_fetch_array($result3))
            {     
                $pname = $row3['pname'];
                //   echo $pname;
                $pcategory=$row3['pcategory'];
                $img1=$row3['img1'];
                $new_price=$row3['new_price'];
                $total_price = $quantity * $new_price;
                $totalPrice1 += $total_price; 
                                                           
        ?>
      <div class="row invoice-item" ng-repeat="item in invoice.items" ng-animate="'slide-down'">
        
        <div class="col-xs-5 input-container">
          <p><?php echo $pname;?></p>
        </div>
        <div class="col-xs-2 input-container">
         <p><?php echo $quantity;?></p>
        </div>
        <div class="col-xs-2 input-container">
          <p>₹<?php echo $new_price;?></p>
        </div>
        <div class="col-xs-2 text-right input-container">
         <p style="margin-right: -38%;">₹<?php echo $total_price;?></p>
        </div>
      </div>
      <?php
        }
        }
       
        $total_price = $quantity * $new_price;
        $subTotal+=$totalPrice1;
        $tax=$subTotal*0.18;
        $shipping=$subTotal*0.02;
        $total1=$subTotal+$tax+$shipping;
                                       
        ?>
        
      <div class="row">
        <div class="col-xs-10 text-right">Sub Total</div>
        <div class="col-xs-2 text-right">₹ <?php echo $subTotal;?></div>
      </div>
      <div class="row">
        <div class="col-xs-10 text-right">Shipping(2%):</div>
        <div class="col-xs-2 text-right">₹ <?php echo $shipping;?></div>
      </div>
      <div class="row">
        <div class="col-xs-10 text-right">GST(18%):</div>
        <div class="col-xs-2 text-right">₹ <?php echo $tax;?></div>
      </div>
      <div class="row">
        <div class="col-xs-10 text-right">Grand Total:</div>
        <div class="col-xs-2 text-right">₹ <?php echo $total1;?></div>
      </div>
    </div>
    <div class="row noPrint actions">
     
      <a style="width: -webkit-fill-available;background-color:#532A1A;border:#532A1A" href="#" class="btn btn-primary" onclick="myFunction()" >Print/Download</a>
    </div>
    
  </div>
  
<script>
function myFunction() {
    window.print();
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

     
    </body>
</html>
<?php
}
?>