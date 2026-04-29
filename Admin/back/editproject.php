<?php
  include("../connect.php");

	    if(isset($_POST['id']))
	    {
            $id  =  mysqli_real_escape_string($con,$_POST['id']);
            $id = htmlspecialchars($id);
            $project_name  =  mysqli_real_escape_string($con,$_POST['project_name']);
            $project_name = htmlspecialchars($project_name);
            $pro_desc  =  mysqli_real_escape_string($con,$_POST['pro_desc']);
            $pro_desc = htmlspecialchars($pro_desc);
            $interior_detail  =  mysqli_real_escape_string($con,$_POST['interior_detail']);
            $interior_detail = htmlspecialchars($interior_detail);
      
           
            $cmd="UPDATE `projects` SET `project_name`='$project_name',`pro_desc`=' $pro_desc',`interior_detail`='$interior_detail' WHERE id='$id'";
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
                    toastr["success"]("Project Updated  Successfully...!","Project")
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