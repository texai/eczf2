<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Karina;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Karina\Model\Categoria;
use Karina\Model\CategoriaTable;
use Karina\Model\Producto;
use Karina\Model\ProductoTable;
use Karina\Model\Proveedor;
use Karina\Model\ProveedorTable;


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
                    'Karina' => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'AuthService' => function(){
                    $authAdapter = new \Zend\Authentication\Adapter\DbTable($zendDb);
                    $auth = new \Zend\Authentication\AuthenticationService();
                },

                'Karina\Model\CategoriaTable' => function($sl){
                    $gateway = $sl->get('KarinaCategoriaTableGateway');
                    $table = new CategoriaTable($gateway);
                    return $table;
                },
                'KarinaCategoriaTableGateway' => function($sl) {
                    $adapter = $sl->get('dbadapter');
                    $rsPrototype = new ResultSet();
                    $rsPrototype->setArrayObjectPrototype(new Categoria());
                    $tableGateway = new TableGateway('kategoria', $adapter, null, $rsPrototype);
                    return $tableGateway;
                },
                        
                'Karina\Model\ProductoTable' => function($sl){
                    $gateway = $sl->get('KarinaProductoTableGateway');
                    $table = new ProductoTable($gateway,$sl);
                    return $table;
                },
                'KarinaProductoTableGateway' => function($sl) {
                    $adapter = $sl->get('dbadapter');
                    $rsPrototype = new ResultSet();
                    $rsPrototype->setArrayObjectPrototype(new Producto());
                    $tableGateway = new TableGateway('producto', $adapter, null, $rsPrototype);
                    return $tableGateway;
                },

                'Karina\Model\ProveedorTable' => function($sl){
                    $gateway = $sl->get('KarinaProveedorTableGateway');
                    $table = new ProveedorTable($gateway,$sl);
                    return $table;
                },
                'KarinaProveedorTableGateway' => function($sl) {
                    $adapter = $sl->get('dbadapter');
                    $rsPrototype = new ResultSet();
                    $rsPrototype->setArrayObjectPrototype(new Proveedor());
                    $tableGateway = new TableGateway('proveedor', $adapter, null, $rsPrototype);
                    return $tableGateway;
                },                
            ),
        );
    }
    
    
    
}
