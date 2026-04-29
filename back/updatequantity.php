<?php
  include("../connect.php");

	    if(isset($_POST['product_id']))
	    {
            $product_id  =  mysqli_real_escape_string($con,$_POST['product_id']);
            $product_id = htmlspecialchars($product_id);
            $quantity  =  mysqli_real_escape_string($con,$_POST['quantity']);
            $quantity = htmlspecialchars($quantity);
           
           
            $cmd="UPDATE `products` SET `quantity`='$quantity' WHERE id='$id'";
        	$result=mysqli_query($con,$cmd) or die(mysqli_error($con));
        	if($result)
            {   
                echo "success";
            }
            else
            {
               echo "failed" ;          
            }
                
        }
        else
        {
           header('location:../../404.php');   
        }
     

?>