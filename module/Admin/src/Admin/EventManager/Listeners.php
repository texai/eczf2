<?php

namespace Admin\EventManager;

use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

class Listeners implements SharedListenerAggregateInterface {
    
    private $listeners = array();
    
    public function attachShared(SharedEventManagerInterface $events)
    {
         $this->listeners[] = $events->attach('Admin\Controller\CategoriaController', 'dispatch', function(MvcEvent $e){
            $file = __DIR__.'/../../../em.log';
            $logw = new \Zend\Log\Writer\Stream($file);
            $log = new \Zend\Log\Logger;
            $log->addWriter($logw);
            $log->log(4, 'Dispatch! de CatController');
            
            $controller = $e->getTarget();
            $log->log(4, get_class($controller));
            
        });
        
        
        $this->listeners[] = $events->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this,'controlarAccesoAutenticado'));
        
        $this->listeners[] = $events->attach(
            'Admin\Controller\CategoriaController',
            'nuevo',
            array(
                new \Admin\Service\ProductoService,
                'onNuevaSubasta'
            )
        );
        
    }

    
    
    
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach('Zend\Mvc\Controller\AbstractActionController', $listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    public function controlarAccesoAutenticado($e){
//            $file = __DIR__.'/em.log';
//            $logw = new \Zend\Log\Writer\Stream($file);
//            $log = new \Zend\Log\Logger;
//            $log->addWriter($logw);
//            
//            $log->log(4, 'Dispatch');
            
            $controller = $e->getTarget();
            $paramsFromRoute = $controller->params()->fromRoute();
            $action = $paramsFromRoute['action'];
//            
            $sm = $controller->getServiceLocator();
            $auth = $sm->get('AuthService');
            if(!$auth->hasIdentity()){
                if(
                        $paramsFromRoute['controller'].'::'.$paramsFromRoute['action'] !=
                        'Admin\Controller\Index::login'
                   ){
                    $controller->redirect()->toUrl('/admin/index/login');
                }
            }
//            $log->log(4, print_r($paramsFromRoute,true));
        }
    
    
}