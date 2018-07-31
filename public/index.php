<?php
session_start();

use RecipeSystem\MyRoutes;
use RecipeSystem\Application;

require_once __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../config.php';

MyRoutes::addRoutes(
	'home', 
	'HomeController', 
	[
		'pagename' => 'main',
		'pagetitle' => 'Home',
	]
);

Application::intialize();