<?php
namespace OC\BlogPost\Controller;

require_once('framework/Controller.php');
use \OC\BlogPost\Framework\Controller;

require_once('framework/Configuration.php');
use \OC\BlogPost\Framework\Configuration;

class HomeController extends Controller
{
    private static $_mailerTransport;

    public function __construct(\Twig_Environment $twig) 
    {
        parent::__construct($twig);
    }

    public function index()
    {
        $this->generateView('home');
    }    

    private static function mailerTransport()
    {
        if (SELF::$_mailerTransport === null) {
            $host     = Configuration::get("mailer_host"); 
            $port     = Configuration::get("mailer_port"); 
            $protocol = Configuration::get("mailer_protocol"); 
            $user     = Configuration::get("mailer_user");
            $password = Configuration::get("mailer_password");
            SELF::$_mailerTransport = (new \Swift_SmtpTransport($host, $port, $protocol))
                ->setUsername($user)
                ->setPassword($password);
        }
        return SELF::$_mailerTransport;
    }

    public function contact()
    {
        $name       = $this->_request->getParameter("name");
        $first_name = $this->_request->getParameter("first_name");
        $email      = $this->_request->getParameter("email");
        $message    = $this->_request->getParameter("message");
        $username   = $first_name.' '.$name;

        $message = (new \Swift_Message('Message de '.$username))
          ->setFrom([$email => $username])
          ->setTo('percevalseb@gmail.com')
          ->setBody($message, 'text/html');

        $transport = SELF::mailerTransport();
        
        $mailer = new \Swift_Mailer($transport);

        if ( ! $mailer->send($message)) {
            throw new \Exception("Le mail n'a pas été pas envoyé !");
        } else {
            header('Location: ' .BASE_URL. 'index.php/home');
        }
    }
}