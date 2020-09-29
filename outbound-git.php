<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 4:52 PM
 */


$number_to = "8618640211091";
$number_from = "12012790554";
//define('API_KEY', '8e544a8f');
//define('API_SECRET', 'K9vG1KjTOTW1AeDM');
//define('APP_ID', 'b0b4f038-e4e3-48ce-a3a4-badb8770cbb5');
//define('PRIVATE_KEY', 'private_oni.key');


// Pranker App
define('API_KEY', '8e544a8f');
define('API_SECRET', 'K9vG1KjTOTW1AeDM');
define('APP_ID', '86ccdaa2-f61f-4678-91b4-c7b99c19bafe');
define('PRIVATE_KEY', 'private_oni.key');


require_once './vendor/autoload.php';
use Vonage\Voice\NCCO\NCCO;


$basic = new \Vonage\Client\Credentials\Basic(API_KEY, API_SECRET);
$keypair = new \Vonage\Client\Credentials\Keypair(
    file_get_contents(PRIVATE_KEY),
    APP_ID
);
$client = new \Vonage\Client(new \Vonage\Client\Credentials\Container($basic, $keypair));

$outboundCall = new \Vonage\Voice\OutboundCall(
    new \Vonage\Voice\Endpoint\Phone($number_to),
    new \Vonage\Voice\Endpoint\Phone($number_from)
);

$outboundCall->setAnswerWebhook(
    new \Vonage\Voice\Webhook(
        'https://developer.nexmo.com/ncco/tts.json',
        \Vonage\Voice\Webhook::METHOD_GET
    )
);

$ncco = new NCCO();
$ncco->addAction(new \Vonage\Voice\NCCO\Action\Talk('This is a text to speech call from Nexmo'));
$outboundCall->setNCCO($ncco);

$response = $client->voice()->createOutboundCall($outboundCall);

var_dump($response);