<?php
namespace OC\BlogPost\Model;

require_once('framework/Manager.php');
use \OC\BlogPost\Framework\Manager;

class CommentManager extends Manager
{
    public function getcomments()
    {
        $sql = 'SELECT author, title, content, created_date FROM comment ORDER BY created_date DESC';
        $res = $this->executeRequest($sql);
        
        return $res->fetchAll();
    }

    public function addComment($postId, $author, $title, $content)
    {
        $sql = 'INSERT INTO comment (post_id, author, title, content) VALUES (:post_id, :author, :title, :content)';
        $params = array(
            'post_id' => $postId, 
            'author'  => $author, 
            'title'   => $title, 
            'content' => $content
        );
        $insert = $this->executeRequest($sql, $params);

        return $insert;
    }
}