<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaAcl;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        /**
         * facilita el acceso al acl desde los controladores
         */
        $eventManager->getSharedManager()
                ->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $sm = $controller->getServiceLocator();
            $acl = $sm->get('tema-acl/acl');
            $controller->acl = $acl;
//            $e->getViewModel()->setVariable('acl', 'ssssss');
            
        }, 190);        
        
        
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
            'factories' => array(
                'stest' => function(){
                    $o = new \stdClass();
                    $o->texto = 'prueba';
                    return $o;
                },
//                'tema-acl/acl' => 'Admin\Acl\Factory',
                'tema-acl/acl' => function ($param) {
            
                    $acl = new \Zend\Permissions\Acl\Acl();
                    
                    // Si puede ser dinámico
                    $acl->addRole('admin');
                    $acl->addRole('manager');
                    $acl->addRole('mkt');
                    $acl->addRole('ventas');
                    
                    // No puede ser dinámico
//                    $acl->addResource('mantenimientos');
                    $acl->addResource('categoria');
                    $acl->addResource('producto');
                    $acl->addResource('proveedor');
                    $acl->addResource('reportes');
                    $acl->addResource('config');
                    
                    // El permiso (verbo) NO puede ser dinámico
                    // La lista de relaciones entre rol,recurso
                    // y permiso SI puede ser dinámico
                    $acl->allow('ventas','producto','vender');
                    $acl->deny('ventas','producto','borrar');
                    
                    $acl->allow('admin');
//                    $acl->deny('admin', 'producto', 'vender');
                    
                    $acl->allow('manager', 'categoria', 'ver');
                    $acl->allow('manager', 'categoria', 'crear');
                    $acl->deny('manager', 'categoria', 'editar');
                    $acl->allow('manager', 'categoria', 'borrar');
                    $acl->allow('mkt', 'producto', 'ver');
                    $acl->allow('ventas', 'producto', 'ver');
                    $acl->allow('ventas', 'categoria', 'ver');
                    $acl->allow('ventas', 'producto', 'vender');
                    
//                    var_dump('Test: ACL');
//                    var_dump($acl->isAllowed('admin', 'producto', 'vender'));
                    
                    if($acl->isAllowed('ventas', 'producto', 'exportar')){
                        // ...
                    }
                    
                    return $acl;
                }
            ),
        );
    }    
}
