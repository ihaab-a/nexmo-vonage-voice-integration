<?php

require_once './vendor/autoload.php';

/**
 *
 *
 *
 * POST Payload:
 * {'conversation_uuid': 'CON-ddddaaaa-bbbb-cccc-dddd-0123456789de',
'   end_time': '2018-08-10T11:19:31Z',
'   recording_url': 'https://api.nexmo.com/v1/files/aaaaaaaa-bbbb-cccc-dddd-0123456789ab',
'   recording_uuid': 'ccccaaaa-dddd-cccc-dddd-0123456789ab',
'   size': 162558,
'   start_time': '2018-08-10T11:18:51Z',
'   timestamp': '2018-08-10T11:19:31.744Z'}
*  1.2.3.4 - - [10/Aug/2018 11:19:31] "POST /webhooks/recordings HTTP/1.1" 200 -
*/

$request_array = json_decode(file_get_contents('php://input'), true);
$recording = \Vonage\Voice\Webhook\Factory::createFromArray($request_array);
$record_url = $recording->getRecordingUrl();

// from here, refer: https://developer.nexmo.com/voice/voice-api/code-snippets/download-a-recording
$record_uuid = $recording->getRecordingUuid();
$data = $client->get($record_url);
file_put_contents('./recordings/' . time() . '.mp3', $data->getBody());

// logs to database
$now = date('c');
$details = $db->real_escape_string(json_encode($data));
$str_query = "INSERT INTO recordings (url, uuid, details, created_at) 
    VALUES ('{$record_url}', '{$record_uuid}', '{$details}', '{$now}')";
$db->query($str_query);

echo $record_url;