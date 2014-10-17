<?php

class Cliente {}
class Aviso {}
class AvisoUrbania {}

class Adecsys {
    
    public function obtenerCantidadAvisos(){
        return rand(0,99). ' ';
    }
    
    public function obtenerUltimoAviso(){
        $a = new AvisoUrbania();
        // ...
        return $a;
    }
    
    public function registrarCliente(Cliente $c){
        // ...
    }
    
}


// probar que:
// - obtenerCantidadAvisos devuelva un int
// - obtenerUltimoAviso devuelva un Aviso
// - registrarCliente agregue una fila a la tabla cliente

class AdecsysTest {
    
    public function setUp(){
        $this->o = new Adecsys();
    }
    
    public function tearDown(){
        unset($this->o);
    }
    
    
    
    public function testObtenerCantidadAvisosDevuelvaUnInt(){
        
        $o = new Adecsys();
        $res = $o->obtenerCantidadAvisos();
       
	// Assertion 
        if(!is_int($res)){
            echo 'ERROR:'.__FUNCTION__.PHP_EOL;
        }
    }
    
    public function testobtenerUltimoAvisoDevuelvaUnAviso(){
        $o = new Adecsys();
        $res = $o->obtenerUltimoAviso();
        if(! $res instanceof Aviso){
            echo 'ERROR:'.__FUNCTION__.PHP_EOL;
        }
    }
    
    public function runTest()
    {
        $this->testObtenerCantidadAvisosDevuelvaUnInt();
        $this->testobtenerUltimoAvisoDevuelvaUnAviso();
    }
    
}

$t = new AdecsysTest();
$t->runTest();
