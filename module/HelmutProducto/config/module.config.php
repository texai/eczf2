<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'helmut-producto' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/helmut-producto',
                    'defaults' => array(
                        '__NAMESPACE__' => 'HelmutProducto\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'id' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:id',
                                    'constraints' => array(
                                        'id'         => '[0-9]*',
                                    ),
                                    'defaults' => array(),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
/* => */    'dbadapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'HelmutProducto\Controller\Index' => 'HelmutProducto\Controller\IndexController',
            'HelmutProducto\Controller\Producto' => 'HelmutProducto\Controller\ProductoController',
        ),
    ),
    'view_manager' => array(
        'base_path' => 'http://local.eczf2.pe/',
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/HelmutProducto'           => __DIR__ . '/../view/layout/layout.phtml',
            'helmut-producto/index/index'          => __DIR__ . '/../view/helmut-producto/index/index.phtml',
            'login'           => __DIR__ . '/../view/layout/login.phtml',
            //'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'db' => array(
        'username' => 'root',
        'password' => 'draco12',
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=eczf2_dev;host=127.0.0.1',
    )
);
