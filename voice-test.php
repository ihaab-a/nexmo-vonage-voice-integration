<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 4:52 PM
 */


//$number_to = "8618640211091";
$number_to = "8618102437215";
$number_from = "12013316626";
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

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\Client\Credentials\Keypair;
use Vonage\Voice\Endpoint\Phone;
use Vonage\Voice\NCCO\NCCO;
use Vonage\Voice\OutboundCall;
use Vonage\Voice\NCCO\Action\Talk;
use Vonage\Voice\Webhook;


$basic = new Basic(API_KEY, API_SECRET);
$keypair = new Keypair(
    file_get_contents(PRIVATE_KEY),
    APP_ID
);
//$client = new Client(new Container($basic, $keypair));
$client = new Client($keypair);

$ncco = [
    [
        'action' => 'talk',
        'voiceName' => 'Joey',
        'text' => 'This is a text-to-speech test message.'
    ]
];

$call = new Vonage\Call\Call();

$outboundCall = new OutboundCall(
    new Phone($number_to),
    new Phone($number_from)
);

$call->setTo('8618102437215')
    ->setFrom('12013316626')
    ->setNcco($ncco);

$response = $client->calls()->create($call);
print_r($response); exit;

$outboundCall->setAnswerWebhook(
    new Webhook(
        'https://developer.nexmo.com/ncco/tts.json',
        Webhook::METHOD_GET
    )
);

$outboundCall->setEventWebhook(
    new Webhook('http://ec2-3-12-163-249.us-east-2.compute.amazonaws.com/test/event.php',
        Webhook::METHOD_POST)
);

$ncco = new NCCO();
$ncco->addAction(new Talk('This is a text to speech call from Nexmo'));
$outboundCall->setNCCO($ncco);

$response = $client->voice()->createOutboundCall($outboundCall);

print_r($response);