<?php
// namespace OC\BlogPost\Controller;

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
}