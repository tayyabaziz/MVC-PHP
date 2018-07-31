<?php
namespace RecipeSystem\Controller;

use RecipeSystem\Model\HomeModel;

class HomeController extends Controller
{
    function __construct(array $setting = array()) 
    {   
        new HomeModel();
        $this->twigrender('home.html', $setting);
    }
}