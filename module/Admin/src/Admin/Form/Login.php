<?php

namespace Admin\Form;

use Zend\Form\Form;

class Login extends Form {
    
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        
        $this->setAttribute('class', 'form-signin');
        
        $login = new \Zend\Form\Element\Text('login');
        $login->setLabel('Login');
        $login->setAttribute('class', 'form-control');
        $login->setAttribute('placeholder', 'Login');
        $login->setAttribute('required',true);
        $login->setAttribute('autofocus',true);
        $this->add($login);
        
        $pwd = new \Zend\Form\Element\Password('pwd');
        $pwd->setLabel('Password');
//        $pwd->setAttribute('class', 'form-control');
        $pwd->setAttribute('placeholder', 'Password');
        $pwd->setAttribute('required',true);
        $this->add($pwd);
        
        $rememberme = new \Zend\Form\Element\Checkbox('rememberme');
        $rememberme->setLabel('Recordar');
        $this->add($rememberme);
        
        $token = new \Zend\Form\Element\Csrf('token');
        $token->setOption('timeout', '600');
        $this->add($token);
        
        $enviar = new \Zend\Form\Element\Submit('enviar');
        $enviar->setValue('LogIn');
        $enviar->setAttribute('class', 'btn btn-lg btn-primary btn-block');
        $this->add($enviar);
        
        
        
    }
    
}