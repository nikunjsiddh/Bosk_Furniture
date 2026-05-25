<?php
// Capture any stray output (PHP notices/warnings) so the JSON body stays clean.
ob_start();
header('Content-Type: application/json; charset=utf-8');

function respond($ok, $message) {
    if (ob_get_length() !== false) { ob_clean(); }
    echo json_encode(['success' => (bool)$ok, 'message' => $message]);
    exit;
}

if (!isset($_POST['newsemail'])) {
    respond(false, 'Missing email field.');
}

$email = trim($_POST['newsemail']);

if ($email === '') {
    respond(false, "Email can't be empty.");
}
if (strlen($email) > 80) {
    respond(false, 'Email must be under 80 characters.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.');
}
// Block mail-header injection attempts (no CR/LF allowed in the address).
if (preg_match('/[\r\n]/', $email)) {
    respond(false, 'Invalid email address.');
}

$safe_email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

$to      = 'boskinfracon@gmail.com';
$subject = 'Newsletter Subscription';
$message = "New newsletter subscription from the Bosk Furniture website.\n\nEmail: " . $safe_email;
$headers = "From: " . $safe_email . "\r\n" .
           "Reply-To: " . $safe_email . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

// Suppress mail() warnings so they don't leak into the JSON response body.
if (@mail($to, $subject, $message, $headers)) {
    respond(true, 'Subscribed successfully! We will notify you shortly.');
} else {
    respond(false, 'Something went wrong. Please try again later.');
}
?>
