<?php
namespace OC\BlogPost\Controller;

require_once('framework/Controller.php');
use \OC\BlogPost\Framework\Controller;

class HomeController extends Controller
{
    public function __construct(\Twig_Environment $twig) 
    {
        parent::__construct($twig);
    }

    public function index()
    {
        $this->generateView('home');
    }    

    public function contact()
    {
		$name       = $this->_request->getParameter("name");
		$first_name = $this->_request->getParameter("first_name");
		$email      = $this->_request->getParameter("email");
		$message    = $this->_request->getParameter("message");
    }
}