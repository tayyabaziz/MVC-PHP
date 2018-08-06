<?php

session_start();

use RecipeSystem\Application;

require_once __DIR__.'/../vendor/autoload.php';
include __DIR__.'/../config.php';
include __DIR__.'/../routes.php';

Application::intialize();
