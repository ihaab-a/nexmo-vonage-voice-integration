<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 4:52 PM
 */

$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$baseUrl = $http . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';


require_once './vendor/autoload.php';
//$number_to = "8618640211091";
$number_to = "15612239473";
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
use Vonage\Voice\NCCO\NCCO;
use Vonage\Voice\OutboundCall;
use Vonage\Voice\NCCO\Action\Talk;
use Vonage\Voice\NCCO\Action\Stream;
use Vonage\Voice\NCCO\Action\Record;
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
        'https://developer.nexmo.com/ncco/tts.json',
        Webhook::METHOD_GET
    )
);

$outboundCall->setEventWebhook(
    new Webhook($baseUrl . 'test/event.php',
        Webhook::METHOD_POST)
);

$ncco = new NCCO();
$record = new Record();
$record->setEventWebhook(new Webhook( $baseUrl. 'test/recording.php', Webhook::METHOD_POST));
$ncco->addAction($record);
$ncco->addAction(new Talk('Hey, do you like music?'));
$ncco->addAction(new Stream(MUSIC_FILE));
$ncco->addAction(new Talk('Thanks for your listing! Good day!'));
$outboundCall->setNCCO($ncco);

$response = $client->voice()->createOutboundCall($outboundCall);
//echo $response->getUuid();
//$client->voice()->streamAudio($response->getUuid(), 'https://nexmo-community.github.io/ncco-examples/assets/voice_api_audio_streaming.mp3');

print_r($response);