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


function save_sms_row($data) {
    global $db;
    $number = isset($data['to']) ? $data['to'] : '';
    $message = $db->real_escape_string(isset($data['text']) ? $data['text'] : '');

    if (!is_string($data)) {
        $data = json_encode($data);
    }
    $data = !empty($data) ? $db->real_escape_string($data) : '';
    $now = date('c');
    $str_query = "INSERT INTO sms_temp (body, created_at, to_number, content) VALUES ('{$data}', '{$now}', '{$number}', '{$message}')";
    $db->query($str_query);
    return $db->insert_id;
}

$params = $_GET;

