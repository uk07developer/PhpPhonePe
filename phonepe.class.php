<?php
class PhonePeAPI {
    private $baseUrl = "https://api.phonepe.com/apis/merchant/v1/";

    private function executeCurl($endpoint, $data, $headers) {
        $url = $this->baseUrl . $endpoint;
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    public function autoPay($amount, $merchantId, $merchantKey, $callbackUrl, $orderId, $recurringFrequency) {
        $endpoint = "autoPay";

        $data = array(
            "amount" => $amount,
            "merchantId" => $merchantId,
            "callbackUrl" => $callbackUrl,
            "orderId" => $orderId,
            "recurringFrequency" => $recurringFrequency
        );

        $headers = array(
            "Content-Type: application/json",
            "X-VERIFY: " . hash_hmac('sha256', json_encode($data), $merchantKey)
        );

        return $this->executeCurl($endpoint, $data, $headers);
    }

    public function fetchAutoPayTransactions($merchantId, $merchantKey, $startDate, $endDate) {
        $endpoint = "autopay/transactions";

        $data = array(
            "merchantId" => $merchantId,
            "startDate" => $startDate,
            "endDate" => $endDate
        );

        $headers = array(
            "Content-Type: application/json",
            "X-VERIFY: " . hash_hmac('sha256', json_encode($data), $merchantKey)
        );

        return $this->executeCurl($endpoint, $data, $headers);
    }

    public function initiatePayment($amount, $merchantId, $merchantKey, $callbackUrl, $orderId) {
        $endpoint = "initiatePayment";

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

        return $this->executeCurl($endpoint, $data, $headers);
    }

    public function refundPayment($merchantId, $transactionId, $amount, $merchantKey) {
        $endpoint = "refund";

        $data = array(
            "merchantId" => $merchantId,
            "transactionId" => $transactionId,
            "amount" => $amount
        );

        $headers = array(
            "Content-Type: application/json",
            "X-VERIFY: " . hash_hmac('sha256', json_encode($data), $merchantKey)
        );

        return $this->executeCurl($endpoint, $data, $headers);
    }

    public function verifyPayment($merchantId, $transactionId, $merchantKey) {
        $endpoint = "paymentStatus";

        $data = array(
            "merchantId" => $merchantId,
            "transactionId" => $transactionId
        );

        $headers = array(
            "Content-Type: application/json",
            "X-VERIFY: " . hash_hmac('sha256', json_encode($data), $merchantKey)
        );

        return $this->executeCurl($endpoint, $data, $headers);
    }
}

// Usage example:
$phonePeAPI = new PhonePeAPI();

// Example 1: AutoPay
$response = $phonePeAPI->autoPay(10000, "your_merchant_id", "your_merchant_key", "your_callback_url", "order12345", "MONTHLY");
echo $response;

// Example 2: Fetch AutoPay Transactions
$response = $phonePeAPI->fetchAutoPayTransactions("your_merchant_id", "your_merchant_key", "2023-01-01", "2023-12-31");
echo $response;

// Example 3: Initiate Payment
$response = $phonePeAPI->initiatePayment(10000, "your_merchant_id", "your_merchant_key", "your_callback_url", "order12345");
echo $response;

// Example 4: Refund Payment
$response = $phonePeAPI->refundPayment("your_merchant_id", "transaction12345", 5000, "your_merchant_key");
echo $response;

// Example 5: Verify Payment
$response = $phonePeAPI->verifyPayment("your_merchant_id", "transaction12345", "your_merchant_key");
echo $response;

?>
