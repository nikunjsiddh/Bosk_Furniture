<?php
include("../connect.php");

if( isset($_POST['user_id']) &&isset($_POST['product_id']) &&isset($_POST['quantity']))
{
    
   
    // $id  =  mysqli_real_escape_string($con,$_POST['id']);
    // $id = htmlspecialchars($id);
    $user_id  =  mysqli_real_escape_string($con,$_POST['user_id']);
    $user_id = htmlspecialchars($user_id);
    $product_id  =  mysqli_real_escape_string($con,$_POST['product_id']);
    $product_id = htmlspecialchars($product_id);
    $quantity  =  mysqli_real_escape_string($con,$_POST['quantity']);
    $quantity = htmlspecialchars($quantity);
   
   
       $sel="select * from cart where product_id=$product_id and user_id='$user_id'" ;
    	$run=mysqli_query($con,$sel) or die(mysqli_error($con));
        if(mysqli_num_rows($run)<1)
        {   
          
   
	
       $cmd="INSERT INTO `cart`(`id`, `user_id`, `product_id`,`quantity`) VALUES ('null','$user_id','$product_id','$quantity')";
    	$result=mysqli_query($con,$cmd) or die(mysqli_error($con));
    	if($result)
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
                    toastr["success"]("Added to Cart...!","Cart")
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
                    toastr["error"]("Something Went Wrong...!","Failed")
                </script>';           
            }
        }
    else
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
            toastr["warning"]("Item Already Exist","Warning")
		</script>
		<?php
    }
                
        }
        else
        {
           header('location:../../404.php');   
        }
	
?>