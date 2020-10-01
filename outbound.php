<?php

$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
//$baseUrl = $http . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
$baseUrl = "http://ec2-3-12-163-249.us-east-2.compute.amazonaws.com/test/";

require_once './vendor/autoload.php';
$number_to = "12064531225";
//$number_to = "15612239473";
$number_from = "12013316626";
// canadian
//$number_to = "14382266378";
//$number_from = "12044106030";
//define('API_KEY', '8e544a8f');
//define('API_SECRET', 'K9vG1KjTOTW1AeDM');
//define('APP_ID', 'b0b4f038-e4e3-48ce-a3a4-badb8770cbb5');
//define('PRIVATE_KEY', 'private_oni.key');

// Pranker App
define('API_KEY', '8e544a8f');
define('API_SECRET', 'K9vG1KjTOTW1AeDM');
define('APP_ID', '86ccdaa2-f61f-4678-91b4-c7b99c19bafe');
define('PRIVATE_KEY', 'private_oni.key');
define('MUSIC_FILE', $baseUrl . 'music/bensound-adventure.mp3');

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\Client\Credentials\Keypair;
use Vonage\Voice\Endpoint\Phone;
use Vonage\Voice\OutboundCall;
use Vonage\Voice\Webhook;


$basic = new Basic(API_KEY, API_SECRET);
$keypair = new Keypair(
    file_get_contents(PRIVATE_KEY),
    APP_ID
);
$client = new Client(new Container($basic, $keypair));
$outboundCall = new OutboundCall(
    new Phone($number_to),
    new Phone($number_from)
);

$outboundCall->setAnswerWebhook(
    new Webhook(
        $baseUrl . 'ncco.php',
        Webhook::METHOD_GET
    )
);
$outboundCall->setEventWebhook(
    new Webhook($baseUrl . 'event.php',
        Webhook::METHOD_POST)
);
$response = $client->voice()->createOutboundCall($outboundCall);
print_r($response);