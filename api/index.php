<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Database.php';
require __DIR__ . '/../src/Helper.php';

loadEnv(__DIR__ . '/../.env', safe: true);

$app = AppFactory::create();

// $app->add(function (Request $request, RequestHandler $handler): Response {
//     $response = $handler->handle($request);

//     return $response->withHeader('Content-Type', 'application/json');
// });

$app->get('/', function (Request $request, Response $response, array $args) {



    $response->getBody()->write("index");
    return $response;
});

$app->group('/api', function ($group) {




    $group->get('/resume', function (Request $request, Response $response, array $args) {

        var_dump(phpinfo());


        $collection = Database::getInstance()->getCollection('experiences');

        $experiences = $collection->find([], ['sort' => ['_id' => 1], "projection" => ["_id" => 0]])->toArray();

        //var_dump($experiences);

        $response->getBody()->write(json_encode($experiences));

        return $response;
    });


    $group->get('/hello/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $group->get('/hello', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Hello World!");
        return $response;
    });




    $group->get('/**', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("invalid!");
        return $response;
    });
})->add(function (Request $request, RequestHandler $handler): Response {
    $response = $handler->handle($request);

    return $response->withHeader('Content-Type', 'application/json');
});


try {
    $app->run();
} catch (Exception $e) {
    //var_dump(getenv());
    // echo json_encode([
    //     "error" => true,
    //     "message" => $e->getMessage(),

    // ]);
}
