<?php
	include("../connect.php");		
    if(isset($_POST['email']) && isset($_POST['pwd']))
	{
	
		$email=mysqli_real_escape_string($con,$_POST['email']);
		$pwd=mysqli_real_escape_string($con,$_POST['pwd']);
		
		
		$sel = "select * from user where email='$email' and password='$pwd'";
		$ex = $con->query($sel) or die (mysqli_error($con));
		
		if($ex->num_rows>0)
		{
			while($row = mysqli_fetch_array($ex))
			{
				$email = $row['email'];
				$pwd = $row['pwd'];
			}
			session_start();
			$_SESSION['email'] = $email;
		
			echo "<script>window.location='index.php';</script>";
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
            toastr["error"]("Invalid Information... !","Login")
        </script>
<?php
	    }

    }
    else
    {   
        header('location:../../404');        
    }

?>