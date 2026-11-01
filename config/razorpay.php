<?php
/* ============================================================
   Bosk Furniture - Razorpay payment settings
   ------------------------------------------------------------
   The Razorpay keys are NOT stored in this file (it is in git).
   They are read from config/razorpay.local.php, which is ignored
   by git and blocked from the browser by config/.htaccess.

   Create that file once on each machine that takes payments
   (see HOW-TO-UPLOAD-LIVE.md, "4. Razorpay payment keys file"):

       <?php
       return [
           'key_id'     => 'your-key-id',      // starts with rzp_test_ or rzp_live_
           'key_secret' => 'your-key-secret',
           'currency'   => 'INR',   // optional, defaults to INR
       ];

   Same idea as config/mail.local.php for the SMTP password.

   This file still defines RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET and
   RAZORPAY_CURRENCY, so back/create-razorpay-order.php and
   back/verify-razorpay-payment.php use them unchanged. Those two
   endpoints return JSON, so if the keys are missing this file stops
   the request with a JSON error the checkout page can show.
   ============================================================ */

if (!defined('RAZORPAY_KEY_ID') || !defined('RAZORPAY_KEY_SECRET')) {

    $__bosk_rzp_file = __DIR__ . '/razorpay.local.php';
    $__bosk_rzp = is_file($__bosk_rzp_file) ? include $__bosk_rzp_file : null;
    if (!is_array($__bosk_rzp)) {
        $__bosk_rzp = [];
    }

    $__bosk_rzp_id       = isset($__bosk_rzp['key_id']) ? trim((string) $__bosk_rzp['key_id']) : '';
    $__bosk_rzp_secret   = isset($__bosk_rzp['key_secret']) ? trim((string) $__bosk_rzp['key_secret']) : '';
    $__bosk_rzp_currency = isset($__bosk_rzp['currency']) ? strtoupper(trim((string) $__bosk_rzp['currency'])) : '';

    if ($__bosk_rzp_id === '' || $__bosk_rzp_secret === '') {
        error_log('Bosk Razorpay: config/razorpay.local.php is missing or has no key_id / key_secret. '
            . 'See HOW-TO-UPLOAD-LIVE.md, "4. Razorpay payment keys file".');
        if (!headers_sent()) {
            http_response_code(503);
            header('Content-Type: application/json');
        }
        echo json_encode([
            'success' => false,
            'message' => 'Online payment is not set up yet (Razorpay keys are missing on the server). '
                . 'Please contact us to complete your booking.',
        ]);
        exit();
    }

    if (!defined('RAZORPAY_KEY_ID')) {
        define('RAZORPAY_KEY_ID', $__bosk_rzp_id);
    }
    if (!defined('RAZORPAY_KEY_SECRET')) {
        define('RAZORPAY_KEY_SECRET', $__bosk_rzp_secret);
    }
    if (!defined('RAZORPAY_CURRENCY')) {
        define('RAZORPAY_CURRENCY', $__bosk_rzp_currency !== '' ? $__bosk_rzp_currency : 'INR');
    }

    unset($__bosk_rzp, $__bosk_rzp_file, $__bosk_rzp_id, $__bosk_rzp_secret, $__bosk_rzp_currency);
}

if (!defined('RAZORPAY_CURRENCY')) {
    define('RAZORPAY_CURRENCY', 'INR');
}
