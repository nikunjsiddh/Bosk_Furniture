<?php
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['msg'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$msg=$_POST['msg'];

		$to='aayuvora123@gmail.com';
		$subject='Form 99 destinations Website';
		$message="Name :".$name."\n"."Phone No. :".$phone."\n"."Wrote the following :"."\n".$msg;
		$headers="From: ".$email;

		if(mail($to, $subject, $message, $headers)){
			echo "<center><b>Sent Successfully! Thank you"." ".$name.", We will contact you shortly!</center></b>";
		}
		else{
			echo "Something went wrong!";
		}
	}
?>