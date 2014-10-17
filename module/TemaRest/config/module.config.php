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
            'tema-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/tema-rest[/:id]',
                    'constraints' => array(
                        'id'        => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller'    => 'TemaRest\Controller\Index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'TemaRest\Controller\Index' => 'TemaRest\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'strategies' => array('ViewJsonStrategy'),
        'template_path_stack' => array(
            'tema-rest' => __DIR__ . '/../view',
        ),
    ),
    
);
