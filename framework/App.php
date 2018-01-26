<?php

namespace OC\BlogPost\Framework;

use OC\BlogPost\Service\Container;

class App
{
    /**
     * @var Container
     */
    private $container;

    public function __construct()
    {
        $this->init();
        $this->run();
    }

    private function run()
    {
        $this->container->getRouter()->routeRequest();

        $controller = $this->createController();
        $action = $this->createAction();

        $controller->executeAction($action);
    }

    private function init()
    {
        $this->container = new Container();
    }

    public function createController() {
        $controller = "Home";
        if ($this->container->getRequest()->isParameter('controller')) {
            $controller = $this->container->getRequest()->getParameter('controller');
            $controller = ucfirst(strtolower($controller));
        }

        $controllerClass = $controller. "Controller";
        $controllerFile = "controller/" . $controllerClass . ".php";
        $controllerClassWithNamespace = "\OC\BlogPost\Controller\\" .$controllerClass;
        if (file_exists($controllerFile)) {
            require_once($controllerFile);
            $controller = $this->container->getController($controllerClassWithNamespace);
            $controller->setRequest($this->container->getRequest());
            return $controller;
        }
        else {
            throw new \Exception("Fichier '". $controllerFile. "' introuvable");
        }
    }

    public function createAction() {
        $action = 'index';
        if ($this->container->getRequest()->isParameter('action')) {
            $action = $this->container->getRequest()->getParameter('action');
        }
        return $action;
    }
}