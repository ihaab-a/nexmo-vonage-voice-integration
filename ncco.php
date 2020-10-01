<?php

require_once './vendor/autoload.php';
include_once './config/database.php';
include_once './config/constants.php';

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE) or die("Could not connect : " . mysqli_error());
$db->set_charset('utf8');

use Vonage\Voice\NCCO\NCCO;
use Vonage\Voice\NCCO\Action\Talk;
use Vonage\Voice\NCCO\Action\Stream;
use Vonage\Voice\NCCO\Action\Record;
use Vonage\Voice\Webhook;

// log the answer into database;
$to = isset($_GET['to']) ? $_GET['to'] : '';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$uuid = isset($_GET['uuid']) ? $_GET['uuid'] : '';
$c_uuid = isset($_GET['conversation_uuid']) ? $_GET['conversation_uuid'] : '';
$details = $db->real_escape_string(json_encode($_GET));
$now = date('c');
$str_query = "INSERT INTO answers (number_from, number_to, uuid, conversation_uuid, details, created_at) 
            VALUES ('{$from}', '{$to}', '{$uuid}', '{$c_uuid}', '{$details}', '{$now}')";
$db->query($str_query);

$ncco = new NCCO();
//$record = new Record();
//$record->setEventWebhook(new Webhook( $baseUrl. 'recording.php', Webhook::METHOD_POST));
//$ncco->addAction($record);
$ncco->addAction(new Talk('Hey, do you like music?'));
$ncco->addAction(new Stream(MUSIC_FILE));
$ncco->addAction(new Talk('Thanks for your listening! Good day!'));

// manipulate NCCO to add record part.
// when generating record NCCO, it doesn't work with some auto-generated extra fields.
// so add minimum parameters manually.
$recordNCCO = [
    [
        "action"    => "record",
        "eventUrl"  => [ $baseUrl . 'recording.php' ],
        "eventMethod"   => "POST"
    ]
];
$restNCCO = $ncco->toArray();
$NCCOArray = array_merge($recordNCCO, $restNCCO);

// return NCCO as json
header('content-type: application/json');
echo json_encode($NCCOArray);
