<?php
  include("../connect.php");

	    if(isset($_POST['user_id']))
	    {
            // $id  =  mysqli_real_escape_string($con,$_POST['id']);
            // $id = htmlspecialchars($id);
            $user_id  =  mysqli_real_escape_string($con,$_POST['user_id']);
            $user_id = htmlspecialchars($user_id);
            $product_id  =  mysqli_real_escape_string($con,$_POST['product_id']);
            $product_id = htmlspecialchars($product_id);
            $quantity  =  mysqli_real_escape_string($con,$_POST['quantity']);
            $quantity = htmlspecialchars($quantity);
           
         
       
        
       
           
            
            $cmd="UPDATE `cart` SET `quantity`='$quantity' WHERE user_id='$user_id' and product_id='$product_id'";
            echo $cmd;
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
                    toastr["success"]("Quantity Updated  Successfully...!","Account")
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
           header('location:../../404.php');   
        }
     

?>