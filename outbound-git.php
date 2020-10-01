<?php

require_once './vendor/autoload.php';
require_once './config/constants.php';

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
    new Phone(NUMBER_TO),
    new Phone(NUMBER_FROM)
);

$outboundCall->setAnswerWebhook(
    new Webhook(
        'https://developer.nexmo.com/ncco/tts.json',
        Webhook::METHOD_GET
    )
);

$outboundCall->setEventWebhook(
    new Webhook($baseUrl . 'event.php',
        Webhook::METHOD_POST)
);

$ncco = new NCCO();
$record = new Record();
$record->setEventWebhook(new Webhook( $baseUrl. 'recording.php', Webhook::METHOD_POST));
$ncco->addAction($record);
$ncco->addAction(new Talk('Hey, do you like music?'));
//$ncco->addAction(new Stream(MUSIC_FILE));
//$ncco->addAction(new Talk('Thanks for your listening! Good day!'));
$outboundCall->setNCCO($ncco);

$response = $client->voice()->createOutboundCall($outboundCall);
//echo $response->getUuid();
//$client->voice()->streamAudio($response->getUuid(), 'https://nexmo-community.github.io/ncco-examples/assets/voice_api_audio_streaming.mp3');

print_r($response);