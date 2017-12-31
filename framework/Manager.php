<?php 
namespace OC\BlogPost\Framework;

require_once('Configuration.php');
use \OC\BlogPost\Framework\Configuration;

abstract class Manager
{
	private static $_db;
	private static $_mailer;

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

    private static function mailerConnect()
    {
    	if (SELF::$_mailer === null) {
			$host     = Configuration::get("mailer_host"); 
			$user     = Configuration::get("mailer_user");
			$password = Configuration::get("mailer_password");
	    	SELF::$_mailer = (new \Swift_SmtpTransport($host, 465, 'ssl'))
	            ->setUsername($user)
	            ->setPassword($password);
	    }
    	return SELF::$_mailer;
    }
}