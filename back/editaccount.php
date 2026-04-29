<?php
  include("../connect.php");

	    if(isset($_POST['id']))
	    {
            $id  =  mysqli_real_escape_string($con,$_POST['id']);
            $id = htmlspecialchars($id);
            $firstname  =  mysqli_real_escape_string($con,$_POST['firstname']);
            $firstname = htmlspecialchars($firstname);
            $lastname  =  mysqli_real_escape_string($con,$_POST['lastname']);
            $lastname = htmlspecialchars($lastname);
            // $email  =  mysqli_real_escape_string($con,$_POST['email']);
            // $email = htmlspecialchars($email);
            $dob  =  mysqli_real_escape_string($con,$_POST['dob']);
            $dob = htmlspecialchars($dob);
            $phone  =  mysqli_real_escape_string($con,$_POST['phone']);
            $phone = htmlspecialchars($phone);
           
           $rand1=rand(111111,999999);
       
        
       
           
            
            $cmd="UPDATE `user` SET `firstname`='$firstname',`lastname`=' $lastname',`dob`='$dob',`phone`='$phone' WHERE id='$id'";
            // echo $cmd;
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
                    toastr["success"]("Account Information Updated  Successfully...!","Account")
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