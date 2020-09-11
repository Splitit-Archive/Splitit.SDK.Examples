<?php

$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\RefundPlanRequest([
    'installment_plan_number' => '{{InstallmentPlanNumber}}',
    'amount' => ["Value" => "1500"],
    'refund_strategy' => 'FutureInstallmentsFirst',
]);

try {
    $result = $apiInstance->installmentPlanRefund($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanRefund: ', $e->getMessage(), PHP_EOL;
}
