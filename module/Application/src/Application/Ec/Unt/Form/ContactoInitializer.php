<?php

namespace Application\Ec\Unt\Form;

class ContactoInitializer implements \Zend\ServiceManager\InitializerInterface {
    
    public function initialize($instance, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        
        if($instance instanceof Contacto){
            $instance->setServiceLocator($serviceLocator);
            $instance->setCampo('Teléfono '.$instance->getCampo());
        }
        
    }

}
