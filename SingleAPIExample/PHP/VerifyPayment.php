<?php

$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\VerifyPaymentRequest([
    'installment_plan_number' => '{{InstallmentPlanNumber}}',
]);

try {
    $result = $apiInstance->installmentPlanVerifyPayment($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanVerifyPayment: ', $e->getMessage(), PHP_EOL;
}
