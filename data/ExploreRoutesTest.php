<?php

namespace PortalTest\Functional;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ExploreRoutesTest extends AbstractHttpControllerTestCase
{
    protected $validRouteTests = ['LiteralGetPublic','LiteralGetAuth','LiteralJson','Skip'];
    protected $loginUrl = '/login';
    protected $usernameTesting = 'unit.testing';
    protected $pwdTesting = 'unit.testing';

    public function setUp(){
        $this->setApplicationConfig(include APPLICATION_PATH.'/config/application.config.php');
        parent::setUp();
    }
    
    public function testDispatchHome() {
        $this->dispatch('/');
        $this->assertResponseStatusCode(200);
    }
    
    public function testDispatchMiCuenta() {
        $uri = '/mi-cuenta';
        $this->dispatch($uri);
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/login?redirect_to=#CLI-INVOKED');
    }
    
    
    /**
     * Prueba comportamiento de excepciones
     */
    public function testDispatchException() {
        $this->dispatch('/automated-testing-throw-exception');
        $this->assertResponseStatusCode(500);
        
        $xpathQuery = "//template[@id='AUTOMATED_TESTING_TOKEN']";
        $this->assertXpathQuery($xpathQuery);
        $this->assertXpathQueryCount($xpathQuery,1);
        $cssQuery = "template#AUTOMATED_TESTING_TOKEN";
        $this->assertQuery($cssQuery);
        $this->assertQueryCount($cssQuery,1);
        
        $this->assertApplicationException('Exception');
    }

    
    /**
     * Prueba comportamiento de un error 404
     */
    public function testDispatch404() {
        $this->dispatch('/automated-testing-error-four-oh-four');
        $this->assertResponseStatusCode(404);
        
        $xpathQuery = "//template[@id='AUTOMATED_TESTING_TOKEN']";
        $this->assertXpathQuery($xpathQuery);
        $this->assertXpathQueryCount($xpathQuery,1);
        $cssQuery = "template#AUTOMATED_TESTING_TOKEN";
        $this->assertQuery($cssQuery);
        $this->assertQueryCount($cssQuery,1);
    }
    

    /**
     * Prueba que una ruta tengan la configuración de testing.
     * 
     * Usa un proveedor de datos:
     * @dataProvider rutasDePrimerNivelDataProvider
     */
    public function testConfiguracionTestDeRutas($name, $route) {
        
        $msg1 = sprintf("Ruta '%s' no tiene configuración ['tests']", $name);
        $this->assertArrayHasKey('tests', $route,$msg1);

        $routeTests = $route['tests'];
        $msg2 = sprintf("['tests'] de ruta '%s' debe ser un array", $name);
        $this->assertTrue(is_array($routeTests),$msg2);
        
        $this->assertGreaterThanOrEqual(1,count($routeTests));
        
        foreach($routeTests as $routeTest){
            $msg3 = sprintf("'%s' no es un RouterTest válido",$routeTest);
            $this->assertTrue(in_array($routeTest, $this->validRouteTests),$msg3);
        }
        
    }
    
    /**
     * Ejecuta los tests de rutas.
     * 
     * Usa un proveedor de datos:
     * @dataProvider rutasDePrimerNivelDataProvider
     */
    public function testEjecucionTestDeRutas($name, $route) {

        if(!array_key_exists('tests', $route)){
            $this->markTestSkipped();
        }
        
        $routeTests = $route['tests'];
        
        foreach($routeTests as $routeTest){
            $method = '_call' . $routeTest;
            if(is_callable([$this,$method])){
                $this->$method($name, $route);
            }else{
                $this->fail('No se encuentra el método '.$method);
            }
        }
        
    }
    
    /**
     * Devuelve todas las rutas de primer nivel del módulo Portal
     * 
     * @return array
     */
    public function rutasDePrimerNivelDataProvider() {
        $routesApp  = include APPLICATION_PATH.'/module/Portal/config/routes.php';
        $testDataSets = [];
        foreach($routesApp as $name => $route){
//            if(!in_array($name, ['home','participa','ganadores','mi-cuenta','suscribe-newsletter'])){continue;}
            $testDataSet = [$name,$route];
            $testDataSets[] = $testDataSet;
        }
        return $testDataSets;
    }    
    
    private function _callLiteralGetPublic($name, $route){
        
        /**
         * Asume que el tipo es una cadena con el nombre corto de la clase
         * y no el FQCN ni el objeto.
         */
        $this->assertEquals('Literal', $route['type']);
        if($route['type']!='Literal'){
            $this->markTestSkipped();
        }
        
        $url = $route['options']['route'];
        $this->dispatch($url, 'GET');
        $this->assertModuleName('Portal');
        $this->assertMatchedRouteName($name);
        $this->assertNotRedirect();
        $this->assertResponseStatusCode(200);
        $this->assertNotXpathQuery("//template[@id='AUTOMATED_TESTING_TOKEN']");
        $this->assertNotQuery("template#AUTOMATED_TESTING_TOKEN");
    }
    
    private function _callLiteralGetAuth($name, $route){
        /**
         * Asume que el tipo es una cadena con el nombre corto de la clase
         * y no el FQCN ni el objeto.
         */
        $this->assertEquals('Literal', $route['type']);
        if($route['type']!='Literal'){
            $this->markTestSkipped();
        }
        
        $url = $route['options']['route'];
        
        /**
         * Aun no estoy logeado, me tiene que hacer 
         * un redirect al formulario de login
         */
        $this->dispatch($url, 'GET');
        $this->assertModuleName('Portal');
        $this->assertMatchedRouteName($name);
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/login?redirect_to=#CLI-INVOKED');

        /**
         * Me logeo
         */
        $this->dispatch($this->loginUrl, 'POST',array(
            'username' => $this->usernameTesting,
            'pwd' => $this->pwdTesting,
        ));
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        
        /**
         * Me lleva al home (limpiar flash messengers)
         */
        $this->reset(true);
        $this->dispatch('/', 'GET');
        $this->assertNotRedirect();

        /**
         * Ya estoy logueado, puedo ver mi nombre en la barra
         */
        $this->reset(true);
        $this->dispatch($url, 'GET');
        $this->assertModuleName('Portal');
        $this->assertMatchedRouteName($name);
        $this->assertResponseStatusCode(200);
        $this->assertNotRedirect();
        $this->assertXpathQuery("//a[@data-unit-testing-tag='nick']");
        $this->assertXpathQueryContentContains("//a[@data-unit-testing-tag='nick']",$this->usernameTesting);
        $this->assertQuery('a[data-unit-testing-tag="nick"]');
        $this->assertQueryContentContains('a[data-unit-testing-tag="nick"]',$this->usernameTesting);

    }
    
    private function _callLiteralJson($name, $route){
        
        /**
         * Asume que el tipo es una cadena con el nombre corto de la clase
         * y no el FQCN ni el objeto.
         */
        $this->assertEquals('Literal', $route['type']);
        if($route['type']!='Literal'){
            $this->markTestSkipped();
        }
        
        $url = $route['options']['route'];
        
        foreach(['GET', 'POST'] as $method){
            /**
             * Hacer un $method en la URL debe devolver un JSON válido
             */
            $this->dispatch($url, $method);
            $this->assertModuleName('Portal');
            $this->assertMatchedRouteName($name);
            $json = $this->getResponse()->getContent();
            $jso = json_decode($json);
            $msg = sprintf('Hacer %s en %s debe devolver JSON válido', $method, $url);
            $this->assertNotNull($jso, $msg);
            $this->reset(true);
        }
        
        

    }

    private function _callSkip($name, $route){
        /**
         * Este routeTest no hace nada.
         * Es útil para las rutas que necesitan escribirles una prueba específica
         * Pero si la ruta es Literal, si debe tener un route Test
         */
//        $this->markTestSkipped('Ruta con test Skip');
        $this->assertContains('Skip', $route['tests']);
    }
    
    protected function tearDown() {
        parent::tearDown();
        
    }

}
