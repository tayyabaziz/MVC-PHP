<?php

namespace RecipeSystem\Controller;

use RecipeSystem\Model\DetailsModel;

class DetailsController extends Controller
{
    public function __construct(array $mydata = array())
    {
        new DetailsModel();
        $this->twigrender('details.html.twig', $mydata);
    }
}
