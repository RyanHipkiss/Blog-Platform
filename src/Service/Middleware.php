<?php

namespace App\Service;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Service\Session;
use App\Service\Redirect;
use App\Service\Router;

class Middleware
{
    public function loggedIn(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if(empty(Session::user())) {
            Redirect::to(Router::getUriFromName('login'));
        }

        return $next($request, $response);
    }

    public function notLoggedIn(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if(!empty(Session::user())) {
            Redirect::to(Router::getUriFromName('dashboard'));
        }

        return $next($request, $response);
    }
}
