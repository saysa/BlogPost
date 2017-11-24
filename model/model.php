<?php
function getPosts()
{
    $db = dbConnect();
    $req = $db->query('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post ORDER BY last_update DESC LIMIT 0, 5');

    return $req->fetchAll();
}

function getPost($postId)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post WHERE id = ?');
    $req->execute(array($postId));
    
    if ($req->rowCount() == 1) 
        return $req->fetch();
    else
        throw new Exception("Aucun billet ne correspond à l'identifiant '$postId'");
}

function addPost($author, $title, $lead_paragraph, $content)
{
    $db = dbConnect();
    $post = $db->prepare('INSERT INTO post (author, title, lead_paragraph, content) VALUES (:author, :title, :lead_paragraph, :content)');
    $affectedLines = $post->execute(array(
        'author'         => $author, 
        'title'          => $title, 
        'lead_paragraph' => $lead_paragraph, 
        'content'        => $content
    ));

    return $affectedLines;
}

function updatePost($postId, $author, $title, $lead_paragraph, $content)
{
    $db = dbConnect();
    $post = $db->prepare('UPDATE post SET author = :author, title = :title, lead_paragraph = :lead_paragraph, content = :content, last_update = NOW() WHERE id = :id');
    $affectedLines = $post->execute(array(
        'id'             => $postId,
        'author'         => $author, 
        'title'          => $title, 
        'lead_paragraph' => $lead_paragraph, 
        'content'        => $content
    ));

    return $affectedLines;
}

function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=blog_post;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    return $db;
}
