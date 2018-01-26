<?php
namespace OC\BlogPost\Controller;

use \OC\BlogPost\Framework\Controller;
use OC\BlogPost\Framework\View;
use \OC\BlogPost\Service\Email;

class HomeController extends Controller
{
    private $mailer;

    public function __construct(\Twig_Environment $twig, View $view, Email $mailer)
    {
        parent::__construct($twig, $view);
        $this->mailer = $mailer;
    }

    public function index()
    {
        $this->generateView('home/home');
    }    

    public function contact()
    {
        $name       = $this->_request->getParameter("name");
        $first_name = $this->_request->getParameter("first_name");
        $email      = $this->_request->getParameter("email");
        $message    = $this->_request->getParameter("message");
        $username   = $first_name.' '.$name;

        $this->mailer->subject('Message de '.$username);
        $this->mailer->from([$email => $username]);
        $this->mailer->message($message);

        if ( ! $this->mailer->send($message)) {
            throw new \Exception("Le mail n'a pas été pas envoyé !");
        } else {
            header('Location: ' .BASE_URL. 'index.php/home');
        }
    }
}