<?php
require 'vendor/autoload.php'; // Adjust the path if necessary

$config = require 'phonepe_config.php';

use PhonePe\PhonePe;

$phonePe = new PhonePe($config['merchantId'], $config['merchantKey'], 1);
$orderId = 'ORDER_ID'; // Unique order ID
$amount = 100; // Amount in paise (e.g., 100 paise = 1 INR)
$callbackUrl = 'YOUR_CALLBACK_URL'; // URL to which PhonePe will send the response

$response = $phonePe->initiatePayment($orderId, $amount, $callbackUrl);

if ($response['success']) {
    // Payment initiated successfully
    echo "Payment URL: " . $response['paymentUrl'];
} else {
    // Handle error
    echo "Error: " . $response['message'];
}
