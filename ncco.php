<?php

$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
//$baseUrl = $http . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
$baseUrl = "http://ec2-3-12-163-249.us-east-2.compute.amazonaws.com/test/";

require_once './vendor/autoload.php';

// Pranker App
define('API_KEY', '8e544a8f');
define('API_SECRET', 'K9vG1KjTOTW1AeDM');
define('APP_ID', '86ccdaa2-f61f-4678-91b4-c7b99c19bafe');
define('PRIVATE_KEY', 'private_oni.key');
define('MUSIC_FILE', $baseUrl . 'music/bensound-adventure.mp3');

use Vonage\Voice\NCCO\NCCO;
use Vonage\Voice\NCCO\Action\Talk;
use Vonage\Voice\NCCO\Action\Stream;
use Vonage\Voice\NCCO\Action\Record;
use Vonage\Voice\Webhook;


$ncco = new NCCO();
$record = new Record();
$record->setEventWebhook(new Webhook( $baseUrl. 'recording.php', Webhook::METHOD_POST));
$ncco->addAction($record);
$ncco->addAction(new Talk('Hey, do you like music?'));
$ncco->addAction(new Stream(MUSIC_FILE));
$ncco->addAction(new Talk('Thanks for your listening! Good day!'));

echo json_encode($ncco);
