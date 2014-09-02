<?php

namespace Application\Ec\Unt\Form;

class ContactoAbstractFactory implements \Zend\ServiceManager\AbstractFactoryInterface  {
    
//    protected $campo = 'email';

    public function canCreateServiceWithName(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
        
        if($name=='ecuntformcontacto'){
            return true;
        }
        
    }

    public function createServiceWithName(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName) {
        $f = new Contacto();
        $f->setCampo('Título');
        return $f;
    }

}
