<?php

namespace RecipeSystem;

class HomeController extends Controller
{
	
	function __construct() {	
		new \RecipeSystem\Model\HomeModel();
		$this->view("home");
	}
}