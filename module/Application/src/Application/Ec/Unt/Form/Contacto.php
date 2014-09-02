<?php

namespace Application\Ec\Unt\Form;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Contacto implements ServiceLocatorAwareInterface {
    
    protected $campo;
    protected $serviceLocator;

    public function __construct() {
        
        $this->campo = 'nombre';
        
    }

    public function render() {
        $sl = $this->getServiceLocator();
        $g = $sl->get('ContactoFormGeneradorCampo');
        $this->campo = $g->generar();
        return $this->campo . ": [_____*___]";
    }

    public function setCampo($param) {
//        $sl = $this->getServiceLocator();
//        $almacen = $sl->get('almacenLima');
        $this->campo = $param;
    }
    
    public function getCampo() {
        return $this->campo;
    }

    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }

}
