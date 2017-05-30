<?php

namespace App\Service;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Service\Session;
use App\Service\Redirect;
use App\Service\Router;
use App\Controllers\Auth\AuthController;
use App\Manager\UserManager;

class Middleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function loggedIn(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if(empty(Session::user())) {
            Redirect::route('auth.login');
        }

        return $next($request, $response);
    }

    public function notLoggedIn(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if(!empty(Session::user())) {
            Redirect::route('admin.index');
        }

        return $next($request, $response);
    }

    public function adminRole(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {   
        $user = $this->container->get(UserManager::class)->findByEmail(Session::user());
        $acceptedRoles = $this->container->get(AuthController::class)->getAdminRoles();

        if($user === null) {
            Redirect::route('auth.login');
        }

        $hasRole = $user->getRoles()->filter(function(\App\Entity\Role $role) use($acceptedRoles) {
            return in_array($role->getId(), $acceptedRoles);
        });

        if(empty($hasRole)) {
            Redirect::route('auth.login');
        }

        return $next($request, $response);
    }
}
