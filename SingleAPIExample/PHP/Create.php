<?php

$sessionId = '{{SessionID}}';
\SplititSdkClient\Configuration::sandbox()->setApiKey('{{APIKey}}');

$apiInstance = new SplititSdkClient\Api\InstallmentPlanApi(\SplititSdkClient\Configuration::sandbox(), $sessionId);

$request = new \SplititSdkClient\Model\CreateInstallmentPlanRequest([
    'installment_plan_number' => '{{InstallmentPlanNumber}}',
    'plan_data' => [
        'Amount' => [
            'Value' => 55,
            'CurrencyCode' => 'USD',
        ],
        'NumberOfInstallments' => 3,
        'RefOrderNumber' => 'XYZ',
        'AutoCapture' => true,
    ],
    'consumer_data' => [
        'FullName' => 'John Smith',
        'Email' => 'JohnS@splitit.com',
        'PhoneNumber' => '1-844-775-4848',
        'CultureName' => 'en-us',
    ],
    'billing_address' => [
        'AddressLine' => '260 Madison Avenue.',
        'AddressLine2' => 'Appartment 1',
        'City' => 'New York',
        'State' => 'NY',
        'Country' => 'USA',
        'Zip' => '10016',
    ],
    'credit_card_details' => [
        'CardCvv' => '123',
        'CardHolderFullName' => 'John Smith',
        'CardNumber' => '4111111111111111',
        'CardExpYear' => '2019',
        'CardExpMonth' => '8',
    ],
    'plan_approval_evidence' => [
        'AreTermsAndConditionsApproved' => 'True',
    ]
]);

try {
    $result = $apiInstance->installmentPlanCreate($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling InstallmentPlanApi->installmentPlanCreate: ', $e->getMessage(), PHP_EOL;
}
