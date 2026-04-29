<?php
include("../connect.php");

if(isset($_POST['user_id']))
{
  
    $user_id  =  mysqli_real_escape_string($con,$_POST['user_id']);
    $user_id = htmlspecialchars($user_id);
   
    
    $microtime = microtime(); // Get current microtime
    $rand = mt_rand(); // Get a random number
    $input = $email . $microtime . $rand; // Concatenate email, microtime, and random number
    $order_id = md5($input);
    $currentTimestamp = time();
    $currentDateTime = date("Y-m-d H:i:s", $currentTimestamp);
   
    $cmd4="select * from user where id='$user_id'";
    $result4=mysqli_query($con,$cmd4) or die(mysqli_error($con));
    $row4=mysqli_fetch_array($result4);
    $addressline1=$row4['addressline1'];
    $addressline2=$row4['addressline2'];
    $pincode=$row4['pincode'];
    $country=$row4['country'];
    $city=$row4['city'];
    $state=$row4['state'];
    $phone=$row4['phone'];
    $address=$addressline1.','.$addressline2.','.$city.','.$pincode.','.$state.','.$country;
   
    $cmd1="select * from cart where user_id='$user_id'";
    $result1=mysqli_query($con,$cmd1) or die(mysqli_error($con));
    $abc=mysqli_num_rows($result1);
    while($row1=mysqli_fetch_array($result1))
    {     
        $cart_id = $row1['id'];
      
        $product_id=$row1['product_id'];
        $quantity=$row1['quantity'];
        
	$cmd2="select * from products where id='$product_id'";
    $result2=mysqli_query($con,$cmd2) or die(mysqli_error($con));
  
    while($row2=mysqli_fetch_array($result2))
    {  
         $price=$row2['new_price'];
         
// 	for($i=0; $i < $abc; $i++)
// 	{
    $cmd="INSERT INTO `order_items`(`id`, `order_id`, `user_id`,`product_id`,`price`,`quantity`) VALUES ('null','$order_id','$user_id','$product_id','$price','$quantity')";
	$result=mysqli_query($con,$cmd) or die(mysqli_error($con));
	echo $result;
// 	}
    }
    }
	if($result)
            {   
               	$cmd3="INSERT INTO `orders`(`id`, `order_id`, `address`,`user_id`,`date_time`,`phone`) VALUES ('null','$order_id','$address','$user_id','$currentDateTime','$phone')";
	            $result3=mysqli_query($con,$cmd3) or die(mysqli_error($con));
	            echo $result3;
	            if($result3){
	                
    	            $cmd4="delete from cart where user_id='$user_id'";
    	            $result4=mysqli_query($con,$cmd4) or die(mysqli_error($con));
	                echo $result4;
	            if($result4)
                {   
                ?>
                <script>
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  }
                    toastr["success"]("Place Order!","Order")
                </script>
                <?php
            }
            else
            {
                echo'<script>
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  }
                    toastr["error"]("Place Order!","Failed")
                </script>';           
            }
	            }
	            else
            {
                echo'<script>
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  }
                    toastr["error"]("Order Insertion Failed!","Order Failed")
                </script>';           
            }
            }
            else
            {
                echo'<script>
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  }
                    toastr["error"]("Order Items Insertion Failed!","Order Items Failed")
                </script>';           
            }
                
        }
        else
        {
           header('location:../../404.php');   
        }
	
?>