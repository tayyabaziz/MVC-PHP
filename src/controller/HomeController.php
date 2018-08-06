<?php

namespace RecipeSystem\Controller;

use RecipeSystem\Model\HomeModel;

class HomeController extends Controller
{
    public function __construct(array $mydata = array())
    {
        new HomeModel();
        $this->twigrender('home.html.twig', $mydata);
    }
}
