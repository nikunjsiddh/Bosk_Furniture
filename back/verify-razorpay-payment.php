<?php
session_start();
include_once "../connect.php";
include_once "../config/razorpay.php";

header('Content-Type: application/json');

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

if (!$data) {
    $data = $_POST;
}

$razorpay_order_id   = $data['razorpay_order_id'] ?? '';
$razorpay_payment_id = $data['razorpay_payment_id'] ?? '';
$razorpay_signature  = $data['razorpay_signature'] ?? '';

if (!$razorpay_order_id || !$razorpay_payment_id || !$razorpay_signature) {
    echo json_encode(['success' => false, 'message' => 'Missing Razorpay payment parameters']);
    exit();
}

// Verify HMAC SHA256 signature
$expected_signature = hash_hmac(
    'sha256',
    $razorpay_order_id . "|" . $razorpay_payment_id,
    RAZORPAY_KEY_SECRET
);

if ($expected_signature !== $razorpay_signature) {
    echo json_encode(['success' => false, 'message' => 'Invalid payment signature. Verification failed.']);
    exit();
}

// --- Payment Verified Successfully! ---
$_SESSION['razorpay_payment_id'] = $razorpay_payment_id;
$_SESSION['razorpay_order_id']   = $razorpay_order_id;

echo json_encode([
    'success'    => true,
    'payment_id' => $razorpay_payment_id,
    'message'    => 'Payment verified successfully!'
]);
?>
