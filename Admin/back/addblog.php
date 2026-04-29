<?php
include("../connect.php");

if(isset($_POST['blog_title']))
{
   
    $blog_title  =  mysqli_real_escape_string($con,$_POST['blog_title']);
    $blog_title = htmlspecialchars($blog_title);
    $blog_description  =  mysqli_real_escape_string($con,$_POST['blog_description']);
    $blog_description = htmlspecialchars($blog_description);
    $currentDate = date('Y-m-d');
   
   
    $rand1=rand(111111,999999);
    $rand2=rand(111111,999999);
    $rand3=rand(111111,999999);
    $rand4=rand(111111,999999);
    $rand5=rand(111111,999999);
    
    /* 1st image*/
	$doc = $_FILES['img'];
	$imgname = $_FILES['img']['name'];
	if($imgname === '')
	{
	    $imgnamenew1='noimg.jpg';
	}
	else
	{
	$imgtmpname = $_FILES['img']['tmp_name'];
	$imgsize = $_FILES['img']['size'];
	$imgerror = $_FILES['img']['error'];
	$imgtype = $_FILES['img']['type'];

	$fileext = explode('.',$imgname);
	$fileact = strtolower(end($fileext));

	$allowed = array('jpg','jpeg','png','pdf','JPG','JPEG','PNG','PDF');

	if(in_array($fileact,$allowed))
	{
		if($imgerror === 0)
		{
			if($imgsize < 4000000)
			{
				$imgnamenew1 = $blog_title.".".$rand1.".".$fileact;
				$filedes1 = '../blog_image/'.$imgnamenew1;
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
	

	
	
   $cmd="INSERT INTO `blog`(`id`, `blog_title`, `blog_description`, `blog_date`, `img`) VALUES ('null','$blog_title','$blog_description','$currentDate','$imgnamenew1')";
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
                    toastr["success"]("Blog Added  Successfully...!","Blog")
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