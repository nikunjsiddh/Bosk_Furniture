<?php
  include("../connect.php");

	    if(isset($_POST['id']))
	    {
            $id  =  mysqli_real_escape_string($con,$_POST['id']);
            $id = htmlspecialchars($id);
            $oldpassword  =  mysqli_real_escape_string($con,$_POST['oldpassword']);
            $oldpassword = htmlspecialchars($oldpassword);
            $newpassword  =  mysqli_real_escape_string($con,$_POST['newpassword']);
            $newpassword = htmlspecialchars($newpassword);
           
            
            $cmd="UPDATE `user` SET `password`='$newpassword'  WHERE id='$id' and password='$oldpassword'";
            // echo $cmd;
        	$result=mysqli_query($con,$cmd) or die(mysqli_error($con));
        	if(mysqli_affected_rows($con)>0)
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
                    toastr["success"]("Password Updated  Successfully...!","Password")
                </script>
                <?php
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
                    toastr["error"]("Current Password And New Password Is different...!","Password") 
                    </script>
                    <?php
            }
                
        }
        else
        {
           header('location:../../404.php');   
        }
     

?>