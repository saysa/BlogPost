<?php
namespace OC\BlogPost\Framework;

/*use \OC\BlogPost\Framework\Request;
use \OC\BlogPost\Framework\View;*/

class Router 
{
	private $_twig;
	private $_view;

	public function __construct(\Twig_Environment $twig, View $view)
	{
		$this->_twig = $twig;
		$this->_view = $view;
	}

	public function routeRequest()
	{
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

	public function createController(Request $request) {
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
	        $controller = new $controllerClassWithNamespace($this->_twig, $this->_view);
	        $controller->setRequest($request);
	        return $controller;
	    }
	    else {
	        throw new \Exception("Fichier '". $controllerFile. "' introuvable");
	    }
	}

	public function createAction(Request $request) {
	    $action = 'index'; 
	    if ($request->isParameter('action')) {
	        $action = $request->getParameter('action');
	    }
	    return $action;
	}

	public function error($errorMessage)
	{
		$this->_view->generate(['errorMessage' => $errorMessage]);
	}
}