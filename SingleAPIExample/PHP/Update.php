<?php

$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\UpdateInstallmentPlanRequest([
    'installment_plan_number' => '{{InstallmentPlanNumber}}',
    'plan_data' => [
        "RefOrderNumber" => "XYZb",
        "ExtendedParams" => [
            "AnyParameterKey1" => " AnyParameterVal1",
            "AnyParameterKey2" => " AnyParameterVal2"
        ]
    ]
]);

try {
    $result = $apiInstance->installmentPlanUpdate($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanUpdate: ', $e->getMessage(), PHP_EOL;
}
