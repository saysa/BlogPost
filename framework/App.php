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
    }

    private function init()
    {
        $this->container = new Container();
    }
}