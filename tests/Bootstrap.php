<?php

namespace ApplicationTest;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use RuntimeException;

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    protected static $serviceManager;

    public static function init()
    {
        ini_set('short_open_tag', 'On');
        error_reporting(E_ALL | E_STRICT);
        define('APPLICATION_ENV', 'testing');
        define('APPLICATION_PATH', dirname(__DIR__));
        
        static::initAutoloader();
        
        // use ModuleManager to load this module and it's dependencies
        $appConfig = array(
            'module_listener_options' => array(
                'module_paths' => [
//                    realpath(dirname(__DIR__).'/vendor'),
                    realpath(dirname(__DIR__).'/module')
                ],
                'config_glob_paths' => array('config/autoload/{,*.}{global,local}.php'),
            ),
            'modules' => array(
                'Admin',
            ),
        );
        
        $sm = new ServiceManager(new ServiceManagerConfig(['ApplicationConfig'=>$appConfig]));
        $sm->setService('ApplicationConfig', $appConfig);
        $sm->get('ModuleManager')->loadModules();
        static::$serviceManager = $sm;
    }

    public static function chroot()
    {
        $rootPath = dirname(static::findParentPath('module'));
        if(is_readable($rootPath) && is_dir($rootPath)){
            chdir($rootPath);               
        }
    }

    public static function resetdb()
    {
        echo 'Preparando testing DB ... ';
        
        $sm = self::getServiceManager();
        $console = new \Zend\Console\Adapter\Posix();
        $request = new \Zend\Console\Request();
        $request->setParams(new \Zend\Stdlib\Parameters(['silent'=>true]));
        $tableGateway = $sm->get('Admin\Model\ProductoTable');
        $tableGateway->cleanDbCli($console, $request);
        $tableGateway->resetDbCliModules($console, $request);
        $tableGateway->resetDbCliApp($console, $request);
        
        $dbadapter = $sm->get('dbadapter');
        $conn = $dbadapter->getDriver()->getConnection();
        $sql = file_get_contents(APPLICATION_PATH.'/tests/sql/testing.data.sql');
        $conn->execute($sql);
        
        echo '[OK]'.PHP_EOL;
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
        $vendorPath = static::findParentPath('vendor');

        $zf2Path = getenv('ZF2_PATH');
        if (!$zf2Path) {
            if (defined('ZF2_PATH')) {
                $zf2Path = ZF2_PATH;
            } elseif (is_dir($vendorPath . '/ZF2/library')) {
                $zf2Path = $vendorPath . '/ZF2/library';
            } elseif (is_dir($vendorPath . '/zendframework/zendframework/library')) {
                $zf2Path = $vendorPath . '/zendframework/zendframework/library';
            }
        }

        if (!$zf2Path) {
            throw new RuntimeException(
                'Unable to load ZF2. Run `php composer.phar install` or'
                . ' define a ZF2_PATH environment variable.'
            );
        }

        if (file_exists($vendorPath . '/autoload.php')) {
            include $vendorPath . '/autoload.php';
        }

        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
        AutoloaderFactory::factory(array(
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/' . __NAMESPACE__,
                    'AdminTest'    => __DIR__ . '/' . 'AdminTest',
                    'PortalTest'    => __DIR__ . '/' . 'PortalTest',
                ),
            ),
        ));
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();
Bootstrap::chroot();
//Bootstrap::resetdb();
