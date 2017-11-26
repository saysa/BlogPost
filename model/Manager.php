<?php 
namespace OC\BlogPost\Model;

abstract class Manager
{
	private $bdd;

	protected function executeRequest($sql, $params = null) {
		if ($params == null) {
			$req = $this->dbConnect()->query($sql);    
		}
		else {
		    $req = $this->dbConnect()->prepare($sql);  
		    $req->execute($params);
		}
		return $req;
	}

    protected function dbConnect()
    {
    	if ($this->bdd == null) {
	    	$this->bdd = new \PDO('mysql:host=localhost;dbname=blog_post;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
	    }
    	return $this->bdd;
    }
}