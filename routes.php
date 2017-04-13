<?php

use \App\Service\Router;
use \App\Service\Middleware;

$routes = new League\Route\RouteCollection($container);

$auth = [new \App\Service\Middleware, 'loggedIn'];

$routes->group('/auth', function($routes) {
	$routes->get('/register', 'App\Controllers\Auth\AuthController::showRegister')->setName('register');
	$routes->post('/register', 'App\Controllers\Auth\AuthController::postRegister');

	$routes->get('/login', 'App\Controllers\Auth\AuthController::showLogin')->setName('login');
	$routes->post('/login', 'App\Controllers\Auth\AuthController::postLogin');
})->middleware([new Middleware, 'notLoggedIn']);

$routes->get('/', 'App\Controllers\ExampleController::middleware')->setName('home');

Router::setRoutes($routes);
$response = $routes->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
