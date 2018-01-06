<?php 
namespace OC\BlogPost\Framework;

require_once('Configuration.php');
use \OC\BlogPost\Framework\Configuration;

abstract class Manager
{
	private static $_db;

	protected function executeRequest($sql, $params = null) {
		if ($params == null) {
			$req = SELF::dbConnect()->query($sql);    
		}
		else {
		    $req = SELF::dbConnect()->prepare($sql);  
		    $req->execute($params);
		}
		return $req;
	}

    private static function dbConnect()
    {
    	if (SELF::$_db === null) {
			$dsn      = Configuration::get("dsn"); 
			$login    = Configuration::get("db_login");
			$password = Configuration::get("db_password");
	    	SELF::$_db = new \PDO($dsn, $login, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
	    }
    	return SELF::$_db;
    }    
}