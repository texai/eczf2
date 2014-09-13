<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
     'controllers' => array(
         'invokables' => array(
             'TemaPaginator\Controller\Album' => 'TemaPaginator\Controller\AlbumController',
         ),
     ),
    
     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'TemaPaginator' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/tema-paginator[/][:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'TemaPaginator\Controller\Album',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
    
     'view_manager' => array(
         'template_map' => array(
            'tema-paginator/layout'  => __DIR__ . '/../view/tema-paginator/layout/layout.phtml',
            'tema-paginator/blank'   => __DIR__ . '/../view/tema-paginator/layout/blank.phtml',
         ),
         'template_path_stack' => array(
             'tema-paginator'        => __DIR__ . '/../view',
         ),
     ),
    
     'db' => array(
         'driver'         => 'Pdo',
         'dsn'            => 'mysql:dbname=eczf2_dev;host=127.0.0.1',
         'driver_options' => array(
             PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
         ),
     ),
     'service_manager' => array(
         'factories' => array(
             'Zend\Db\Adapter\Adapter'
                     => 'Zend\Db\Adapter\AdapterServiceFactory',
         ),
     ),
    
 );