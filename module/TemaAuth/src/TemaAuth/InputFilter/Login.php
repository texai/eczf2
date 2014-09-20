<?php

namespace TemaAuth\InputFilter;

use Zend\InputFilter\InputFilter;

class Login extends InputFilter {

    public function __construct() {
        
        $input = new \Zend\InputFilter\Input('usuario');
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>50));
        $input->getValidatorChain()->attach($v);
        $input->setRequired(true);
        $this->add($input);
        
        
        $input = new \Zend\InputFilter\Input('pwd');
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>50));
        $input->getValidatorChain()->attach($v);
        $input->setRequired(true);
        $this->add($input);
        
        
        
    }
    
}
