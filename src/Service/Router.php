<?php

namespace App\Service;

class Router
{
    private static $router = null;

    public static function setup(\League\Route\RouteCollection $router)
    {
        if(self::$router === null) {
            self::$router = $router;
        }

        return self::$router;
    }

    public static function getUriFromName($name)
    {
        return self::$router->getNamedRoute($name)->getPath();
    }
}
