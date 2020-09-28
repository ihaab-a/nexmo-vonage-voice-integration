<?php
/**
 * Created by PhpStorm.
 * User: Tai
 * Date: 9/27/2020
 * Time: 12:13 PM
 */

use \Psr\Http\Message\ServerRequestFactoryInterface as Request;
use \Psr\Http\Message\ResponseFactoryInterface as Response;

require './vendor/autoload.php';

$app = new \Slim\App;

$handler = function(Request $request, Response $response) {
    return $response->withStatus(204);
};

$app->get('/webhook/inbound-sms', $handler);
$app->post('/webhook/inbound-sms', $handler);

$app->run();


