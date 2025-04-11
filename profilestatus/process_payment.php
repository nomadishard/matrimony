<?php
$merchantId = 'TEST_M22T7JFO0FCUI_25041';
$saltKey = 'MDAyZjU1NzQtNzI4Ni00OWYwLTljZjYtMjJiZWRjNzI1ZDAy';
$saltIndex = "1";

$amount = $_POST['amount'] * 100;
$name = $_POST['name'];
$email = $_POST['email'];
$orderId = uniqid();

$paymentData = [
    'merchantId' => $merchantId,
    'merchantTransactionId' => uniqid('MT'),
    'merchantOrderId' => $orderId,
    'amount' => $amount,
    'redirectUrl' => 'https://kokanirishta.in/payment-success.php',
    'callbackUrl' => 'https://localhost/matrimony/payment-callback.php',
    'mobileNumber' => '7507760785',
    'paymentInstrument' => ['type' => 'PG_CHECKOUT']
];

$jsonPayload = json_encode($paymentData);
$encodedPayload = base64_encode($jsonPayload);

$payloadToHash = $encodedPayload . "/checkout/v2/pay" . $saltKey;
$xVerifyHeader = hash("sha256", $payloadToHash) . "###" . $saltIndex;

$requestBody = json_encode(['request' => $encodedPayload]);
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/pay",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $requestBody,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-VERIFY: $xVerifyHeader",
        "accept: application/json"
    ]
]);

$response = curl_exec($curl);
$error = curl_error($curl);
curl_close($curl);

if ($error) {
    echo "cURL Error: $error";
    file_put_contents('payment_error.log', "cURL Error: $error");
} else {
    $responseData = json_decode($response, true);
    if (isset($responseData['success']) && $responseData['success'] == true) {
        if (isset($responseData['data']['instrumentResponse']['redirectInfo']['url'])) {
            $redirectUrl = $responseData['data']['instrumentResponse']['redirectInfo']['url'];
            header("Location: $redirectUrl");
            exit();
        } else {
            echo "Payment initiation failed: Unable to retrieve redirect URL.";
            file_put_contents('payment_error.log', json_encode($responseData));
        }
    } else {
        echo "Payment initiation failed: " . ($responseData['message'] ?? 'Unknown error');
        file_put_contents('payment_error.log', json_encode($responseData));
    }
}
