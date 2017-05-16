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

    public static function getUriFromName($name, array $arguments = null)
    {
        $path = self::$router->getNamedRoute($name)->getPath();

        return preg_replace_callback("/\{([A-Za-z0-9]+)\:([A-Za-z0-9]+)\}/", function($matches) use($arguments) {
            return $arguments[$matches[1]];
        }, $path);
    }
}
