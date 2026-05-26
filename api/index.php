<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Index!");
    return $response;
});

$app->group('/api', function ($group) {

    $group->get('/resume', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Resume!");
        return $response;
    });


    $group->get('/hello/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $group->get('/hello/', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Hello World!");
        return $response;
    });




    $group->get('/**', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("invalid!");
        return $response;
    });
});


try {
    $app->run();
} catch (Exception $e) {
    echo json_encode([
        "error" => true
    ]);
}
