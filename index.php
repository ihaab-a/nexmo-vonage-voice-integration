<?php

//use \Psr\Http\Message\ServerRequestFactoryInterface as Request;
//use \Psr\Http\Message\ResponseFactoryInterface as Response;

define('API_KEY', '8e544a8f');
define('API_SECRET', 'K9vG1KjTOTW1AeDM');
define('FROM_NUMBER', '8618102437215');

require './vendor/autoload.php';
require './config/database.php';

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

$app = new \Slim\App();
//$app->config('debug', true);

$client = new Vonage\Client(new Vonage\Client\Credentials\Basic(API_KEY, API_SECRET));

//$handler = function (Request $request, Response $response) {
$handler = function ($request, $response) {
    $params = $request->getParsedBody(); //var_dump($params);
    // Fall back to query parameters if needed
    if (empty($params) || !count($params)){
        $params = $request->getQueryParams();
    }
    //error_log(print_r($params, true));
    save_sms_row($params);
    echo json_encode($params);
    return $response->withStatus(200);
};

// ref: https://developer.nexmo.com/messaging/sms/guides/inbound-sms#anatomy-of-an-inbound-message
$app->get('/webhook/inbound-sms', $handler);
$app->post('/webhook/inbound-sms', $handler);

$app->post('/sms/{number}', function ($request, $response, $args) {
    $body = $request->getParsedBody();
    if (!isset($body['text'])) {
        return $response->withStatus(400)->write('No message provided!');
    }

    $basic  = new \Vonage\Client\Credentials\Basic('8e544a8f', 'K9vG1KjTOTW1AeDM');
    $client = new \Vonage\Client($basic);
    $text = new \Vonage\SMS\Message\SMS($args['number'], 'Vonage APIs', "Hello SMS");
//    $message = new \Vonage\SMS\Message\SMS()
    try {
        $client->sms()->send()($text);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
//    $resp = $client->sms()->send($text);
//    $message = $client->sms()->send([
//        'to' => $args['number'],
//        'from' => 'Vonage APIs',
//        'text' => 'Hello from Vonage SMS API'
//    ]);

//    $client = new Vonage\Client(new Vonage\Client\Credentials\Basic(API_KEY, API_SECRET));
//    //$client = new NexmoClient(new NexmoClientCredentialsBasic(API_KEY, API_SECRET));
//    $text = new \Vonage\SMS\Message\SMS($args['number'], FROM_NUMBER, $body['text']);
//    //$text = new NexmoMessageText($args['number'], FROM_NUMBER, $body['text']);
//    //$client->message()->send($text);
//    //$text->setClientRef('test-message');
//    $sent = $client->sms()->send($text);
//    $sent_data = $sent->current();
    return $response->write("Sending an SMS to " . $args['number']);
});

$app->run();






