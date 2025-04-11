<?php
include '../connect.php';
session_start();

$st = $_SESSION['status'];
$fn = $_SESSION['username'];
$phn = $_SESSION['phone'];
$em = $_SESSION['email'];
$id = $_SESSION['user_id'];
// Replace these with your actual PhonePe API credentials
$apiKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
$merchantId = 'PGTESTPAYUAT';
$redirectUrl = 'payment-success.php';
// Prepare the payment request data (you should customize this)
$paymentData = array(
    'merchantId' => $merchantId,
    'merchantTransactionId' => "ORDER_TRANSACTION_UNIQUE_ID",
    "merchantUserId" => $id,
    'amount' => 1000, // Amount in paisa (10 INR)
    'redirectUrl' => "https://webhook.site/redirect-url",
    'redirectMode' => "POST",
    'callbackUrl' => "https://webhook.site/redirect-url",
    "merchantOrderId" => "1",
    "mobileNumber" => $phn,
    "message" => "Order description",
    "email" => $em,
    "shortName" => $fn,
    "paymentInstrument" => array(
        "type" => "PAY_PAGE",
    )
);

$jsonencode = json_encode($paymentData);
$payloadMain = base64_encode($jsonencode);

$salt_index = 1; //key index 1
$payload = $payloadMain . "/pg/v1/pay" . $apiKey;
$sha256 = hash("sha256", $payload);
$final_x_header = $sha256 . '###' . $salt_index;
$request = json_encode(array('request' => $payloadMain));

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $request,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "X-VERIFY: " . $final_x_header,
        "accept: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $res = json_decode($response);
    print_r($res);
    if (isset($res->success) && $res->success == '1') {
        $paymentCode = $res->code;
        $paymentMsg = $res->message;
        $payUrl = $res->data->instrumentResponse->redirectInfo->url;

        header('Location:' . $payUrl);
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Profile Status</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <style>
        .message-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message-container h1 {
            color: #ff9800;
            /* Orange color */
        }

        .message-container p {
            color: #555;
            /* Darker grey for text */
        }

        .message-container a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .message-container a:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }
    </style>
    <link rel="icon" href="logo.png" type="image/x-icon">

</head>

<body>
    <header>
        <?php include '../navbar.php'; ?>
    </header>
    <main>

        <?php
        if ($st == 0) {
            echo '<section class="container" style="text-align: center;">
    <div class="message-container w-50 mt-5 container" style="margin: 0 auto;">
        <h1>Profile Under Verification</h1>
        <p>Your profile is currently under verification. Please check back later.</p>
    </div>
</section>
';
            //             echo '<form>
            //   <a href="https://payments.cashfree.com/forms/kokan" target="_parent">
            //     <div class="button-container" style="background: #000">
            //       <div>
            //         <img src="https://cashfreelogo.cashfree.com/cashfreepayments/logosvgs/Group_4355.svg" alt="logo" class="logo-container">
            //       </div>
            //       <div class="text-container">
            //         <div style="font-family: Arial; color: #fff; margin-bottom: 5px; font-size: 14px;">
            //           Pay Now
            //         </div>
            //         <div style="font-family: Arial; color: #fff; font-size: 10px;">
            //             <span>Powered By Cashfree</span>
            //             <img src="https://cashfreelogo.cashfree.com/cashfreepayments/logosvgs/Group_4355.svg" alt="logo" class="seconday-logo-container">
            //         </div>
            //       </div>
            //     </div>
            //   </a>
            //  <style>
            //   .button-container{
            //       border: 1px solid black;
            //       border-radius: 15px;
            //       display: flex;
            //       padding: 10px;
            //       width: fit-content;
            //       cursor: pointer;
            //   }
            //   .text-container{
            //       display: flex;
            //       flex-direction: column;
            //       align-items: center;
            //       margin-left: 10px;
            //       justify-content: center;
            //       margin-right: 10px;
            //   }
            //   .logo-container{
            //       width: 40px;
            //       height: 40px;
            //   }
            //   .seconday-logo-container{
            //     width: 16px;
            //     height: 16px;
            //     vertical-align: middle;
            //   }
            //   a{
            //     text-decoration:none;
            //   }
            // </style>
            // </form>';
        } else if ($st == 1 || $st == 2 || $st == 3) {
            echo '<script>window.location.href = "../home/";
</script>';
        }
        ?>


    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>