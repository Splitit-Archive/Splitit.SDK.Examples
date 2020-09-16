<?php

$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\StartInstallmentsRequest([
    'installment_plan_number' => '{{InstallmentPlanNumber}}',
]);

try {
    $result = $apiInstance->installmentPlanStartInstallments($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanStartInstallments: ', $e->getMessage(), PHP_EOL;
}
