<?php

namespace RecipeSystem;

class MyRoutes
{
    public static $routesarr = array();

    public static function addRoutes($newroute, $newcontroller, $routesetting)
    {
        $routesarr = [
            'newroute' => $newroute,
            'newcontroller' => 'RecipeSystem\\Controller\\'.$newcontroller,
            'routesetting' => $routesetting,
        ];

        self::setRoutesArray($routesarr);
    }

    public static function setRoutesArray($routesarr)
    {
        self::$routesarr[$routesarr['newroute']] = $routesarr;
    }

    public static function getRoutesArray()
    {
        return self::$routesarr;
    }
}
