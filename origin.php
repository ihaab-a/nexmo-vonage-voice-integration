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
$baseUrl = "http://952a5d2f3352.ngrok.io/045-nexmo/";

define('PRIVATE_KEY', './private.key');
define('APP_ID', '0f396283-55a8-4dc3-9dfa-075d93219bd9');

$keypair = new Keypair(
    file_get_contents("private.key"),
    "0f396283-55a8-4dc3-9dfa-075d93219bd9"
);
$client = new Client($keypair);

$outboundCall = new OutboundCall(
    new Phone("40743932222"),
    new Phone("40371703012")
);

$outboundCall
    ->setAnswerWebhook(
        new Webhook(
            $baseUrl . 'ncco.php',
            Webhook::METHOD_GET
        ))
    ->setEventWebhook(
        new Webhook(
            $baseUrl . 'event.php',
            Webhook::METHOD_POST
        ));
$response = $client->voice()->createOutboundCall($outboundCall);

print_r($response);