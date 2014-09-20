<?php
namespace HelmutProducto\InputFilter;

use Zend\InputFilter\InputFilter;

class Producto extends InputFilter{
    
    public function __construct() {
        
        $nombre = new \Zend\InputFilter\Input('nombre');
        
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>20, 'encoding'=>'UTF-8'));
        $nombre->getValidatorChain()->attach($v);
        
        $f = new \Zend\Filter\StringTrim();
        $nombre->getFilterChain()->attach($f);
        
        $this->add($nombre);       

    }
    
}

