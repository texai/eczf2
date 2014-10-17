<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'TemaConsole\Controller\Index' => 'TemaConsole\Controller\IndexController'
        ),
    ),
    
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
                'flush' => array (
                    'options' => array (
                        'route' => 'flush',
                        'defaults' => array (
                            'controller' => 'TemaConsole\Controller\Index',
                            'action'     => 'flush',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
