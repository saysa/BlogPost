<?php
namespace OC\BlogPost\Model;

use \OC\BlogPost\Framework\Manager;

class PostManager extends Manager
{
    public function getPosts()
    {
        $sql = 'SELECT id, author, title, lead_paragraph, content, last_update_date FROM post ORDER BY last_update_date DESC LIMIT 0, 5';
        $res = $this->executeRequest($sql);
        
        return $res->fetchAll();
    }

    public function getPost($postId)
    {
        $sql = 'SELECT id, author, title, lead_paragraph, content, created_date, last_update_date FROM post WHERE id = ?';
        $params = array($postId);
        $res = $this->executeRequest($sql, $params);

        if ($res->rowCount() == 1) 
            return $res->fetch();
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
        $insert = $this->executeRequest($sql, $params);

        return $insert;
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
        $update = $this->executeRequest($sql, $params);

        if ($update->rowCount() == 1) 
            return $update;
        else
            throw new \Exception("Aucun post ne correspond à l'identifiant '" .$postId. "'");
    }

    public function deletePost($postId)
    {
        $sql = 'DELETE FROM post WHERE id = ?';
        $params = array($postId);
        $delete = $this->executeRequest($sql, $params);

        if ($delete->rowCount() == 1) 
            return $delete;
        else
            throw new \Exception("Aucun post ne correspond à l'identifiant '" .$postId. "'");
    }
}