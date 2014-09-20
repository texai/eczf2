<?php

namespace TemaAuth\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Login extends Form {

    public function __construct($name = null) {
        
        parent::__construct('login');
        
        $e = new Element\Text('usuario');
        $e->setLabel('Usuario');
        $this->add($e);
        
        $e = new Element\Password('pwd');
        $e->setLabel('Password');
        $this->add($e);
        
        $e = new Element\Submit('enviar');
        $e->setValue('Enviar');
        $this->add($e);
    }

}