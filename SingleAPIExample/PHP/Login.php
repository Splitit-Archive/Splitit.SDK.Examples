<?php

$apiInstance = new \SplititSdkClient\Api\LoginApi(\SplititSdkClient\Configuration::sandbox());

$request = new \SplititSdkClient\Model\LoginRequest([
    'user_name' => '{{UserName}}',
    'password' => '{{Password}}'
]);

try {
    $result = $apiInstance->loginPost($request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LoginApi->loginPost: ', $e->getMessage(), PHP_EOL;
}
