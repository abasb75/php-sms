<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './vendor/autoload.php';

use Abasb75\PhpSms\SMS; 

$sms = new SMS('Fake',[]);

echo $sms->send('09015827703','sms body');

