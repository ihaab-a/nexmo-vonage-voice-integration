<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 12:15 PM
 * // Logs all events from the application
 */


include_once './config/database.php';

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE) or die("Could not connect : " . mysqli_error());
$db->set_charset('utf8');

$number_from = isset($_GET['from']) ? $_GET['from'] : '';
$number_to = isset($_GET['to']) ? $_GET['to'] : '';
$uuid = isset($_GET['uuid']) ? $_GET['uuid'] : '';
$c_uuid = isset($_GET['conversation_uuid']) ? $_GET['conversation_uuid'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$direction = isset($_GET['direction']) ? $_GET['direction'] : '';
$timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : '';

$details = $db->real_escape_string(json_encode($_GET));
$now = date('c');

$str_query = "INSERT INTO events (number_from, number_to, uuid, conversation_uuid, status, direction, timestamp, details, created_at) 
      VALUES ('{$number_from}', '{$number_to}', '{$uuid}', '{$c_uuid}', '{$status}', '{$direction}', '{$timestamp}', '{$details}', '{$now}')";

$db->query($str_query);
$insert_id = $db->insert_id;

if ($insert_id) {
    echo 'Inserted with id=' . $insert_id;
} else {
    echo 'Something went wrong!';
}
