<?php

require dirname(dirname(__DIR__)) . '/libraries/paypal/BillingPlan.php';
require dirname(dirname(__DIR__)) . '/libraries/paypal/AgreementPlan.php';
require dirname(dirname(__DIR__)) . '/libraries/paypal/SinglePayment.php';
/*Suppress DateTime warnings, if not set already*/
date_default_timezone_set(@date_default_timezone_get());
/*Adding Error Reporting for understanding errors properly*/
error_reporting(E_ALL);
ini_set('display_errors', '1');