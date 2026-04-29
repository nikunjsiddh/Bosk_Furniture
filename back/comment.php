<?php
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['msg'])){
		$name=$_POST['name'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$msg=$_POST['msg'];

		$to='boskinfracon@gmail.com';
		$subject='From Bosk Furniture Website';
		$message="Name :".$name."\n"."Phone No. :".$phone."\n"."Wrote the following :"."\n".$msg;
		$headers="From: ".$email;

		if(mail($to, $subject, $message, $headers)){
			echo "<center><b>Submit Successfully! Thank you"." ".$name.", For your comment!</center></b>";
		}
		else{
			echo "Something went wrong!";
		}
	}
?>