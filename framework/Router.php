<?php
namespace OC\BlogPost\Framework;

/*use \OC\BlogPost\Framework\Request;
use \OC\BlogPost\Framework\View;*/

class Router 
{
	private $_twig;
	private $_view;
	private $_request;

	public function __construct(\Twig_Environment $twig, View $view, Request $request)
	{
		$this->_twig = $twig;
		$this->_view = $view;
		$this->_request = $request;
	}

	public function routeRequest()
	{
		try {
            preg_match('#^/index.php?/(\w+)/?(\w+)?/?(\d+)?#i', $_SERVER['REQUEST_URI'], $matches);
		    if ( ! empty($matches) && isset($matches[1])) { 
		    	$_GET['controller'] = $matches[1];
		    	if (isset($matches[2])) {
		    		$_GET['action'] = $matches[2];
		    	}		    	
		    	if (isset($matches[3])) {
		    		$_GET['id'] = $matches[3];
		    	}
		    }

		    $this->_request->setParameter(array_merge($_GET, $_POST));

		    $controller = $this->createController();
		    $action = $this->createAction();

		    $controller->executeAction($action);
		}
		catch(\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	public function createController() {
	    $controller = "Home";
	    if ($this->_request->isParameter('controller')) {
	        $controller = $this->_request->getParameter('controller');
	        $controller = ucfirst(strtolower($controller));
	    }

	    $controllerClass = $controller. "Controller";
	    $controllerFile = "controller/" . $controllerClass . ".php";
	    $controllerClassWithNamespace = "\OC\BlogPost\Controller\\" .$controllerClass;
	    if (file_exists($controllerFile)) {
	    	require_once($controllerFile);
	        $controller = new $controllerClassWithNamespace($this->_twig, $this->_view);
	        $controller->setRequest($this->_request);
	        return $controller;
	    }
	    else {
	        throw new \Exception("Fichier '". $controllerFile. "' introuvable");
	    }
	}

	public function createAction() {
	    $action = 'index'; 
	    if ($this->_request->isParameter('action')) {
	        $action = $this->_request->getParameter('action');
	    }
	    return $action;
	}

	public function error($errorMessage)
	{
		$this->_view->generate(['errorMessage' => $errorMessage]);
	}
}