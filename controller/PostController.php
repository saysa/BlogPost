<?php
namespace OC\BlogPost\Controller;

require_once('model/PostManager.php');
use \OC\BlogPost\Model\PostManager;

use \OC\BlogPost\Framework\View;

class PostController 
{
    private $_twig;
    private $_postManager;

    public function __construct(\Twig_Environment $twig) 
    {
        $this->_twig = $twig;
        $this->_postManager = new PostManager();
    }

    public function listPosts()
    {
        $data['posts'] = $this->_postManager->getPosts();
        $view = new View($this->_twig, 'listPosts');
        $view->generate($data);
    }

    public function post($postId)
    {
        $data['post'] = $this->_postManager->getPost($postId);
        $view = new View($this->_twig, 'post');
        $view->generate($data);
    }

    public function newPost($author, $title, $lead_paragraph, $content)
    {
        $postManager = new PostManager();
        $affectedLines = $postManager->addPost($author, $title, $lead_paragraph, $content);

        if ($affectedLines === false) {
        	throw new \Exception('Impossible d\'ajouter un billet !');
        }
        else {
            header('Location: ' .BASE_URL. 'index.php');
        }
    }

    public function postForm($postId)
    {
        $data['post'] = $this->_postManager->getPost($postId);
        $view = new View($this->_twig, 'postForm');
        $view->generate($data);
    }

    public function editPost($postId, $author, $title, $lead_paragraph, $content)
    {
        $postManager = new PostManager();
        $affectedLines = $postManager->updatePost($postId, $author, $title, $lead_paragraph, $content);

        if ($affectedLines === false) {
        	throw new \Exception('Impossible de modifier le billet !');
        }
        else {
            header('Location: ' .BASE_URL. 'index.php/post/' .$postId);
        }
    }
}