<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e){
            $controller = $e->getTarget();
            $sm = $controller->getServiceLocator();
            $controllerClass = get_class($controller);
            $module = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $controller->layout('layout/'. $module); 
            $templatePathResolver = $sm->get('Zend\View\Resolver\TemplatePathStack'); 
            $templatePathResolver->setPaths(array(realpath(dirname(__DIR__).'/'.  $module.'/view')));
            
        },10);
        
        
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    public function getServiceConfig() {
        return array(
            'invokables' => array(
                'ContactoForm' => 'Application\Ec\Unt\Form\Contacto',
                'ContactoFormGeneradorCampo' => 'Application\Ec\Unt\Form\GeneradorCampo',
                'AlmacenLima' => 'Application\Ec\Unt\Model\Almacen\Lima',
                'AlmacenTrujillo' => 'Application\Ec\Unt\Model\Almacen\Trujillo'
            ),
            'initializers' => array(
                'Application\Ec\Unt\Form\ContactoInitializer'
            ),
            'abstract_factories' => array(
                'Application\Ec\Unt\Form\ContactoAbstractFactory'
            ),
            'aliases' => array(
                'cffc' => 'ContactFormFactoryClass'
            ),
            'factories' => array(
                'ContactFormFactory' => function(){
                    $form = new Ec\Unt\Form\Contacto();
                    $form->setCampo('Mensaje');
                    return $form;
                },
                'ContactFormFactoryClass' => 'Application\Ec\Unt\Form\ContactoFactory',
                
            ),
            'shared' => array(
                'ContactFormFactoryClass' => false
            ),            
        );
    }
    
    
    
}
