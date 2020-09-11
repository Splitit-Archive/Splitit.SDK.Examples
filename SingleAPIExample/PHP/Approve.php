<?php

$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\ApproveInstallmentPlanRequest([
    'installment_plan_number' => '{{InstallmentPlanNumber}}'
]);

try {
    $result = $apiInstance->installmentPlanApprove($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanApprove: ', $e->getMessage(), PHP_EOL;
}
