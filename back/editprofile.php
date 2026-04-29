<?php
  include("../connect.php");

	    if(isset($_POST['id']))
	    {
            $id  =  mysqli_real_escape_string($con,$_POST['id']);
            $id = htmlspecialchars($id);
            $addressline1  =  mysqli_real_escape_string($con,$_POST['addressline1']);
            $addressline1 = htmlspecialchars($addressline1);
            $addressline2  =  mysqli_real_escape_string($con,$_POST['addressline2']);
            $addressline2 = htmlspecialchars($addressline2);
            $pincode  =  mysqli_real_escape_string($con,$_POST['pincode']);
            $pincode = htmlspecialchars($pincode);
            $country  =  mysqli_real_escape_string($con,$_POST['country']);
            $country = htmlspecialchars($country);
            $state  =  mysqli_real_escape_string($con,$_POST['state']);
            $state = htmlspecialchars($state);
            $city  =  mysqli_real_escape_string($con,$_POST['city']);
            $city = htmlspecialchars($city);
            
            $cmd="UPDATE `user` SET `addressline1`='$addressline1',`addressline2`=' $addressline2',`pincode`='$pincode',`country`='$country',`state`='$state',`city`='$city' WHERE id='$id'";
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
                    toastr["success"]("Address Information Updated  Successfully...!","Address")
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