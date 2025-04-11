<?php
function fetchAuthToken($clientId, $clientSecret)
{
    // Define the API endpoint
    $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token';

    // Prepare the POST fields
    $postFields = http_build_query([
        'client_id' => $clientId,
        'client_version' => '1',
        'client_secret' => $clientSecret,
        'grant_type' => 'client_credentials'
    ]);

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

    // Execute the request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Print the full response for debugging
        echo "Response: " . $response . "\n";
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "HTTP Status Code: " . $httpCode . "\n";
    }

    // Close cURL
    curl_close($ch);

    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Return the access token
    return $responseData['access_token'] ?? null;
}

// Usage
$clientId = 'TEST_M22T7JFO0FCUI_25041'; // Replace with your client ID
$clientSecret = 'MDAyZjU1NzQtNzI4Ni00OWYwLTljZjYtMjJiZWRjNzI1ZDAy'; // Replace with your client secret

$token = fetchAuthToken($clientId, $clientSecret);

if ($token) {
    echo "Access Token: " . $token;
} else {
    echo "Failed to fetch access token.";
}

// $jayParsedAry = [
// "merchantId" => 'TEST_M22T7JFO0FCUI_25041', // <THIS IS TESTING MERCHANT ID>
    // "merchantTransactionId" => rand(111111, 999999),
    // "merchantUserId" => 'MUID' . time(),
    // "amount" => (1 * 100),
    // "redirectUrl" => 'htttp://localhost/8000/redirect-url.php',
    // "redirectMode" => "POST", // GET, POST DEFINE REDIRECT RESPONSE METHOD,
    // "redirectUrl" => 'htttp://localhost/8000/redirect-url.php',
    // "mobileNumber" => "7507760785",
    // "paymentInstrument" => [
    // "type" => "PAY_PAGE"
    // ]
    // ];

    // $encode = json_encode($jayParsedAry);
    // $encoded = base64_encode($encode);
    // $key = 'MDAyZjU1NzQtNzI4Ni00OWYwLTljZjYtMjJiZWRjNzI1ZDAy'; // KEY
    // $key_index = 1; // KEY_INDEX
    // $string = $encoded . "/v1/oauth/token" . $key;
    // $sha256 = hash("sha256", $string);
    // $final_x_header = $sha256 . '###' . $key_index;

    // // $url = "https://api.phonepe.com/apis/hermes/pg/v1/pay"; <PRODUCTION URL>

        // $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token"; // <TESTING URL>

            // $headers = array(
            // "Content-Type: application/json",
            // "accept: application/json",
            // "X-VERIFY: " . $final_x_header,
            // );

            // $data = json_encode(['request' => $encoded]);

            // $curl = curl_init($url);

            // curl_setopt($curl, CURLOPT_URL, $url);
            // curl_setopt($curl, CURLOPT_POST, true);
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            // $resp = curl_exec($curl);
            // print_r($resp);
            // curl_close($curl);

            // $response = json_decode($resp);

            // header('Location:' . $response->data->instrumentResponse->redirectInfo->url);