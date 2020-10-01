<?php

//$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
////$baseUrl = $http . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
//$baseUrl = "http://ec2-3-12-163-249.us-east-2.compute.amazonaws.com/test/";

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
use Vonage\Voice\Endpoint\Phone;
use Vonage\Voice\NCCO\Action\Conversation;
use Vonage\Voice\NCCO\Action\Connect;

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

$record = new Record();
$record->setEventWebhook(new Webhook( $baseUrl. 'recording.php', Webhook::METHOD_POST));
//$record->setChannels(2);
//$connect = new Connect(new Phone(NUMBER_TO));
//$connect->setFrom(NUMBER_FROM);
//$ncco->addAction($connect);
$ncco->addAction($record);

// conversation
//$conversation = new Conversation("Recording " . time());
//$conversation->setRecord(true);
//$conversation->setEventWebhook(new Webhook($baseUrl. 'recording.php', Webhook::METHOD_POST));
//$ncco->addAction($conversation);

//$ncco->addAction($record);
$ncco->addAction(new Talk('Hey, do you like music?'));
$ncco->addAction(new Stream(MUSIC_FILE));
$ncco->addAction(new Talk('Thanks for your listening! Good day!'));

header('content-type: application/json');
//echo json_encode($ncco);

echo '[{"action":"record","eventUrl":["http:\/\/50ea3a69679c.ngrok.io\/045-nexmo\/recording.php"],"eventMethod":"POST"},{"action":"talk","text":"Hey, do you like music?"},{"action":"stream","streamUrl":["http:\/\/50ea3a69679c.ngrok.io\/045-nexmo\/music\/bensound-adventure.mp3"]},{"action":"talk","text":"Thanks for your listening! Good day!"}]';