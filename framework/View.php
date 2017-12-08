<?php
namespace OC\BlogPost\Framework;

class View 
{
    private $_twig;
    private $_file;

    public function __construct(\Twig_Environment $twig, $action) {
        $this->_twig = $twig;
        $this->_file = $action. 'View.twig';
    }

    public function generate($data) {
        if (file_exists('view/' .$this->_file)) { 
            $data['base_url'] = BASE_URL;
            echo $this->_twig->render($this->_file, $data);
        } else {
            throw new Exception('Fichier ' .$this->_file .' introuvable');
        }
    }
}