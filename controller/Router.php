<?php
namespace OC\BlogPost\Router;

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
			        if (isset($_GET['id']) && $_GET['id'] > 0) {
		        	    $this->_postController->post();
			        }
			        else {
			            throw new Exception('Aucun identifiant de billet envoyé');
			        }
			    }    
			    elseif ($_GET['action'] == 'postForm') {
			        if (isset($_GET['id']) && $_GET['id'] > 0) {
		        	    $this->_postController->postForm();
			        }
			        else {
			            throw new Exception('Aucun identifiant de billet envoyé');
			        }
			    }
			    elseif ($_GET['action'] == 'newPost') {
		            if ( ! empty($_POST['author']) && ! empty($_POST['title']) && ! empty($_POST['lead_paragraph']) && ! empty($_POST['content'])) {
		                $this->_postController->newPost($_POST['author'], $_POST['title'], $_POST['lead_paragraph'], $_POST['content']);
		            }
		            else {
		                throw new Exception('Tous les champs ne sont pas remplis !');
		            }
			    }	    
			    elseif ($_GET['action'] == 'editPost') {
			        if (isset($_GET['id']) && $_GET['id'] > 0) {
			            if ( ! empty($_POST['author']) && ! empty($_POST['title']) && ! empty($_POST['lead_paragraph']) && ! empty($_POST['content'])) {
			                $this->_postController->editPost($_GET['id'], $_POST['author'], $_POST['title'], $_POST['lead_paragraph'], $_POST['content']);
			            }
			            else {
			                throw new Exception('Tous les champs ne sont pas remplis !');
			            }
			        }
			        else {
			            throw new Exception('Aucun identifiant de billet envoyé');
			        }
			    }
			    else {
			    	throw new Exception("Action non valide");
			    }
			}
			else {
			    $this->_postController->listPosts();
			}
		} 
		catch(Exception $e) {
			$this->error($e->getMessage());
		}
		// header('HTTP/1.0  404 not found');
	}

	private function error($errorMessage) 
	{
		$view = new View($this->_twig, 'error');
		$view->generate(['errorMessage' => $errorMessage]);
	}
}