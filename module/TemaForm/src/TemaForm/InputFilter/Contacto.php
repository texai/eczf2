<?php

namespace TemaForm\InputFilter;

use Zend\InputFilter\InputFilter;

class Contacto extends InputFilter {

    public function __construct() {
        
        $input = new \Zend\InputFilter\Input('nombre');
        
        // Validadores
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>12));
        $v->setMessage('muy corta (%min%)', \Zend\Validator\StringLength::TOO_SHORT);
        $input->getValidatorChain()->attach($v);
        
        $v = new \Zend\Validator\Callback(function($value){
            return $value!='NOPASA';
        });
        $input->getValidatorChain()->attach($v);
        
        // Filtros
        $f = new \Zend\Filter\StringToUpper();
        $input->getFilterChain()->attach($f);
        
        $f = new \Zend\Filter\Word\SeparatorToDash();
        $input->getFilterChain()->attach($f);
        
        $this->add($input);
        
        
        
        $input = new \Zend\InputFilter\Input('email');
        $input->setRequired(false);
        $this->add($input);
        
        
    }
    
}
