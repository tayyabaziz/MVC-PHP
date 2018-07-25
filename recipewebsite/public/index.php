<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';

$route = "home";
if(isset($_GET['route'])) {
	$route = $_GET['route'];
}
switch ($route) {
	case 'home':
		new RecipeSystem\HomeController();
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		echo "<h1>404 Not Found</h1>";
		echo "The page that you have requested could not be found.";
		exit();
		break;
}
?>