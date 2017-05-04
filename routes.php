<?php

use \App\Service\Router;
use \App\Service\Middleware;

$routes = Router::setup(new \League\Route\RouteCollection($container));

/**
 * Front End
 **/

$routes->group('/auth', function($routes) {
    $routes->get('/register', 'App\Controllers\Auth\AuthController::showRegister')->setName('register');
	$routes->post('/register', 'App\Controllers\Auth\AuthController::postRegister');

	$routes->get('/login', 'App\Controllers\Auth\AuthController::showLogin')->setName('login');
	$routes->post('/login', 'App\Controllers\Auth\AuthController::postLogin');
});

/**
 * Back End (Admin)
 **/
$routes->group('/admin', function($routes) {
	$routes->get('/', 'App\Controllers\Backend\AdminController::index')->setName('admin.index');

	//roles
	$routes->get('/roles/all', 'App\Controllers\Backend\RolesController::show')->setName('admin.roles');
	$routes->get('/roles/edit/{id:number}', 'App\Controllers\Backend\RolesController::view')->setName('admin.role');
	$routes->get('/roles/add', 'App\Controllers\Backend\RolesController::view')->setName('admin.role.add');

	$routes->post('/roles/edit/{id:number}', 'App\Controllers\Backend\RolesController::edit');
	$routes->post('/roles/add', 'App\Controllers\Backend\RolesController::edit');
})->middleware([new Middleware, 'loggedIn']);

$routes->get('/', '')->setName('home');

$response = $routes->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
