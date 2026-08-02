<?php
session_start();
include_once "../connect.php";
include_once "../config/razorpay.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

// Get payable amount in Rupees from request
$amount_in_rupees = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

if ($amount_in_rupees <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid payable amount']);
    exit();
}

// Convert to paise for Razorpay (₹1 = 100 paise)
$amount_in_paise = round($amount_in_rupees * 100);
$receipt_id = 'rcpt_' . time() . '_' . rand(100, 999);

// Create order via Razorpay REST API
$ch = curl_init('https://api.razorpay.com/v1/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'amount'          => $amount_in_paise,
    'currency'        => RAZORPAY_CURRENCY,
    'receipt'         => $receipt_id,
    'payment_capture' => 1
]));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local XAMPP dev compatibility

$response = curl_exec($ch);
$curl_error = curl_error($ch);
curl_close($ch);

if ($curl_error) {
    echo json_encode(['success' => false, 'message' => 'cURL Error: ' . $curl_error]);
    exit();
}

$orderData = json_decode($response, true);

if (isset($orderData['id'])) {
    echo json_encode([
        'success'           => true,
        'razorpay_order_id' => $orderData['id'],
        'amount'            => $amount_in_paise,
        'key'               => RAZORPAY_KEY_ID
    ]);
} else {
    $msg = $orderData['error']['description'] ?? 'Failed to initiate Razorpay order';
    echo json_encode(['success' => false, 'message' => $msg]);
}
?>
