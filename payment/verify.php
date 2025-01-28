<?php 

require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

$api_key='rzp_test_POKNexOsripYs7';
$api_secret='w3WgArdW0I2yoitF80PGl8hS';

$api=new Api($api_key,$api_secret);

$success=true;
$error=null;
$payment_id=$_POST['razorpay_payment_id'];
$razorpay_signature=$_POST['razorpay_signature'];
try{
    $attributes=array(
        'razorpay_order_id'=>$_POST['razorpay_order_id'],
        'razorpay_payment_id'=>$payment_id,
        'razorpay_signature'=>$razorpay_signature
    );
    $api->utility->verifyPaymentSignature($attributes);   
}   catch(\Razorpay\Api\Errors\SignatureVerificationError $e){
    $success=false;
    $error='Razorpay Signature Verification failed';
}
if($success){
    $payment=$api->payment->fetch($payment_id);
    $amount_paid=$payment->amount/100;
    echo "Payment Successfull Amount: $amount_paid INR";
}
else{
    echo "Payment Failed! Error: $error";
}



?>