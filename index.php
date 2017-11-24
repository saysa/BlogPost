<?php
require_once __DIR__. '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem(__DIR__ . '/view');
$twig = new Twig_Environment($loader, array(
    'cache' => false 
));

require('controller/controler.php');

try {
	if (isset($_GET['action'])) {
	    if ($_GET['action'] == 'listPosts') {
	        $posts = listPosts();
	        echo $twig->render('listPostsView.twig', ['posts' => $posts]);
	    }
	    elseif ($_GET['action'] == 'post') {
	        if (isset($_GET['id']) && $_GET['id'] > 0) {
	            $post = post();
	            echo $twig->render('postView.twig', ['post' => $post]);
	        }
	        else {
	            throw new Exception('Aucun identifiant de billet envoyé');
	        }
	    }    
	    elseif ($_GET['action'] == 'postForm') {
	        if (isset($_GET['id']) && $_GET['id'] > 0) {
	            $post = postForm();
	            echo $twig->render('postFormView.twig', ['post' => $post]);
	        }
	        else {
	            throw new Exception('Aucun identifiant de billet envoyé');
	        }
	    }
	    elseif ($_GET['action'] == 'newPost') {
            if ( ! empty($_POST['author']) && ! empty($_POST['title']) && ! empty($_POST['lead_paragraph']) && ! empty($_POST['content'])) {
                newPost($_POST['author'], $_POST['title'], $_POST['lead_paragraph'], $_POST['content']);
            }
            else {
                throw new Exception('Tous les champs ne sont pas remplis !');
            }
	    }	    
	    elseif ($_GET['action'] == 'editPost') {
	        if (isset($_GET['id']) && $_GET['id'] > 0) {
	            if ( ! empty($_POST['author']) && ! empty($_POST['title']) && ! empty($_POST['lead_paragraph']) && ! empty($_POST['content'])) {
	                editPost($_GET['id'], $_POST['author'], $_POST['title'], $_POST['lead_paragraph'], $_POST['content']);
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
	    $posts = listPosts();
	    echo $twig->render('listPostsView.twig', ['posts' => $posts]);
	}
} 
catch(Exception $e) {
	echo $twig->render('errorView.twig', ['errorMessage' => $e->getMessage()]);
}
// header('HTTP/1.0  404 not found');