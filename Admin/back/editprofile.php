<?php
  include("../connect.php");

	    if(isset($_POST['id']) && isset($_POST['pname']) && isset($_POST['description']) && isset($_POST['specification']) && isset($_POST['feature']))
	    {
            $id = mysqli_real_escape_string($con,$_POST['id']);
            $id = htmlspecialchars($id);
			$pname= mysqli_real_escape_string($con,$_POST['pname']);
            $pname = htmlspecialchars($pname);
			$category= mysqli_real_escape_string($con,$_POST['category']);
            $category = htmlspecialchars($category);
            $description = mysqli_real_escape_string($con,$_POST['description']);
            $description = htmlspecialchars($description);
			$specification= mysqli_real_escape_string($con,$_POST['specification']);
            $specification = htmlspecialchars($specification);
			$feature= mysqli_real_escape_string($con,$_POST['feature']);
            $feature = htmlspecialchars($feature);
           
            $cmd="UPDATE `cctv_data` SET `pname`='$pname',`category`='$category',`description`='$description',`specification`='$specification',`feature`='$feature' WHERE id='$id'";
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