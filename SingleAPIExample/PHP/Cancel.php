<?php
$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\CancelInstallmentPlanRequest([
    'installment_plan_number' => '{{InstallmentPlanNumber}}',
    'refund_under_cancelation' => 'OnlyIfAFullRefundIsPossible'
]);

try {
    $result = $apiInstance->installmentPlanCancel($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanCancel: ', $e->getMessage(), PHP_EOL;
}
