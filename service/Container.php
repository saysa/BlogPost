<?php

namespace OC\BlogPost\Service;

use OC\BlogPost\Framework\Request;
use OC\BlogPost\Framework\Router;
use OC\BlogPost\Framework\View;

class Container
{
    /**
     * @return Router
     */
    public function getRouter()
    {
        return new Router($this->getTwig(), $this->getView());
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__.'/../view');
        return new \Twig_Environment($loader, array(
            'cache' => false
        ));
    }

    public function getRequest()
    {
        return new Request(array_merge($_GET, $_POST));
    }

    public function getView()
    {
        return new View($this->getTwig());
    }
}