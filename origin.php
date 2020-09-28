<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 1:46 AM
 */


use Vonage\Client;
use Vonage\Voice\Webhook;
use Vonage\Voice\OutboundCall;
use Vonage\Voice\Endpoint\Phone;
use Vonage\Client\Credentials\Keypair;

require_once './vendor/autoload.php';

define('PRIVATE_KEY', './private_oni.key');
define('APP_ID', 'b0b4f038-e4e3-48ce-a3a4-badb8770cbb5');

$keypair = new Keypair(
    file_get_contents("private.key"),
    "0f396283-55a8-4dc3-9dfa-075d93219bd9"
);
$client = new Client($keypair);

$outboundCall = new OutboundCall(
    new Phone("8618640211091"),
    new Phone("12012790554")
);
$outboundCall->setAnswerWebhook(
    new Webhook(
        'http://178.33.224.24:8000/ncco',
        Webhook::METHOD_GET
    )
    )->setEventWebhook(
    new Webhook('http://178.33.224.24:8000/event', Webhook::METHOD_POST)
);
$response = $client->voice()->createOutboundCall($outboundCall);

print_r($response);