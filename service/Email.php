<?php 
namespace OC\BlogPost\Service;

use \OC\BlogPost\Framework\Configuration;

class Email 
{
	private static $_transport;
	private static $_transportUser;
	private $_mailer;
	private $_subject;
	private $_from;
	private $_to;
	private $_message;

	public function __construct() 
	{
	    $this->mailer();
	}

	private static function transportUser($user)
	{
		SELF::$_transportUser = $user;
	}

	private static function transport()
	{
	    if (SELF::$_transport === null) {
	        $host     = Configuration::get("mailer_host"); 
	        $port     = Configuration::get("mailer_port"); 
	        $protocol = Configuration::get("mailer_protocol"); 
	        $user     = Configuration::get("mailer_user");
	        $password = Configuration::get("mailer_password");
	        SELF::$_transport = (new \Swift_SmtpTransport($host, $port, $protocol))
	            ->setUsername($user)
	            ->setPassword($password);

	       	SELF::transportUser($user);
	    }
	    return SELF::$_transport;
	}

	private function mailer()
	{
		$transport = SELF::transport();
		$this->_mailer = new \Swift_Mailer($transport);
	}

	public function subject($subject)
	{
		$this->_subject = $subject;
	}	

	public function from($from)
	{
		$this->_from = $from;
	}	

	public function to($to)
	{
		$this->_to = $to;
	}	

	public function message($message)
	{
		$this->_message = $message;
	}

	private function createMessage()
	{
		if ( ! ($this->_subject === null || $this->_from === null || $this->_message === null)) {
			if ($this->_to === null) {
				$this->to(SELF::$_transportUser);
			}
			return (new \Swift_Message($this->_subject))
					  ->setFrom($this->_from)
					  ->setTo($this->_to)
					  ->setBody($this->_message, 'text/html');
		} else {
            throw new \Exception("Il manque des paramètres à la configuration du mail !");
        }
	}

	public function send($message)
	{
		$message = $this->createMessage();
		$this->_mailer->send($message);
	}
}