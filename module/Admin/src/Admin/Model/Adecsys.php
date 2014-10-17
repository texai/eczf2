<?php

namespace Admin\Model;

class Cliente {}
class Aviso {}
class AvisoUrbania {}

class Adecsys {
    
    public function obtenerCantidadAvisos(){
        return rand(0,99);
    }
    
    public function obtenerUltimoAviso(){
        $a = new Aviso();
        // ...
        return $a;
    }
    
    public function calcularDiaPublicacion($a, $b){
        return ($a*$b) % 7;
    }
   
    
}

