<?php
define('ENVIRONMENT', 'development'); // development|production
define( "BASE_URL", 'http://' . $_SERVER["SERVER_NAME"] . '/BlogPost/' );

require_once __DIR__. '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(__DIR__ . '/view');
$twig = new Twig_Environment($loader, array(
    'cache' => false 
));

require 'Controller/Router.php';
use \OC\BlogPost\Controller\Router;

$routeur = new Router($twig);
$routeur->routeRequest();