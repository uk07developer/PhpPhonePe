<?php
function fetchAutoPayTransactions($merchantId, $merchantKey, $startDate, $endDate) {
    $url = "https://api.phonepe.com/apis/merchant/v1/autopay/transactions";  // Replace with the correct endpoint

    $data = array(
        "merchantId" => $merchantId,
        "startDate" => $startDate,
        "endDate" => $endDate
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
$response = fetchAutoPayTransactions("your_merchant_id", "your_merchant_key", "2023-01-01", "2023-12-31");
echo $response;
?>