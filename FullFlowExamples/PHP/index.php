<?php

require_once(__DIR__ . '/PayWithCCToken.php');
$obj = new PayWithCCToken();

$obj->Login('MobikasaAPI', 'zZ5UxpF4');
$obj->Initiate();
//$obj->VerifyPayment('44132834711004212058');
//$obj->StartInstallments('78485474250326552485');

