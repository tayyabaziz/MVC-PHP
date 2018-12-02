<?php

namespace RecipeSystem;

class Application
{
    public static function intialize()
    {
        $croute = '';
        $route = 'home';
        if (isset($_GET['route'])) {
            $route = $_GET['route'];
            $croute = $_GET['route'];
        }
        $route = rtrim($route, '/');

        $mydata = (new Controller\Controller())->getApplicationSetting();

        $request_uri = $_SERVER['PHP_SELF'];
        $request_uri = str_replace('index.php', '', $request_uri);
        $request_uri = rtrim($request_uri, '/');
        $request_uri .= '/';

        $mydata['applicationurl'] = 'http://'.$_SERVER['HTTP_HOST'].$request_uri;
        $mydata['canonical'] = 'http://'.$_SERVER['HTTP_HOST'].$request_uri.$croute;

        if (array_key_exists($route, MyRoutes::$routesarr)) {
            $routesvalue = (MyRoutes::$routesarr)[$route];

            foreach ($routesvalue['routesetting'] as $key => $value) {
                $mydata[$key] = $value;
            }
            $newcontroller = $routesvalue['newcontroller'];
            $controller = new $newcontroller($mydata);
            exit();
        } else {
            $myroutes = MyRoutes::$routesarr;
            $currroute = explode('/', $route);
            $notfound = true;
            foreach ($myroutes as $key => $value) {
                $myrouteskeys = explode('/', $key);
                if (count($myrouteskeys) == count($currroute)) {
                    $routestr = array();
                    foreach ($myrouteskeys as $key2 => $value2) {
                        if ($value2 == $currroute[$key2]) {
                            $routestr[] = $value2;
                        } elseif (false !== strpos($value2, '{')) {
                            $routestr[] = $value2;
                        }
                    }
                    $routestrc = implode('/', $routestr);

                    if ($key == $routestrc) {
                        foreach ($routestr as $key2 => $value2) {
                            $mydata[$value2] = $currroute[$key2];
                        }
                        $routesvalue = $value;
                        foreach ($routesvalue['routesetting'] as $key3 => $value3) {
                            $mydata[$key3] = $value3;
                        }
                        $newcontroller = $routesvalue['newcontroller'];
                        $controller = new $newcontroller($mydata);
                        exit();
                    }
                }
            }

            $mydata['routeerror'] = $route;
            new Controller\ErrorController($mydata);
            exit();
        }
    }
}
