<?php

namespace TemaView\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Ejemplo extends AbstractHelper{
    
    public function __invoke($n=null) {
        $num = is_null($n)?rand(1,99):$n;
        $msg = 'Esto es un ejemplo de ViewHelper (%s) <br />';
        return sprintf($msg, $num);
    }
    
}
