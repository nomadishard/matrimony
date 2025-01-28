<?php 
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api_key='rzp_test_POKNexOsripYs7';
$api_secret='w3WgArdW0I2yoitF80PGl8hS';

$api=new Api($api_key,$api_secret);

$order=$api->order->create([
    'amount'=>1000,
    'currency'=>'INR',
    'receipt'=>'order_receipt_12asa3'
]);
$order_id=$order->id;

$callback_url="http://localhost:8000/success.html";

echo '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>';

echo '<button onclick="startPayment()">Pay with Razorpay</button>';

echo '<script>
    function startPayment(){
    var options={
    key:"'.$api_key.'",
    amount:"'.$order->amount.'",
    currency:"'.$order->currency.'",
    name:"Kokani Rishta",
    description:"Payment for Registeration fees",
    image:"../logo.png",
    order_id:"'.$order_id.'",
    theme:
    {"color":"738276"},
    callback_url:"'.$callback_url.'",
};
var rzp=new Razorpay(options);
rzp.open();
}
</script>';
?>