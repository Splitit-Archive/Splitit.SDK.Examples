<?php
$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\GetInstallmentsPlanSearchCriteriaRequest([
    'query_criteria' => [
        "InstallmentPlanNumber" => "{{InstallmentPlanNumber}}"
    ],
]);

try {
    $result = $apiInstance->installmentPlanGet($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanGet: ', $e->getMessage(), PHP_EOL;
}
