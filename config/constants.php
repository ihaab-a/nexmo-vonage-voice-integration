<?php

$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
//$baseUrl = $http . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
//$baseUrl = "http://ec2-3-12-163-249.us-east-2.compute.amazonaws.com/test/";
$baseUrl = "http://50ea3a69679c.ngrok.io/045-nexmo/";

//define('API_KEY', '8e544a8f');
//define('API_SECRET', 'K9vG1KjTOTW1AeDM');
//define('APP_ID', '86ccdaa2-f61f-4678-91b4-c7b99c19bafe');
//define('PRIVATE_KEY', 'private_oni.key');
//define('MUSIC_FILE', $baseUrl . 'music/bensound-adventure.mp3');
//
////$number_to = "12064531225";
//$number_to = "17036499939";
//$number_from = "12013316626";
//define('NUMBER_FROM', $number_from);
//define('NUMBER_TO', $number_to);

define('API_KEY', '6036eb7f');
define('API_SECRET', 'P6DvgEvjjBMZI3ct');
define('APP_ID', '0f396283-55a8-4dc3-9dfa-075d93219bd9');
define('PRIVATE_KEY', 'private.key');
define('MUSIC_FILE', $baseUrl . 'music/bensound-adventure.mp3');

$number_to = "40743932222";
$number_from = "40371703012";
define('NUMBER_FROM', $number_from);
define('NUMBER_TO', $number_to);