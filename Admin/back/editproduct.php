<?php
  include("../connect.php");

	    if(isset($_POST['id']))
	    {
            $id  =  mysqli_real_escape_string($con,$_POST['id']);
            $id = htmlspecialchars($id);
            $old_price  =  mysqli_real_escape_string($con,$_POST['old_price']);
            $old_price = htmlspecialchars($old_price);
            $new_price  =  mysqli_real_escape_string($con,$_POST['new_price']);
            $new_price = htmlspecialchars($new_price);
            $status  =  mysqli_real_escape_string($con,$_POST['status']);
            $status = htmlspecialchars($status);
            $publish_date  =  mysqli_real_escape_string($con,$_POST['publish_date']);
            $publish_date = htmlspecialchars($publish_date);
            $publish_date = str_replace('T', ' ', $publish_date); // datetime-local -> MySQL datetime
            $tags  =  mysqli_real_escape_string($con,$_POST['tags']);
            $tags = htmlspecialchars($tags);
            $pcategory  =  mysqli_real_escape_string($con,$_POST['pcategory']);
            $pcategory = htmlspecialchars($pcategory);
            $sku  =  mysqli_real_escape_string($con,$_POST['sku']);
            $sku = htmlspecialchars($sku);
            $stock  =  mysqli_real_escape_string($con,$_POST['stock']);
            $stock = htmlspecialchars($stock);
            $pname  =  mysqli_real_escape_string($con,$_POST['pname']);
            $pname = htmlspecialchars($pname);
           
            $description  =  mysqli_real_escape_string($con,$_POST['description']);
            $description = htmlspecialchars($description);
		
           
            $cmd="UPDATE `products` SET `pname`='$pname',`pcategory`=' $pcategory',`description`='$description',`publish_date`='$publish_date',`sku`='$sku',`stock`='$stock',`status`='$status',`old_price`='$old_price',`new_price`='$new_price',`mrp`='$new_price',`tags`='$tags' WHERE id='$id'";
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
                    toastr["success"]("Product Updated  Successfully...!","Product")
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