<?php
include("../connect.php");

if(isset($_POST['firstname']))
{
   
    $firstname  =  mysqli_real_escape_string($con,$_POST['firstname']);
    $firstname = htmlspecialchars($firstname);
    $lastname  =  mysqli_real_escape_string($con,$_POST['lastname']);
    $lastname = htmlspecialchars($lastname);
    $email  =  mysqli_real_escape_string($con,$_POST['email']);
    $email = htmlspecialchars($email);
    $password  =  mysqli_real_escape_string($con,$_POST['password']);
    $password = htmlspecialchars($password);
    $currentDate = date("Y-m-d");
   
   
   

	
	
   $cmd="INSERT INTO `user`(`firstname`, `lastname`, `dob`, `email`, `password`, `joining_date`, `addressline1`, `addressline2`, `pincode`,`country`,`state`,`city`,`phone`,`img`) VALUES ('$firstname','$lastname','NA','$email','$password','$currentDate','NA','NA','NA','NA','NA','NA','NA','noimg.jpg')";
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
                    "showDuration": "1000",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                  }
                    toastr["success"]("Register  Successfully...!","Register")
                </script>
                <?php
                echo "<script>window.location='login.php';</script>";
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