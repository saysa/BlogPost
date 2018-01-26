<?php
namespace OC\BlogPost\Framework;

class View 
{
    private $_twig;
    private $_file;

    public function __construct(\Twig_Environment $twig) {
        $this->_twig = $twig;
        $this->_file = 'error';
    }

    public function generate($data = array()) {
        if (file_exists('view/'.$this->_file)) {
            $data['base_url'] = BASE_URL;
            echo $this->_twig->render($this->_file, $data);
        } else {
            throw new \Exception('Fichier ' .$this->_file .' introuvable');
        }
    }

    public function setView($view) {

        $this->_file = $view. 'View.twig';
    }
}