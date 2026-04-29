<?php

        $receiving_email_address = 'boskinfracon@gmail.com';
        $headers="From: ".$_POST['newsemail'];
        if(mail($receiving_email_address,'Newsletter','I am Intrested In Your Products!!Please Contact Me As Soon As Possible!', $headers)){
		echo "<center><b style='color:black;'>'Subscribe Successfully!',We Will Notify You Shortly!</center></b>";
		}
		else{
		    echo "Something went wrong!";
		}
?>
