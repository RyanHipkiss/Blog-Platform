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
            Redirect::to(Router::getUriFromName('auth.login'));
        }

        return $next($request, $response);
    }

    public function notLoggedIn(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        if(!empty(Session::user())) {
            Redirect::to(Router::getUriFromName('admin.index'));
        }

        return $next($request, $response);
    }
}
