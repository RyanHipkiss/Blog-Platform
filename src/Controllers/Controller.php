<?php

namespace App\Controllers;

use App\Service\TemplateEngine;
use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller 
{
    protected function render(Response $response, $template, array $data = [])
    {
        $response->getBody()->write(
            TemplateEngine::render($template, $data)
        );

        return $response;
    }
}   