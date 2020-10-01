<?php

// set the base url or ngrok endpoint on localhost
$http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
//$baseUrl = $http . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/';
$baseUrl = "<http://50ea3a69679c.ngrok.io>/pranker/";

define('API_KEY', '6036eb7f');
define('API_SECRET', 'P6DvgEvjjBMZI3ct');
define('APP_ID', '0f396283-55a8-4dc3-9dfa-075d93219bd9');
define('PRIVATE_KEY', 'private.key');
define('MUSIC_FILE', $baseUrl . 'music/bensound-adventure.mp3');

$number_to = "40743932222";
$number_from = "40371703012";
define('NUMBER_FROM', $number_from);
define('NUMBER_TO', $number_to);