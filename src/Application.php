<?
namespace RecipeSystem;

use RecipeSystem\Controller;
use RecipeSystem\MyRoutes;

class Application
{
	public static function intialize() {

		$route = "home";
		if(isset($_GET['route'])) {
			$route = $_GET['route'];
		}
		$route = rtrim($route, '/');

		$setting = (new Controller\Controller())->getApplicationSetting();

		$request_uri = $_SERVER['PHP_SELF'];
		$request_uri = str_replace("index.php", "", $request_uri);
		$request_uri = rtrim($request_uri, '/');
		$request_uri .= "/";

		$setting['applicationurl'] = "http://".$_SERVER['HTTP_HOST'].$request_uri;

		if(array_key_exists($route, MyRoutes::$routesarr)) {
			$routesvalue = (MyRoutes::$routesarr)[$route];

			foreach ($routesvalue['routesetting'] as $key => $value) {
				$setting[$key] = $value;
			}
			$newcontroller = $routesvalue['newcontroller'];
			$controller = new $newcontroller($setting);
			exit();
		}
		else {
			$setting['pagename'] = 'error';
			$setting['pagetitle'] = 'Error 404';
			new Controller\ErrorController($setting);
			exit();
		}
	}
}