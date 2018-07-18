<?php
session_start();
$route = "home";
if(isset($_GET['route'])) {
	$route = $_GET['route'];
}
switch ($route) {
	case 'cart':
		include __DIR__ . '/controller/CartController.php';
		new CartController();
		break;
	case 'checkout':
		include __DIR__ . '/controller/CheckoutController.php';
		new CheckoutController();
		break;
	case 'home':
		include __DIR__ . '/controller/HomeController.php';
		new HomeController();
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		echo "<h1>404 Not Found</h1>";
		echo "The page that you have requested could not be found.";
		exit();
		break;
}
?>