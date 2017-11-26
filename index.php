<?php
define( "BASE_URL", 'http://' . $_SERVER["SERVER_NAME"] . '/BlogPost/' );

require_once __DIR__. '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(__DIR__ . '/view');
$twig = new Twig_Environment($loader, array(
    'cache' => false 
));

require('controller/PostController.php');
use \OC\BlogPost\Controller\PostController;

try {
	preg_match('#^/BlogPost/index.php?/(\w+)/?(\d+)?#i', $_SERVER['REQUEST_URI'], $matches);
    if ( ! empty($matches) && isset($matches[1])) { 
    	$_GET['action'] = $matches[1];
    	if (isset($matches[2])) {
    		$_GET['id'] = $matches[2];
    	}
    } 

	if (isset($_GET['action'])) {
	    if ($_GET['action'] == 'listPosts') {
    		$controller = new PostController($twig);
    	    $controller->listPosts();
	    }
	    elseif ($_GET['action'] == 'post') {
	        if (isset($_GET['id']) && $_GET['id'] > 0) {
        		$controller = new PostController($twig);
        	    $controller->post();
	        }
	        else {
	            throw new Exception('Aucun identifiant de billet envoyé');
	        }
	    }    
	    elseif ($_GET['action'] == 'postForm') {
	        if (isset($_GET['id']) && $_GET['id'] > 0) {
        		$controller = new PostController($twig);
        	    $controller->postForm();
	        }
	        else {
	            throw new Exception('Aucun identifiant de billet envoyé');
	        }
	    }
	    elseif ($_GET['action'] == 'newPost') {
            if ( ! empty($_POST['author']) && ! empty($_POST['title']) && ! empty($_POST['lead_paragraph']) && ! empty($_POST['content'])) {
            	$controller = new PostController($twig);
                $controller->newPost($_POST['author'], $_POST['title'], $_POST['lead_paragraph'], $_POST['content']);
            }
            else {
                throw new Exception('Tous les champs ne sont pas remplis !');
            }
	    }	    
	    elseif ($_GET['action'] == 'editPost') {
	        if (isset($_GET['id']) && $_GET['id'] > 0) {
	            if ( ! empty($_POST['author']) && ! empty($_POST['title']) && ! empty($_POST['lead_paragraph']) && ! empty($_POST['content'])) {
                	$controller = new PostController($twig);
	                $controller->editPost($_GET['id'], $_POST['author'], $_POST['title'], $_POST['lead_paragraph'], $_POST['content']);
	            }
	            else {
	                throw new Exception('Tous les champs ne sont pas remplis !');
	            }
	        }
	        else {
	            throw new Exception('Aucun identifiant de billet envoyé');
	        }
	    }
	    else {
	    	throw new Exception("Action non valide");
	    }
	}
	else {
		$controller = new PostController($twig);
	    $controller->listPosts();
	}
} 
catch(Exception $e) {
    $data['errorMessage'] = $e->getMessage();
	$view = new View($twig, 'error');
	$view->generate($data);
}
// header('HTTP/1.0  404 not found');