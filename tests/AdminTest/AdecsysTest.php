<?php

class AdecsysTest 
    extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Admin\Model\Adecsys
     */
    protected $o;
    
    protected function setUp()
    {
        parent::setUp();
        $this->o = new \Admin\Model\Adecsys();
    }
    
    protected function tearDown()
    {
        parent::tearDown();
        unset($this->o);
    }
    
    
    public function testCreaCat(){
        $this->assertTrue(true);
        $this->assertFalse(false);
    }
    
    public function testCreaCatego(){
        $this->assertTrue(true);
        $this->assertFalse(false);
    }
    
    
    public function testObtenerCantidadAvisosDevuelvaUnInt() {
        $n = $this->o->obtenerCantidadAvisos();
        $this->assertTrue(is_int($n));
    }
    
    public function testobtenerUltimoAvisoDevuelvaUnAviso() {
        $aviso = $this->o->obtenerUltimoAviso();
        $this->assertInstanceOf('Admin\Model\Aviso', $aviso);
    }
    
    /**
     * @dataProvider dataProviderDiaPublicacion
     * @param type $a
     * @param type $b
     * @param type $diaEsperado
     */
    public function testDiaPublicacion($a, $b, $diaEsperado)
    {
        $dia = $this->o->calcularDiaPublicacion($a, $b);
        $msg = sprintf('Se esperaba que el día de publicación fuera %s, pero fue %s',$diaEsperado, $dia);
        $this->assertEquals($diaEsperado, $dia, $msg);
    }

    
    
    public function dataProviderDiaPublicacion(){
        return [
            [4, 3, 5],
            [5, 6, 2],
            [5, 6, 2], // falla
        ];
    }
    
    
}