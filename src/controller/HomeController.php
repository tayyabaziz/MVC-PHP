<?php
namespace RecipeSystem;

class HomeController extends Controller
{
    function __construct() 
    {   
        new \RecipeSystem\Model\HomeModel();
        //$this->view("home");


        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../view/');
        $twig = new \Twig_Environment($loader);
        echo $twig->render(
            'home.html', 
            array(
                'pagename' => 'main', 
                'pagetitle' => 'Home', 
                'title' => 'Recipe Website', 
                'metas' =>
                [
                    ['name'=>'description', 'content'=>'Recipe Website'],
                    ['name'=>'author', 'content'=>'Tayyab Aziz'],
                ],
            )
        );
    }
}