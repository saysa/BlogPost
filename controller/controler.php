<?php
require('model/model.php');

function listPosts()
{
    $posts = getPosts();
    
    require('view/listPostsView.php');
}

function post()
{
    $post = getPost($_GET['id']);

    require('view/postView.php');
}

function newPost($author, $title, $lead_paragraph, $content)
{
    $affectedLines = addPost($author, $title, $lead_paragraph, $content);

    if ($affectedLines === false) {
    	throw new Exception('Impossible d\'ajouter un billet !');
    }
    else {
        header('Location: index.php');
    }
}

function postForm()
{
    $post = getPost($_GET['id']);

    require('view/postFormView.php');
}

function editPost($postId, $author, $title, $lead_paragraph, $content)
{
    $affectedLines = updatePost($postId, $author, $title, $lead_paragraph, $content);

    if ($affectedLines === false) {
    	throw new Exception('Impossible de modifier le billet !');
    }
    else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}