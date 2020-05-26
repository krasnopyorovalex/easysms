<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use Laminas\Diactoros\ResponseFactory;

$container = new League\Container\Container;
$container->addServiceProvider(new AppServiceProvider);

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$responseFactory = new ResponseFactory();

$strategy = new League\Route\Strategy\JsonStrategy($responseFactory);
$strategy->setContainer($container);

$router = (new League\Route\Router)->setStrategy($strategy);

$router
    ->group('/api/v1', function ($router) {
        $router->map('GET', '/authors/{id:number}/news', 'App\Http\Controller\AuthorController::news');
        $router->map('GET', '/categories/{id:number}/news', 'App\Http\Controller\CategoryController::news');
        $router->map('GET', '/authors', 'App\Http\Controller\AuthorController');
        $router->map('GET', '/news/{id:number}/view', 'App\Http\Controller\PostController::view');
        $router->map('GET', '/news/search', 'App\Http\Controller\PostController::search');
        $router->map('GET', '/categories/{id:number}/news/search', 'App\Http\Controller\CategoryController::search');
    });

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
