<?php

namespace Vitucho\Form;

use Zend\Form\Form;

class Proveedor extends Form {
    
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        
        $this->setAttribute('class', 'form-signin');
        
        $nombre = new \Zend\Form\Element\Text('nombre');
        $nombre->setLabel('Nombre');
        $this->add($nombre);
        
        $ruc = new \Zend\Form\Element\Number('ruc');
        $ruc->setLabel('RUC');
        $this->add($ruc);
        
        $email = new \Zend\Form\Element\Email('email');
        $email->setLabel('Email');
        $this->add($email);
        
        $enviar = new \Zend\Form\Element\Submit('enviar');
        $enviar->setValue('Nuevo');
        $this->add($enviar);
    }
    
}