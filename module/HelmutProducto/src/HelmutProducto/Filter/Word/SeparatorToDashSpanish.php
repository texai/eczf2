<?php
namespace HelmutProducto\Filter\Word;

use Zend\Filter\Word\SeparatorToDash;

class SeparatorToDashSpanish extends SeparatorToDash {
    
    public function filter($value) {
        $res = parent::filter($value);
        return str_replace(
                array('á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ'),
                array('a','e','i','o','u','n','A','E','I','O','U','N'),
                $res
        );
    }
    
}