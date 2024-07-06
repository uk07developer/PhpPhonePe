<?php
function verifyPayment($merchantId, $transactionId, $merchantKey) {
    $url = "https://api.phonepe.com/apis/merchant/v1/paymentStatus";
    
    $data = array(
        "merchantId" => $merchantId,
        "transactionId" => $transactionId
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
$response = verifyPayment("your_merchant_id", "transaction12345", "your_merchant_key");
echo $response;
?>