<?php

class IndexControllerTest 
    extends \Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase
{
    
    public function setUp(){
        $this->setApplicationConfig(include APPLICATION_PATH.'/config/application.config.php');
        parent::setUp();
    }
    
    
    public function testOk()
    {
        $this->assertEquals(1, 1);
    }
    
    public function testLogin()
    {
        $this->dispatch('/admin/index/login');
        
        $this->assertModuleName('Admin');
        $this->assertResponseStatusCode(200);
        $this->assertActionName('login');
        
        $this->assertQueryContentContains('#titulo-login', 'Please sign in');
        $this->assertQueryCount('form>input', 3);
        
//        $this->markTestSkipped();
        
        if(1){
//            $this->fail('fallo por que...');
        }
        
        
    }
    
    public function testAdminHomeNoLogueado()
    {
        $this->dispatch('/admin');
        $this->assertModuleName('Admin');
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->assertRedirectTo('/admin/index/login');
    }
    
    public function testAdminHomeLogueado()
    {
        $this->login();
        
        
        $this->assertResponseStatusCode(302);
        $this->assertRedirect();
        $this->reset(true);
        
        
        $this->dispatch('/admin');
        $this->assertModuleName('Admin');
        $this->assertResponseStatusCode(200);
        $this->assertNotRedirect();
    }
    
    protected function login()
    {
        $this->dispatch('/admin/index/login', 'POST',array(
            'login' => 'admin',
            'pwd' => '123456',
            'rememberme' => '0',
        ));
    }
    
    
    
}