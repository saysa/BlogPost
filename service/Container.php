<?php

namespace OC\BlogPost\Service;

use OC\BlogPost\Framework\Request;
use OC\BlogPost\Framework\Router;
use OC\BlogPost\Framework\View;
use OC\BlogPost\Model\CommentManager;
use OC\BlogPost\Model\PostManager;

class Container
{
    private $postManager;
    private $commentManager;
    private $mailer;
    private $view;
    private $request;
    private $router;
    private $twig;

    /**
     * @return Router
     */
    public function getRouter()
    {
        if ($this->router === null) {
            $this->router = new Router($this->getView(), $this->getRequest());
        }
        return $this->router;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        if ($this->twig === null) {
            $loader = new \Twig_Loader_Filesystem(__DIR__.'/../view');
            $this->twig = new \Twig_Environment($loader, array(
                'cache' => false
            ));
        }
        return $this->twig;
    }

    public function getRequest()
    {
        if ($this->request === null) {
            $this->request = new Request(array_merge($_GET, $_POST));
        }
        return $this->request;
    }

    public function getView()
    {
        if ($this->view === null) {
            $this->view = new View($this->getTwig());
        }
        return $this->view;
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
                    $this->getView(),
                    $this->getMailer()
                );
                break;
        }

    }

    public function getPostManager()
    {
        if ($this->postManager === null) {
            $this->postManager = new PostManager();
        }
        return $this->postManager;
    }

    public function getCommentManager()
    {
        if ($this->commentManager === null) {
            $this->commentManager = new CommentManager();
        }
        return $this->commentManager;
    }

    public function getMailer()
    {
        if ($this->mailer === null) {
            $this->mailer = new Email();
        }
        return $this->mailer;
    }
}