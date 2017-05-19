<?php

use \App\Service\Router;
use \App\Service\Middleware;

$routes = Router::setup(new \League\Route\RouteCollection($container));

/**
 * Front End
 **/

$routes->group('/auth', function($routes) {
    $routes->get('/register', 'App\Controllers\Auth\AuthController::showRegister')->setName('auth.register');
	$routes->post('/register', 'App\Controllers\Auth\AuthController::postRegister');

	$routes->get('/login', 'App\Controllers\Auth\AuthController::showLogin')->setName('auth.login');
	$routes->post('/login', 'App\Controllers\Auth\AuthController::postLogin');

	$routes->get('/logout', 'App\Controllers\Auth\AuthController::logout')->setName('auth.logout');
})->middleware([new Middleware, 'notLoggedIn']);

/**
 * Back End (Admin)
 **/
$routes->group('/admin', function($routes) {
	$routes->get('/', 'App\Controllers\Backend\AdminController::index')->setName('admin.index');

	//roles
	$routes->get('/roles/all', 'App\Controllers\Backend\RolesController::show')->setName('admin.roles');
	$routes->get('/roles/edit/{id:number}', 'App\Controllers\Backend\RolesController::view')->setName('admin.role');
	$routes->get('/roles/add', 'App\Controllers\Backend\RolesController::view')->setName('admin.role.add');
	
	$routes->get('/roles/delete/{id:number}', 'App\Controllers\Backend\RolesController::delete')->setName('admin.role.delete');
	$routes->post('/roles/edit/{id:number}', 'App\Controllers\Backend\RolesController::edit');
	$routes->post('/roles/add', 'App\Controllers\Backend\RolesController::edit');

	//users
	$routes->get('/users/all', 'App\Controllers\Backend\UsersController::show')->setName('admin.users');
	$routes->get('/users/edit/{id:number}', 'App\Controllers\Backend\UsersController::view')->setName('admin.user');
	$routes->get('/users/add', 'App\Controllers\Backend\UsersController::view')->setName('admin.user.add');

	$routes->get('/users/delete/{id:number}', 'App\Controllers\Backend\UsersController::delete')->setName('admin.user.delete');
	$routes->post('/users/edit/{id:number}', 'App\Controllers\Backend\UsersController::edit');
	$routes->post('/users/add', 'App\Controllers\Backend\UsersController::edit');

})->middleware([new Middleware, 'loggedIn']);

$response = $routes->dispatch($container->get('request'), $container->get('response'));

$container->get('emitter')->emit($response);
