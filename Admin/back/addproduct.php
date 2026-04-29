<?php
include("../connect.php");

if(isset($_POST['old_price']) && isset($_POST['new_price']) && isset($_POST['status']) && isset($_POST['datetime']) && isset($_POST['tags']) && isset($_POST['pcategory']) && isset($_POST['sku']) && isset($_POST['stock']) && isset($_POST['pname'])  && isset($_POST['description']))
{
    $old_price  =  mysqli_real_escape_string($con,$_POST['old_price']);
    $old_price = htmlspecialchars($old_price);
    $new_price  =  mysqli_real_escape_string($con,$_POST['new_price']);
    $new_price = htmlspecialchars($new_price);
    $status  =  mysqli_real_escape_string($con,$_POST['status']);
    $status = htmlspecialchars($status);
    $datetime  =  mysqli_real_escape_string($con,$_POST['datetime']);
    $datetime = htmlspecialchars($datetime);
    $tags  =  mysqli_real_escape_string($con,$_POST['tags']);
    $tags = htmlspecialchars($tags);
    $pcategory  =  mysqli_real_escape_string($con,$_POST['pcategory']);
    $pcategory = htmlspecialchars($pcategory);
    $sku  =  mysqli_real_escape_string($con,$_POST['sku']);
    $sku = htmlspecialchars($sku);
    $stock  =  mysqli_real_escape_string($con,$_POST['stock']);
    $stock = htmlspecialchars($stock);
    $pname  =  mysqli_real_escape_string($con,$_POST['pname']);
    $pname = htmlspecialchars($pname);
   
    $description  =  mysqli_real_escape_string($con,$_POST['description']);
    $description = htmlspecialchars($description);
    $rand1=rand(111111,999999);
    $rand2=rand(111111,999999);
    $rand3=rand(111111,999999);
    $rand4=rand(111111,999999);
    $rand5=rand(111111,999999);
    
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
				$filedes1 = '../product_image/'.$imgnamenew1;
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
				$filedes1 = '../product_image/'.$imgnamenew2;
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
    
     /* 3rd image*/
	$doc = $_FILES['img3'];
	$imgname = $_FILES['img3']['name'];
	if($imgname === '')
	{
	    $imgnamenew3='noimg.jpg';
	}
	else
	{
	$imgtmpname = $_FILES['img3']['tmp_name'];
	$imgsize = $_FILES['img3']['size'];
	$imgerror = $_FILES['img3']['error'];
	$imgtype = $_FILES['img3']['type'];

	$fileext = explode('.',$imgname);
	$fileact = strtolower(end($fileext));

	$allowed = array('jpg','jpeg','png','pdf','JPG','JPEG','PNG','PDF');

	if(in_array($fileact,$allowed))
	{
		if($imgerror === 0)
		{
			if($imgsize < 4000000)
			{
				$imgnamenew3 = $rand3.".".$fileact;
				$filedes1 = '../product_image/'.$imgnamenew3;
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
	
	 /* 4th image*/
	$doc = $_FILES['img4'];
	$imgname = $_FILES['img4']['name'];
	if($imgname === '')
	{
	    $imgnamenew4='noimg.jpg';
	}
	else
	{
	$imgtmpname = $_FILES['img4']['tmp_name'];
	$imgsize = $_FILES['img4']['size'];
	$imgerror = $_FILES['img4']['error'];
	$imgtype = $_FILES['img4']['type'];

	$fileext = explode('.',$imgname);
	$fileact = strtolower(end($fileext));

	$allowed = array('jpg','jpeg','png','pdf','JPG','JPEG','PNG','PDF');

	if(in_array($fileact,$allowed))
	{
		if($imgerror === 0)
		{
			if($imgsize < 4000000)
			{
				$imgnamenew4 = $rand4.".".$fileact;
				$filedes1 = '../product_image/'.$imgnamenew4;
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
	
	 /* 5th image*/
	$doc = $_FILES['img5'];
	$imgname = $_FILES['img5']['name'];
	if($imgname === '')
	{
	    $imgnamenew5='noimg.jpg';
	}
	else
	{
	$imgtmpname = $_FILES['img5']['tmp_name'];
	$imgsize = $_FILES['img5']['size'];
	$imgerror = $_FILES['img5']['error'];
	$imgtype = $_FILES['img5']['type'];

	$fileext = explode('.',$imgname);
	$fileact = strtolower(end($fileext));

	$allowed = array('jpg','jpeg','png','pdf','JPG','JPEG','PNG','PDF');

	if(in_array($fileact,$allowed))
	{
		if($imgerror === 0)
		{
			if($imgsize < 4000000)
			{
				$imgnamenew5 =$rand5.".".$fileact;
				$filedes1 = '../product_image/'.$imgnamenew5;
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
	
	
   $cmd="INSERT INTO `products`(`id`, `pname`, `pcategory`, `img1`, `img2`, `img3`, `img4`, `img5`, `description`, `publish_date`, `sku`, `stock`, `status`, `old_price`, `new_price`, `mrp`, `tags`) VALUES ('null','$pname','$pcategory','$imgnamenew1','$imgnamenew2','$imgnamenew3','$imgnamenew4','$imgnamenew5','$description','$datetime','$sku','$stock','$status','$old_price','$new_price','$new_price','$tags')";
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
                    toastr["success"]("Product Added  Successfully...!","Product")
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