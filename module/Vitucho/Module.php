<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Vitucho;

use Admin\Model\Categoria;
use Admin\Model\CategoriaTable;
use Admin\Model\Producto;
use Admin\Model\ProductoTable;
use Admin\Model\Proveedor;
use Admin\Model\ProveedorTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
    

    /**
     * Carga la configuración de servicios del módulo Vitucho
     */
    public function getServiceConfig() {
        return array(
            'factories' => array(
                
//                'Admin\Model\ProveedorTable' => function($sl){
//                    $gateway = $sl->get('ProveedorTableGateway');
//                    $table = new ProveedorTable($gateway,$sl);
//                    return $table;
//                },
//                'ProveedorTableGateway' => function($sl) {
//                    $adapter = $sl->get('dbadapter');
//                    $rsPrototype = new ResultSet();
//                    $rsPrototype->setArrayObjectPrototype(new Proveedor());
//                    $tableGateway = new TableGateway('proveedor', $adapter, null, $rsPrototype);
//                    return $tableGateway;
//                },
                        
            ),
        );
    }    
    
    
}
