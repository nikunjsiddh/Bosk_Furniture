<?php
  include("../connect.php");

	    if(isset($_POST['blog_title']))
	    {   
	        $id  =  mysqli_real_escape_string($con,$_POST['id']);
            $id = htmlspecialchars($id);
            $blog_title  =  mysqli_real_escape_string($con,$_POST['blog_title']);
            $blog_title = htmlspecialchars($blog_title);
            $blog_description  =  mysqli_real_escape_string($con,$_POST['blog_description']);
            $blog_description = htmlspecialchars($blog_description);
		
           
            $cmd="UPDATE `blog` SET `blog_title`='$blog_title',`blog_description`='$blog_description'  WHERE id='$id'";
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
                    toastr["success"]("Blog Updated  Successfully...!","Blog")
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