<?php
namespace OC\BlogPost\Model;

require_once('framework/Manager.php');
use \OC\BlogPost\Framework\Manager;

class PostManager extends Manager
{
    public function getPosts()
    {
        $sql = 'SELECT id, author, title, lead_paragraph, content, last_update_date FROM post ORDER BY last_update_date DESC LIMIT 0, 5';
        $posts = $this->executeRequest($sql);
        
        return $posts->fetchAll();
    }

    public function getPost($postId)
    {
        $sql = 'SELECT id, author, title, lead_paragraph, content, created_date, last_update_date FROM post WHERE id = ?';
        $params = array($postId);
        $post = $this->executeRequest($sql, $params);

        if ($post->rowCount() == 1) 
            return $post->fetch();
        else
            throw new \Exception("Aucun post ne correspond à l'identifiant '" .$postId. "'");
    }

    public function addPost($author, $title, $lead_paragraph, $content)
    {
        $sql = 'INSERT INTO post (author, title, lead_paragraph, content) VALUES (:author, :title, :lead_paragraph, :content)';
        $params = array(
            'author'         => $author, 
            'title'          => $title, 
            'lead_paragraph' => $lead_paragraph, 
            'content'        => $content
        );
        $affectedLines = $this->executeRequest($sql, $params);

        return $affectedLines;
    }

    public function updatePost($postId, $author, $title, $lead_paragraph, $content)
    {
        $sql = 'UPDATE post SET author = :author, title = :title, lead_paragraph = :lead_paragraph, content = :content, last_update_date = NOW() WHERE id = :id';
        $params = array(
            'id'             => $postId,
            'author'         => $author, 
            'title'          => $title, 
            'lead_paragraph' => $lead_paragraph, 
            'content'        => $content
        );
        $affectedLines = $this->executeRequest($sql, $params);

        return $affectedLines;
    }
}