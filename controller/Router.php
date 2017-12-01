<?php
namespace OC\BlogPost\Controller;

require('PostController.php');
use \OC\BlogPost\Controller\PostController;

require('view/View.php');
use \OC\BlogPost\View\View;

class Router 
{
	private $_twig;
	private $_postController;

	public function __construct($twig) 
	{
		$this->_twig = $twig;
	    $this->_postController = new PostController($twig);
	}

	public function routeRequest()
	{
		try {
			preg_match('#^/BlogPost/index.php?/(\w+)/?(\d+)?#i', $_SERVER['REQUEST_URI'], $matches);
		    if ( ! empty($matches) && isset($matches[1])) { 
		    	$_GET['action'] = $matches[1];
		    	if (isset($matches[2])) {
		    		$_GET['id'] = $matches[2];
		    	}
		    } 

			if (isset($_GET['action'])) {
			    if ($_GET['action'] == 'listPosts') {
		    	    $this->_postController->listPosts();
			    }
			    elseif ($_GET['action'] == 'post') {
			        $postId = intval($this->getParameter($_GET, 'id'));
			        if ($postId != 0) {
			            $this->_postController->post($postId);
			        }
			        else
			            throw new \Exception("Identifiant de billet non valide");
			    }
			    elseif ($_GET['action'] == 'postForm') {
			    	$postId = intval($this->getParameter($_GET, 'id'));
			    	if ($postId != 0) {
			    	    $this->_postController->postForm($postId);
			    	}
			    	else
			    	    throw new \Exception("Identifiant de billet non valide");
			    }
			    elseif ($_GET['action'] == 'newPost') {
			    	$author = $this->getParameter($_POST, 'author');
			    	$title = $this->getParameter($_POST, 'title');
			    	$lead_paragraph = $this->getParameter($_POST, 'lead_paragraph');
			    	$content = $this->getParameter($_POST, 'content');
			    	$this->_postController->newPost($author, $title, $lead_paragraph, $content);
		            // throw new \Exception('Tous les champs ne sont pas remplis !');
			    }	    
			    elseif ($_GET['action'] == 'editPost') {   
			    	$postId = intval($this->getParameter($_GET, 'id'));
			    	if ($postId != 0) {
			    		$author = $this->getParameter($_POST, 'author');
			    		$title = $this->getParameter($_POST, 'title');
			    		$lead_paragraph = $this->getParameter($_POST, 'lead_paragraph');
			    		$content = $this->getParameter($_POST, 'content');
			    		$this->_postController->editPost($postId, $author, $title, $lead_paragraph, $content);
			    		// throw new \Exception('Tous les champs ne sont pas remplis !');
			    	}
			    	else
			    	    throw new \Exception("Identifiant de billet non valide");
			    }
			    else {
			    	throw new \Exception("404 : La page que vous cherchez n'existe pas");
			    	// header('HTTP/1.0  404 not found');
			    }
			}
			else {
			    $this->_postController->listPosts();
			}
		} 
		catch(\Exception $e) {
			$this->error($e->getMessage());
		}
	}

	private function getParameter($array, $key) {
	  	if (isset($array[$key])) {
	  		if ( ! empty($array[$key])) {
	  			return $array[$key];
	  		}
	    	throw new \Exception("Paramètre '" .$key. "' vide");
	  	}
	    throw new \Exception("Paramètre '" .$key. "' absent");
	}

	private function error($errorMessage) 
	{
		$view = new View($this->_twig, 'error');
		$view->generate(['errorMessage' => $errorMessage]);
	}
}