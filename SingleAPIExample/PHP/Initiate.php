<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://{{url}}/api/InstallmentPlan/Initiate?format=json",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => '{
        "RequestHeader": {
            "SessionId": "{{SessionId}}",
            "ApiKey": "{{ApiKey}}"
        },
        "PlanData": {
            "Amount": {"Value": 50,"CurrencyCode": "USD"},
            "NumberOfInstallments": 3,    
            "RefOrderNumber": "012AB",
            "AutoCapture": true,
            "ExtendedParams": {
            "AnyParameterKey1": "AnyParameterVal1",
            "AnyParameterKey2": "AnyParameterVal2"
            }
        },
        "BillingAddress": {
            "AddressLine": "260 Madison Avenue.",
            "AddressLine2": "Appartment 1",
            "City": "New York",
            "State": "NY",
            "Country": "USA",
            "Zip": "10016"
        },
        "ConsumerData": {
            "FullName": "John Smith",
            "Email": "JohnS@splitit.com",
            "PhoneNumber": "1-844-775-4848",
            "CultureName": "en-us"
        },
        "PaymentWizardData": {
            "RequestedNumberOfInstallments": "2,3,4"
        },
        "RedirectUrls": {
            "Succeeded": "https://www.success.com/",
            "Failed": "https://www.failed.com/",
            "Canceled": "https://www.canceled.com/"
        },
        "EventsEndpoints": {
            "CreateSucceeded": "https://www.async-success.com/"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
