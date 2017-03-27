<?php

namespace App\Service;

class Router
{
    private static $routes;

    public static function setRoutes($routes)
    {
        self::$routes = $routes;
    }

    public static function getUriFromName($name)
    {
        return self::$routes->getNamedRoute($name)->getPath();
    }
}