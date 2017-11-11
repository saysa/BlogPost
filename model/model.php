<?php
function getPosts()
{
    $db = dbConnect();
    $req = $db->query('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post ORDER BY last_update DESC LIMIT 0, 5');

    return $req;
}

function getPost($postId)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post WHERE id = ?');
    $req->execute(array($postId));
    $post = $req->fetch();

    return $post;
}

function addPost($author, $title, $lead_paragraph, $content)
{
    $db = dbConnect();
    $post = $db->prepare('INSERT INTO post (author, title, lead_paragraph, content) VALUES (?, ?, ?, ?)');
    $affectedLines = $post->execute(array($author, $title, $lead_paragraph, $content));

    return $affectedLines;
}

function updatePost($postId, $author, $title, $lead_paragraph, $content)
{
    $db = dbConnect();
    $post = $db->prepare('UPDATE post SET author = ?, title = ?, lead_paragraph = ?, content = ?, last_update = NOW() WHERE id = ?');
    $affectedLines = $post->execute(array($author, $title, $lead_paragraph, $content, $postId));

    return $affectedLines;
}

function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=blog_post;charset=utf8', 'root', '');
    return $db;
}
