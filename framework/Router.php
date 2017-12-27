<?php
namespace OC\BlogPost\Framework;

require_once('Request.php');
use \OC\BlogPost\Framework\Request;

// require('controller/PostController.php');
// use \OC\BlogPost\Controller\PostController;

require_once('View.php');
use \OC\BlogPost\Framework\View;

class Router 
{
	private $_twig;
	// private $_postController;

	public function __construct(\Twig_Environment $twig) 
	{
		$this->_twig = $twig;
	    // $this->_postController = new PostController($twig);
	}

	public function routeRequest()
	{
		// http://localhost/BlogPost/index.php/post/114
		try {
			preg_match('#^/BlogPost/index.php?/(\w+)/?(\w+)?/?(\d+)?#i', $_SERVER['REQUEST_URI'], $matches);
		    if ( ! empty($matches) && isset($matches[1])) { 
		    	$_GET['controller'] = $matches[1];
		    	if (isset($matches[2])) {
		    		$_GET['action'] = $matches[2];
		    	}		    	
		    	if (isset($matches[3])) {
		    		$_GET['id'] = $matches[3];
		    	}
		    }

		    $request = new Request(array_merge($_GET, $_POST));

		    $controller = $this->createController($request);
		    $action = $this->createAction($request);

		    $controller->executeAction($action);
		}
		catch(\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	private function createController(Request $request) {
	    $controller = "Home";  
	    if ($request->isParameter('controller')) {
	        $controller = $request->getParameter('controller');
	        $controller = ucfirst(strtolower($controller));
	    }

	    $controllerClass = $controller. "Controller";
	    $controllerFile = "controller/" . $controllerClass . ".php";
	    $controllerClassWithNamespace = "\OC\BlogPost\Controller\\" .$controllerClass;
	    if (file_exists($controllerFile)) {
	    	require_once($controllerFile);
	        $controller = new $controllerClassWithNamespace($this->_twig);
	        $controller->setRequest($request);
	        return $controller;
	    }
	    else {
	        throw new \Exception("Fichier '". $controllerFile. "' introuvable");
	    }
	}

	private function createAction(Request $request) {
	    $action = 'index'; 
	    if ($request->isParameter('action')) {
	        $action = $request->getParameter('action');
	    }
	    return $action;
	}

	private function error($errorMessage) 
	{
		$view = new View($this->_twig, 'error');
		$view->generate(['errorMessage' => $errorMessage]);
	}
}