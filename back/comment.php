<?php
	if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['msg'])) {
		$name  = trim($_POST['name']);
		$email = trim($_POST['email']);
		$phone = trim($_POST['phone']);
		$msg   = trim($_POST['msg']);

		$errors = [];

		if ($name === '' || strlen($name) < 2 || strlen($name) > 60) {
			$errors[] = 'Please enter a valid name (2-60 characters).';
		} elseif (!preg_match("/^[A-Za-z\s.'\-]{2,60}$/", $name)) {
			$errors[] = "Name may only contain letters, spaces and . ' -";
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Please enter a valid email address.';
		}

		if (!preg_match('/^[6-9]\d{9}$/', $phone)) {
			$errors[] = 'Please enter a valid 10-digit Indian mobile number.';
		}

		if ($msg === '' || strlen($msg) < 10 || strlen($msg) > 1000) {
			$errors[] = 'Comment must be between 10 and 1000 characters.';
		}

		if (!empty($errors)) {
			echo '<center style="color:#c0392b;"><b>' . htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8') . '</b></center>';
			exit;
		}

		$safe_name  = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
		$safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
		$safe_phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
		$safe_msg   = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');

		$to      = 'boskinfracon@gmail.com';
		$subject = 'From Bosk Furniture Website';
		$message = "Name :" . $safe_name . "\n" . "Phone No. :" . $safe_phone . "\n" . "Wrote the following :" . "\n" . $safe_msg;
		$headers = "From: " . $safe_email;

		if (mail($to, $subject, $message, $headers)) {
			echo "<center><b>Submit Successfully! Thank you " . $safe_name . ", For your comment!</center></b>";
		} else {
			echo "<center style='color:#c0392b;'><b>Something went wrong! Please try again later.</b></center>";
		}
	} else {
		echo "<center style='color:#c0392b;'><b>Missing required fields.</b></center>";
	}
?>
