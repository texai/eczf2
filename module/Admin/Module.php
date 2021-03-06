<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Admin\Model\Categoria;
use Admin\Model\CategoriaTable;
use Admin\Model\Producto;
use Admin\Model\ProductoTable;
use Admin\Model\Proveedor;
use Admin\Model\ProveedorTable;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager->getSharedManager()
                ->attachAggregate(new \Admin\EventManager\Listeners());
        
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
                    'Admin' => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'AuthService' => function($sl){
                    $dbadapter = $sl->get('dbadapter');
                    $authAdapter = new \Zend\Authentication\Adapter\DbTable($dbadapter);
                    $authAdapter->setTableName('usuario');
                    $authAdapter->setIdentityColumn('login');
                    $authAdapter->setCredentialColumn('pwd');
                    $authAdapter->setCredentialTreatment('MD5(?)');
                    $auth = new \Zend\Authentication\AuthenticationService();
                    $storage = new \Zend\Authentication\Storage\Session('admin');
                    $auth->setStorage($storage);
                    $auth->setAdapter($authAdapter);
                    return $auth;
                },
                'AuthServicePortal' => function($sl){
                    $dbadapter = $sl->get('dbadapter');
                    $authAdapter = new \Zend\Authentication\Adapter\DbTable($dbadapter);
                    $authAdapter->setTableName('postulante');
                    $authAdapter->setIdentityColumn('login');
                    $authAdapter->setCredentialColumn('pwd');
                    $authAdapter->setCredentialTreatment('MD5(?)');
                    $auth = new \Zend\Authentication\AuthenticationService();
                    $storage = new \Zend\Authentication\Storage\Session('portal');
                    $auth->setStorage($storage);
                    $auth->setAdapter($authAdapter);
                    return $auth;
                },

                'Admin\Model\CategoriaTable' => function($sl){
                    $gateway = $sl->get('AdminCategoriaTableGateway');
                    $table = new CategoriaTable($gateway);
                    return $table;
                },
                'AdminCategoriaTableGateway' => function($sl) {
                    $adapter = $sl->get('dbadapter');
                    $rsPrototype = new ResultSet();
                    $rsPrototype->setArrayObjectPrototype(new Categoria());
                    $tableGateway = new TableGateway('categoria', $adapter, null, $rsPrototype);
                    return $tableGateway;
                },
                        
                'Admin\Model\ProductoTable' => function($sl){
                    $gateway = $sl->get('AdminProductoTableGateway');
                    $table = new ProductoTable($gateway,$sl);
                    return $table;
                },
                'AdminProductoTableGateway' => function($sl) {
                    $adapter = $sl->get('dbadapter');
                    $rsPrototype = new ResultSet();
                    $rsPrototype->setArrayObjectPrototype(new Producto());
                    $tableGateway = new TableGateway('producto', $adapter, null, $rsPrototype);
                    return $tableGateway;
                },

                'Admin\Model\ProveedorTable' => function($sl){
                    $gateway = $sl->get('AdminProveedorTableGateway');
                    $table = new ProveedorTable($gateway,$sl);
                    return $table;
                },
                'AdminProveedorTableGateway' => function($sl) {
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
