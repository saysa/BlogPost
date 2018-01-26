<?php

namespace OC\BlogPost\Service;

use OC\BlogPost\Framework\Request;
use OC\BlogPost\Framework\Router;
use OC\BlogPost\Framework\View;
use OC\BlogPost\Model\CommentManager;
use OC\BlogPost\Model\PostManager;

class Container
{
    /**
     * @return Router
     */
    public function getRouter()
    {
        return new Router($this->getView(), $this->getRequest());
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

    public function getController($controller)
    {
        switch ($controller) {

            case '\OC\BlogPost\Controller\PostController':
                return new $controller(
                    $this->getTwig(),
                    $this->getView(),
                    $this->getPostManager(),
                    $this->getCommentManager()
                );
                break;
            case '\OC\BlogPost\Controller\HomeController':
                return new $controller(
                    $this->getTwig(),
                    $this->getView()
                );
                break;
        }

    }

    public function getPostManager()
    {
        return new PostManager();
    }

    public function getCommentManager()
    {
        return new CommentManager();
    }
}