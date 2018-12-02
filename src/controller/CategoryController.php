<?php

namespace RecipeSystem\Controller;

use RecipeSystem\Model\CategoryModel;

class CategoryController extends Controller
{
    public function __construct(array $mydata = array())
    {
        new CategoryModel();
        $mydata = (new parent())->setSetting($mydata);
        $this->twigrender('categories.html.twig', $mydata);
    }
}
