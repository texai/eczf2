<?php

namespace Application\Ec\Unt\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

//use Zend\Form\Form;

class ContactoFactory implements FactoryInterface {
    
    protected $campo = 'email';

    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        $form = new Contacto();
        $form->setCampo($this->campo);
//        $form->setServiceLocator($serviceLocator);
        return $form;
    }

}
