<?php
namespace OC\BlogPost\Controller;

use \OC\BlogPost\Framework\Controller;
use \OC\BlogPost\Model\PostManager;
use \OC\BlogPost\Model\CommentManager;

class PostController extends Controller
{
    private $_postManager;
    private $_commentManager;

    public function __construct(\Twig_Environment $twig) 
    {
        parent::__construct($twig);
        $this->_postManager    = new PostManager();
        $this->_commentManager = new CommentManager();
    }

    public function index()
    {
        $data['posts'] = $this->_postManager->getPosts();
        $this->generateView('listPosts', $data);
    }

    public function post()
    {
        $postId = $this->_request->getParameter("id"); 
        $data['post']     = $this->_postManager->getPost($postId);
        $data['comments'] = $this->_commentManager->getComments($postId);
        $this->generateView('post', $data);
    }

    public function newPostForm()
    {
        $this->generateView('addPostForm');
    }

    public function newPost()
    {
        $author         = $this->_request->getParameter("author");
        $title          = $this->_request->getParameter("title");
        $lead_paragraph = $this->_request->getParameter("lead_paragraph");
        $content        = $this->_request->getParameter("content");

        $affectedLines = $this->_postManager->addPost($author, $title, $lead_paragraph, $content);

        if ($affectedLines === false) {
        	throw new \Exception("Impossible d'ajouter un post !");
        }
        else {
            header('Location: ' .BASE_URL. 'index.php/post');
        }
    }

    public function postForm()
    {
        $postId = $this->_request->getParameter("id");
        $data['post'] = $this->_postManager->getPost($postId);
        $this->generateView('editPostForm', $data);
    }

    public function editPost()
    {
        $postId         = $this->_request->getParameter("id");
        $author         = $this->_request->getParameter("author");
        $title          = $this->_request->getParameter("title");
        $lead_paragraph = $this->_request->getParameter("lead_paragraph");
        $content        = $this->_request->getParameter("content");

        $affectedLines = $this->_postManager->updatePost($postId, $author, $title, $lead_paragraph, $content);

        if ($affectedLines === false) {
            throw new \Exception('Impossible de modifier le post !');
        }
        else {
            header('Location: ' .BASE_URL. 'index.php/post/post/' .$postId);
        }
    }    

    public function deletePost()
    {
        $postId = $this->_request->getParameter("id");

        $affectedLines = $this->_postManager->deletePost($postId);

        if ($affectedLines === false) {
        	throw new \Exception('Impossible de supprimer le post !');
        }
        else {
            header('Location: ' .BASE_URL. 'index.php/post');
        }
    }

    public function newComment()
    {
        $postId         = $this->_request->getParameter("id");
        $author         = $this->_request->getParameter("author");
        $title          = $this->_request->getParameter("title");
        $content        = $this->_request->getParameter("content");

        $affectedLines = $this->_commentManager->addComment($postId, $author, $title, $content);

        if ($affectedLines === false) {
            throw new \Exception("Impossible d'ajouter un commentaire !");
        }
        else {
            header('Location: ' .BASE_URL. 'index.php/post/post/' .$postId);
        }
    }
}