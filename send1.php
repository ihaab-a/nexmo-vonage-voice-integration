<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/27/2020
 * Time: 5:06 PM
 */

//gabrielrebeiro123
//gabrielASD123!@#

define('API_KEY', '6036eb7f');
define('API_SECRET', 'P6DvgEvjjBMZI3ct');
define('FROM_NUMBER', '8618102437215');

require './vendor/autoload.php';


$basic  = new \Vonage\Client\Credentials\Basic('8e544a8f', 'K9vG1KjTOTW1AeDM');
$client = new \Vonage\Client($basic);
//$text = new \Vonage\SMS\Message\SMS('8618640211091', 'Vonage APIs', "Hello SMS D");
//$text = new \Vonage\SMS\Message\SMS('8618640211091', 'Vonage APIs', "Hello SMS D");
//    $message = new \Vonage\SMS\Message\SMS()
try {
    $res = $client->message()->send([
        'to'    => '12012790554',
        'from'  => 'Vonage APIs',
        'text'  => 'Hello, US Num with Msg Class'
    ]);
    $data = $res->current(); //var_dump($data);
    echo 'sent message to ' . $data['to'] . '. Balance is now ' . $data['remaining-balance'] . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage();
}

//echo 'message sent!'; exit;