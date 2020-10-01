<?php

/**
 * Trigger an outbound call from Nexmo number.
*/

require_once './vendor/autoload.php';
require_once './config/constants.php';

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\Client\Credentials\Keypair;
use Vonage\Voice\Endpoint\Phone;
use Vonage\Voice\OutboundCall;
use Vonage\Voice\Webhook;

// initialize Nexmo client instance
$basic = new Basic(API_KEY, API_SECRET);
$keypair = new Keypair(
    file_get_contents(PRIVATE_KEY),
    APP_ID
);
$client = new Client(new Container($basic, $keypair));

// create OutboundCall instance with two numbers
$outboundCall = new OutboundCall(
    new Phone(NUMBER_TO),
    new Phone(NUMBER_FROM)
);

// receive NCCO when callee replies to the call
$outboundCall->setAnswerWebhook(
    new Webhook(
        $baseUrl . 'ncco.php',
        Webhook::METHOD_GET
    )
);

// set the event webhook dynamically.
$outboundCall->setEventWebhook(
    new Webhook($baseUrl . 'event.php',
        Webhook::METHOD_POST)
);
$response = $client->voice()->createOutboundCall($outboundCall);
print_r($response);