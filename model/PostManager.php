<?php
require_once('Manager.php');

class PostManager extends Manager
{
    public function getPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post ORDER BY last_update DESC LIMIT 0, 5');

        return $req->fetchAll();
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post WHERE id = ?');
        $req->execute(array($postId));
        
        if ($req->rowCount() == 1) 
            return $req->fetch();
        else
            throw new Exception("Aucun billet ne correspond à l'identifiant '$postId'");
    }

    public function addPost($author, $title, $lead_paragraph, $content)
    {
        $db = $this->dbConnect();
        $post = $db->prepare('INSERT INTO post (author, title, lead_paragraph, content) VALUES (:author, :title, :lead_paragraph, :content)');
        $affectedLines = $post->execute(array(
            'author'         => $author, 
            'title'          => $title, 
            'lead_paragraph' => $lead_paragraph, 
            'content'        => $content
        ));

        return $affectedLines;
    }

    public function updatePost($postId, $author, $title, $lead_paragraph, $content)
    {
        $db = $this->dbConnect();
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
}