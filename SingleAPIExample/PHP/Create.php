<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://{{url}}/api/InstallmentPlan/Create?format=json",
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
            "Amount": {"Value": 55, "CurrencyCode":"USD"},
            "NumberOfInstallments": 3,
            "RefOrderNumber": "XYZ",
            "AutoCapture": true
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
        "CreditCardDetails": { 
            "CardCvv": "123", 
            "CardHolderFullName": "John Smith",
            "CardNumber": "4111111111111111", 
            "CardExpYear": "2019", 
            "CardExpMonth": "8"
        },
        "PlanApprovalEvidence": {
            "AreTermsAndConditionsApproved": "True"
        }
    }',
    CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
