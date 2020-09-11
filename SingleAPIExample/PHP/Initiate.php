<?php
$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\InitiateInstallmentPlanRequest([
    'plan_data' => [
        'Amount' => [
            'Value' => 50,
            'CurrencyCode' => 'USD',
        ],
        'NumberOfInstallments' => 3,
        'RefOrderNumber' => '012AB',
        'AutoCapture' => true,
        'ExtendedParams' => [
            'AnyParameterKey1' => 'AnyParameterVal1',
            'AnyParameterKey2' => 'AnyParameterVal2',
        ],
    ],
    'billing_address' => [
        'AddressLine' => '260 Madison Avenue.',
        'AddressLine2' => 'Appartment 1',
        'City' => 'New York',
        'State' => 'NY',
        'Country' => 'USA',
        'Zip' => '10016',
    ],
    'consumer_data' => [
        'FullName' => 'John Smith',
        'Email' => 'JohnS@splitit.com',
        'PhoneNumber' => '1-844-775-4848',
        'CultureName' => 'en-us',
    ],
    'payment_wizard_data' => [
        'RequestedNumberOfInstallments' => '2,3,4',
    ],
    'redirect_urls' => [
        'Succeeded' => 'https://www.success.com/',
        'Failed' => 'https://www.failed.com/',
        'Canceled' => 'https://www.canceled.com/',
    ],
    'events_endpoints' => [
        'CreateSucceeded' => 'https://www.async-success.com/',
    ],
]);

try {
    $result = $apiInstance->installmentPlanInitiate($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanInitiate: ', $e->getMessage(), PHP_EOL;
}
