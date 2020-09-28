<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/28/2020
 * Time: 12:15 PM
 *
 * is used when either the Answer or Event webhook fails or returns an HTTP error status.
 */


include_once './config/database.php';

$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE) or die("Could not connect : " . mysqli_error());
$db->set_charset('utf8');

$reason = $db->real_escape_string(isset($_GET['reason']) ? $_GET['reason'] : '');
$origin_url = $db->real_escape_string(isset($_GET['original_request']['url']) ? $_GET['original_request']['url'] : '');
$req_type = isset($_GET['original_request']['type']) ? $_GET['original_request']['type'] : '';

$now = date('c');
$details = $db->real_escape_string(json_encode($_GET));

// insert to database
$str_query = "INSERT INTO errors (reason, origin_url, type, details, created_at) VALUES ('{$reason}', '{$origin_url}', '{$req_type}', '{$details}', '{$now}')";
$db->query($str_query);

$insert_id = $db->insert_id;

if ($insert_id) {
    echo 'inserted with id=' . $insert_id;
}
else {
    echo 'Insert error';
}
