<?php

namespace App\Controllers;

use App\Service\TemplateEngine;
use Psr\Http\Message\ResponseInterface as Response;
use App\Service\Session;

abstract class Controller 
{
    protected function render(Response $response, $template, array $data = [])
    {
        $response->getBody()->write(
            TemplateEngine::render($template, $data)
        );

        if(!empty(Session::getNotify())) {
            Session::setNotify([]);
        }

        return $response;
    }
}   