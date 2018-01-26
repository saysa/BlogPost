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


            $controller = $this->container->getRouter()->createController($this->container->getRequest());
            $action = $this->container->getRouter()->createAction($this->container->getRequest());

            $controller->executeAction($action);
        }
        catch(\Exception $e) {
            $this->container->getRouter()->error($e->getMessage());
        }
    }

    private function init()
    {
        $this->container = new Container();
    }
}