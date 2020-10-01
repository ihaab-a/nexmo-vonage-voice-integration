<?php

require_once './vendor/autoload.php';
include_once './config/database.php';
include_once './config/constants.php';

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE) or die("Could not connect : " . mysqli_error());
$db->set_charset('utf8');

/**
 * POST Payload:
 * {'conversation_uuid': 'CON-ddddaaaa-bbbb-cccc-dddd-0123456789de',
 *   end_time': '2018-08-10T11:19:31Z',
 *   recording_url': 'https://api.nexmo.com/v1/files/aaaaaaaa-bbbb-cccc-dddd-0123456789ab',
 *   recording_uuid': 'ccccaaaa-dddd-cccc-dddd-0123456789ab',
 *   size': 162558,
 *   start_time': '2018-08-10T11:18:51Z',
 *   timestamp': '2018-08-10T11:19:31.744Z'}
 *  1.2.3.4 - - [10/Aug/2018 11:19:31] "POST /webhooks/recordings HTTP/1.1" 200 -
*/

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\Client\Credentials\Container;
use Vonage\Client\Credentials\Keypair;

// initialize Nexmo client instance.
$basic = new Basic(API_KEY, API_SECRET);
$keypair = new Keypair(
    file_get_contents(PRIVATE_KEY),
    APP_ID
);
$client = new Client(new Container($basic, $keypair));

// analyze request data.
$request_array = json_decode(file_get_contents('php://input'), true);
$recording = \Vonage\Voice\Webhook\Factory::createFromArray($request_array);
$record_url = $recording->getRecordingUrl();
$record_uuid = $recording->getRecordingUuid();
$data = $client->get($record_url);

// write recorded call to local file.
file_put_contents('./recordings/' . time() . '.mp3', $data->getBody());
echo $record_url;
