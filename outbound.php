<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 4:52 PM
 */


$number_to = "8618640211091";
$number_from = "12012790554";
define('API_KEY', '8e544a8f');
define('API_SECRET', 'K9vG1KjTOTW1AeDM');

require_once './vendor/autoload.php';


//try {
//    $keypair = new Vonage\Client\Credentials\Keypair(
//        file_get_contents('private_oni.key'),
//        'b0b4f038-e4e3-48ce-a3a4-badb8770cbb5'
//    );
//$client = new Vonage\Client($keypair);

    $client = new Vonage\Client(new Vonage\Client\Credentials\Basic(API_KEY, API_SECRET));



    $outboundCall = new \Vonage\Voice\OutboundCall(
        new \Vonage\Voice\Endpoint\Phone($number_to),
        new \Vonage\Voice\Endpoint\Phone($number_from)
    );

//    $outboundCall->setAnswerWebhook(
//        new \Vonage\Voice\Webhook(
//            'http://ec2-3-12-163-249.us-east-2.compute.amazonaws.com/test/answer.php',
//            \Vonage\Voice\Webhook::METHOD_GET
//        )
//    );

    $response = $client->voice()->createOutboundCall($outboundCall);

    var_dump($response);
//}
//catch (Exception $e) {
//    throw Error($e);
//    //var_dump($e->getMessage());
//}