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
		}
		catch(\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	public function error($errorMessage)
	{
		$this->_view->generate(['errorMessage' => $errorMessage]);
	}
}