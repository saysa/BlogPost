<?php
function getPosts()
{
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=blog_post;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $req = $db->query('SELECT id, author, title, lead_paragraph, content, DATE_FORMAT(last_update, \'%d/%m/%Y à %Hh%imin%ss\') AS last_update FROM post ORDER BY last_update DESC LIMIT 0, 5');

    return $req;
}
