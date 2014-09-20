<?php
namespace Vitucho\InputFilter;

use Zend\InputFilter\InputFilter;

class Proveedor extends InputFilter{
    
    public function __construct() {
        
        $ruc = new \Zend\InputFilter\Input('ruc');
        
        $v = new \Zend\Validator\StringLength(array('min'=>11,'max'=>11, 'encoding'=>'UTF-8'));
        $ruc->getValidatorChain()->attach($v);
        
        $f = new \Zend\Filter\StringTrim();
        $ruc->getFilterChain()->attach($f);
        
        $this->add($ruc);
        
        $nombre = new \Zend\InputFilter\Input('nombre');
        $v2 = new \Zend\Validator\StringLength(array('min'=>25,'max'=>50, 'encoding'=>'UTF-8'));
        $nombre->getValidatorChain()->attach($v2);
        $this->add($nombre);

        $email = new \Zend\InputFilter\Input('email');
        $v3 = new \Zend\Validator\EmailAddress();
        $email->getValidatorChain()->attach($v3);
        $this->add($email);

    }
    
}

