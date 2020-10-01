<?php

    require_once '../vendor/autoload.php';

    use Laminas\Diactoros\Response\JsonResponse;
    use \Psr\Http\Message\ResponseInterface as Response;
    use \Psr\Http\Message\ServerRequestInterface as Request;

    $app = new \Slim\App();
//    $app = AppFactory::create();
//    $app->addErrorMiddleware(true, true, true);
//    $app->setBasePath("/index.php");

    $app->post('/recordings', function (Request $request, Response $response) {
        /** @var \Nexmo\Voice\Webhook\Record */
        $recording = \Voanage\Voice\Webhook\Factory::createFromRequest($request);
        error_log($recording->getRecordingUrl());

        return $response->withStatus(204);
    });

    $app->run();