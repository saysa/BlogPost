<?php
require_once('model/PostManager.php');

use \OC\BlogPost\Model\PostManager;

function listPosts()
{
    $postManager = new PostManager();
    return $postManager->getPosts();
}

function post()
{
    $postManager = new PostManager();
    return $postManager->getPost($_GET['id']);
}

function newPost($author, $title, $lead_paragraph, $content)
{
    $postManager = new PostManager();
    $affectedLines = $postManager->addPost($author, $title, $lead_paragraph, $content);

    if ($affectedLines === false) {
    	throw new Exception('Impossible d\'ajouter un billet !');
    }
    else {
        header('Location: ' .BASE_URL. 'index.php');
    }
}

function postForm()
{
    $postManager = new PostManager();
    return $postManager->getPost($_GET['id']);
}

function editPost($postId, $author, $title, $lead_paragraph, $content)
{
    $postManager = new PostManager();
    $affectedLines = $postManager->updatePost($postId, $author, $title, $lead_paragraph, $content);

    if ($affectedLines === false) {
    	throw new Exception('Impossible de modifier le billet !');
    }
    else {
        header('Location: ' .BASE_URL. 'index.php/post/' .$postId);
    }
}

/*function error($errorMessage) {
    require 'view/errorView.php';
}*/