<?php

namespace Admin\Form;

use Zend\Form\Form;

class Categoria extends Form {
    
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        
        $this->setAttribute('class', 'form-signin');
        
        $nombre = new \Zend\Form\Element\Text('nombre');
        $nombre->setLabel('Nombre');
        $this->add($nombre);
        
        $enviar = new \Zend\Form\Element\Submit('enviar');
        $enviar->setValue('Nuevo');
        $this->add($enviar);
        
        
        
    }
    
}