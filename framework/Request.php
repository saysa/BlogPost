<?php
namespace OC\BlogPost\Framework;

class Request 
{
    private $_parameters;

    public function __construct(array $parameters) {
        $this->_parameters = $parameters;
    }

    public function isParameter($name) {
        return (isset($this->_parameters[$name]) && $this->_parameters[$name] != "");
    }

    public function getParameter($name) {
        if ($this->isParameter($name)) {
            return $this->_parameters[$name];
        }
        else {
            throw new \Exception("Paramètre '".$name."' absent de la requête");
        }
    }
}

