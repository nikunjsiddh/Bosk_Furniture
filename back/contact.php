<?php
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['msg'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $msg = $_POST['msg'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['img']['tmp_name'];
        $file_name = $_FILES['img']['name'];
        $file_type = $_FILES['img']['type'];

        $file_content = file_get_contents($file_tmp);
        $encoded_content = chunk_split(base64_encode($file_content));

       $to = 'boskinfracon@gmail.com';
        $subject = 'FROM BOSK FURNITURE WEBSITE';

        // Create a boundary
        $boundary = md5(time());

        // Headers
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n";

        // Plain text message
        $body = "--" . $boundary . "\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= "Name: " . $name . "\n";
        $body .= "Email: " . $email . "\n";
        $body .= "Phone: " . $phone . "\n";
        $body .= "Message:\n" . $msg . "\n\n";

        // Attachment
        $body .= "--" . $boundary . "\r\n";
        $body .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n\r\n";
        $body .= $encoded_content . "\r\n";
        $body .= "--" . $boundary . "--";

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            echo "<center><b>Sent Successfully! Thank you " . $name . ", We will contact you shortly!</b></center>";
        } else {
            echo "Something went wrong!";
        }
    } else {
        echo "File upload error!";
    }
}

?>