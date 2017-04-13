<?php

use \App\Service\Router;
use \App\Service\Middleware;

$routes = Router::setup(new \League\Route\RouteCollection($container));

$routes->group('/auth', function($routes) {
    $routes->get('/register', 'App\Controllers\Auth\AuthController::showRegister')->setName('register');
	$routes->post('/register', 'App\Controllers\Auth\AuthController::postRegister');

	$routes->get('/login', 'App\Controllers\Auth\AuthController::showLogin')->setName('login');
	$routes->post('/login', 'App\Controllers\Auth\AuthController::postLogin');
});

$routes->get('/', 'App\Controllers\ExampleController::middleware')->setName('home');

$response = $routes->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
