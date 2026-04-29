<?php

    $to = "";  // Your email here
    $from = $_REQUEST['email'];
    $name = $_REQUEST['name'];
    $name = $_REQUEST['lastname'];
	  $message = $_REQUEST['message'];
    $headers = "From: $from";
	  $subject = "Contact Form NetCom Site";
   
    $fields = array();
    $fields{"name"} = "First name";
    $fields{"lastname"} = "Last name";
    $fields{"email"} = "Email";
    $fields{"message"} = "Message";
	

    $body = "Here is what was sent:\n\n"; foreach($fields as $a => $b){   $body .= sprintf("%20s: %s\n",$b,$_REQUEST[$a]); }

    $send = mail($to, $subject, $body, $headers);

?>
