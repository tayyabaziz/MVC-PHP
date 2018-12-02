<?php

use RecipeSystem\MyRoutes;

MyRoutes::addRoutes(
    'home',
    'HomeController',
    [
        'pagename' => 'main',
        'pagetitle' => 'Home',
    ]
);

MyRoutes::addRoutes(
    'recipe',
    'CategoryController',
    [
        'pagename' => 'recipe',
        'pagetitle' => 'All Recipes',
    ]
);

MyRoutes::addRoutes(
    'recipe/{recipename}',
    'DetailsController',
    [
        'pagename' => '{recipename}',
        'pagetitle' => '{recipename}',
    ]
);
/*
MyRoutes::addRoutes(
    '{category}',
    'CategoryController',
    [
        'pagename' => '{category}',
        'pagetitle' => '{category}',
    ]
);

MyRoutes::addRoutes(
    '{category}/{recipename}',
    'DetailsController',
    [
        'pagename' => '{recipename}',
        'pagetitle' => '{recipename}',
    ]
);
*/
