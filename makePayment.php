<?php
function initiatePayment($amount, $merchantId, $merchantKey, $callbackUrl, $orderId) {
    $url = "https://api.phonepe.com/apis/merchant/v1/initiatePayment";
    
    $data = array(
        "amount" => $amount,
        "merchantId" => $merchantId,
        "callbackUrl" => $callbackUrl,
        "orderId" => $orderId
    );
    
    $headers = array(
        "Content-Type: application/json",
        "X-VERIFY: " . hash_hmac('sha256', json_encode($data), $merchantKey)
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Usage
$response = initiatePayment(10000, "your_merchant_id", "your_merchant_key", "your_callback_url", "order12345");
echo $response;
?>