<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 12:15 PM
 */

include_once './config/database.php';

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE) or die("Could not connect : " . mysqli_error());
$db->set_charset('utf8');

if (!empty($_GET)) {
    $data = $_GET;
} else {
    $data = json_decode(file_get_contents('php://input'), true);
}


$number_to = isset($data['to']) ? $data['to'] : '';
$number_from = isset($data['from']) ? $data['from'] : '';
$uuid = isset($data['uuid']) ? $data['uuid'] : '';
$c_uuid = isset($data['conversation_uuid']) ? $data['conversation_uuid'] : '';
$details = $db->real_escape_string(json_encode($data));

$now = date('c');

$str_query = "INSERT INTO answers (number_from, number_to, uuid, conversation_uuid, details, created_at) 
      VALUES ('{$number_from}', '{$number_to}', '{$uuid}', '{$c_uuid}', '{$details}', '{$now}')";

$db->query($str_query);
$insert_id = $db->insert_id;

if ($insert_id) {
    echo 'Inserted with id=' . $insert_id;
}
else {
    echo 'Something went wrong!';
}


