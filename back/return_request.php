<?php
include("../connect.php");

if(isset($_POST['firstname']) )
{
    $user_id  =  mysqli_real_escape_string($con,$_POST['user_id']);
    $user_id = htmlspecialchars($user_id);
    $order_id  =  mysqli_real_escape_string($con,$_POST['order_id']);
    $order_id = htmlspecialchars($order_id);
    $product_id  =  mysqli_real_escape_string($con,$_POST['product_id']);
    $product_id = htmlspecialchars($product_id);
    $firstname  =  mysqli_real_escape_string($con,$_POST['firstname']);
    $firstname = htmlspecialchars($firstname);
    $lastname  =  mysqli_real_escape_string($con,$_POST['lastname']);
    $lastname = htmlspecialchars($lastname);
    $email  =  mysqli_real_escape_string($con,$_POST['email']);
    $email = htmlspecialchars($email);
    $phone  =  mysqli_real_escape_string($con,$_POST['phone']);
    $phone = htmlspecialchars($phone);
    $msg  =  mysqli_real_escape_string($con,$_POST['msg']);
    $msg = htmlspecialchars($msg);
    date_default_timezone_set('Asia/Kolkata'); // Set the time zone to Indian Standard Time (IST)
    $date_time = date('Y-m-d H:i:s');
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
				$filedes1 = '../return_request_image/'.$imgnamenew1;
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
				$filedes1 = '../return_request_image/'.$imgnamenew2;
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
				$filedes1 = '../return_request_image/'.$imgnamenew3;
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
				$filedes1 = '../return_request_image/'.$imgnamenew4;
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
				$filedes1 = '../return_request_image/'.$imgnamenew5;
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
	
	$sel="select * from return_request where product_id=$product_id and user_id='$user_id'" ;
    	$run=mysqli_query($con,$sel) or die(mysqli_error($con));
        if(mysqli_num_rows($run)<1)
        {
	
   $cmd="INSERT INTO `return_request`(`id`, `user_id`, `product_id`,`order_id`, `firstname`, `lastname`, `email`, `img1`, `img2`, `img3`, `img4`, `img5`, `msg`, `status`,`date_time`,`phone`) VALUES ('null','$user_id','$product_id','$order_id','$firstname','$lastname','$email','$imgnamenew1','$imgnamenew2','$imgnamenew3','$imgnamenew4','$imgnamenew5','$msg','0','$date_time','$phone')";
   
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
                    toastr["success"]("Return Request Sent Successfully...!","Return Request")
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
                toastr["warning"]("Return Request Already Sent To Admin","Warning")
    		</script>
    		<?php
        }
                
        }
        else
        {
           header('location:../404.php');   
        }
	
?>