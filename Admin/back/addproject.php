<?php
include("../connect.php");

if(isset($_POST['project_name'])  )
{
    $project_name  =  mysqli_real_escape_string($con,$_POST['project_name']);
    $project_name = htmlspecialchars($project_name);
    $pro_desc  =  mysqli_real_escape_string($con,$_POST['pro_desc']);
    $pro_desc = htmlspecialchars($pro_desc);
    $interior_detail  =  mysqli_real_escape_string($con,$_POST['interior_detail']);
    $interior_detail = htmlspecialchars($interior_detail);
    $rand1=rand(111111,999999);
    $rand2=rand(111111,999999);
   
    
    /* 1st image*/
	$doc = $_FILES['img1'];
	$imgname = $_FILES['img1']['name'];
	if($imgname === '')
	{
	    $imgnamenew1='noimg.jpg';
	}
	else
	{
	$imgtmpname = $_FILES['img1']['tmp_name'];
	$imgsize = $_FILES['img1']['size'];
	$imgerror = $_FILES['img1']['error'];
	$imgtype = $_FILES['img1']['type'];

	$fileext = explode('.',$imgname);
	$fileact = strtolower(end($fileext));

	$allowed = array('jpg','jpeg','png','pdf','JPG','JPEG','PNG','PDF');

	if(in_array($fileact,$allowed))
	{
		if($imgerror === 0)
		{
			if($imgsize < 4000000)
			{
				$imgnamenew1 = $rand1.".".$fileact;
				$filedes1 = '../project_image/'.$imgnamenew1;
				move_uploaded_file($imgtmpname,$filedes1);
			}
			else
			{
				echo'large file';
			}
		}
		else
		{
			echo'Error';
		}
	}
	else
	{
		echo'Invalid Ext.';
	}
	}
	
	 /* 2nd image*/
	$doc = $_FILES['img2'];
	$imgname = $_FILES['img2']['name'];
	if($imgname === '')
	{
	    $imgnamenew2='noimg.jpg';
	}
	else
	{
	$imgtmpname = $_FILES['img2']['tmp_name'];
	$imgsize = $_FILES['img2']['size'];
	$imgerror = $_FILES['img2']['error'];
	$imgtype = $_FILES['img2']['type'];

	$fileext = explode('.',$imgname);
	$fileact = strtolower(end($fileext));

	$allowed = array('jpg','jpeg','png','pdf','JPG','JPEG','PNG','PDF');

	if(in_array($fileact,$allowed))
	{
		if($imgerror === 0)
		{
			if($imgsize < 4000000)
			{
				$imgnamenew2 =$rand2.".".$fileact;
				$filedes1 = '../project_image/'.$imgnamenew2;
				move_uploaded_file($imgtmpname,$filedes1);
			}
			else
			{
				echo'large file';
			}
		}
		else
		{
			echo'Error';
		}
	}
	else
	{
		echo'Invalid Ext.';
	}
	}
    
 
   $cmd="INSERT INTO `projects`(`id`, `project_name`, `pro_desc`, `interior_detail`, `img1`, `img2`) VALUES ('null','$project_name','$pro_desc','$interior_detail','$imgnamenew1','$imgnamenew2')";
//   echo $cmd;
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
                    toastr["success"]("Project Added  Successfully...!","Project")
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