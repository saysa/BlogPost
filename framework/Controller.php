<?php
namespace OC\BlogPost\Framework;

require_once('Request.php');
use \OC\BlogPost\Framework\Request;

require_once('View.php');
use \OC\BlogPost\Framework\View;


abstract class Controller 
{
    private $_twig;
    private $_action;
    protected $_request;

    public function __construct(\Twig_Environment $twig) 
    {
        $this->_twig = $twig;
    }

    public function setRequest(Request $request)
    {
        $this->_request = $request;
    }

    public function executeAction($action)
    {
        if (method_exists($this, $action)) {
            $this->_action = $action;
            $this->{$this->_action}();
        }
        else {
            $controllerClass = get_class($this);
            throw new \Exception("Action '". $action. "' non définie dans la classe '" .$controllerClass. "'");
        }
    }

    public abstract function index();

    protected function generateView($view, array $data = array())
    {
        /*$controllerClass = get_class($this);
        echo $controllerClass; 
        $controller = str_replace('Controller', '', $controllerClass);*/

        $view = new View($this->_twig, $view);
        $view->generate($data);
    }

}