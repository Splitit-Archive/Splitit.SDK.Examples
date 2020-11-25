<?php

// TODO: set a path to your autoload.php file
require_once(__DIR__ . '/vendor/autoload.php');

require_once(__DIR__ . '/PaymentForm_3D.php');
require_once(__DIR__ . '/PaymentForm_BasicFlow.php');
require_once(__DIR__ . '/PaymentForm_Deposit_FutureChargeDate.php');
require_once(__DIR__ . '/PaymentForm_iframe.php');
require_once(__DIR__ . '/PaymentForm_PayWithCCToken.php');
require_once(__DIR__ . '/PaymentForm_PendingShipment.php');

\SplititSdkClient\Configuration::sandbox()->setApiKey('YOUR_SANDBOX_API_KEY');

$username = 'YOUR_SANDBOX_API_USERNAME';
$password = 'YOUR_SANDBOX_API_PASSWORD';

$ccToken = new PaymentForm_PayWithCCToken();
$ccToken->Login($username, $password);
$ccToken->Initiate();

$payment3D = new PaymentForm_3D();
$payment3D->Login($username, $password);
$payment3D->Initiate();

$paymentBasicFlow = new PaymentForm_BasicFlow();
$paymentBasicFlow->Login($username, $password);
$paymentBasicFlow->Initiate();

$paymentDeposit = new PaymentForm_Deposit_FutureChargeDate();
$paymentDeposit->Login($username, $password);
$paymentDeposit->Initiate();

$paymentIframe = new PaymentForm_iframe();
$paymentIframe->Login($username, $password);
$paymentIframe->Initiate();

$paymentPendingShipment = new PaymentForm_PendingShipment();
$paymentPendingShipment->Login($username, $password);
$paymentPendingShipment->Initiate();
