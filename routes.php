<?php

$routes = new League\Route\RouteCollection($container);

$routes->group('/auth', function($routes) {
	$routes->get('/register', 'App\Controllers\Auth\AuthController::showRegister');
	$routes->post('/register', 'App\Controllers\Auth\AuthController::postRegister');

	$routes->get('/login', 'App\Controllers\Auth\AuthController::showLogin');
	$routes->post('/login', 'App\Controllers\Auth\AuthController::postLogin');
});

$response = $routes->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
