<?php
return array(
    'tema-router' => array(
        'type'    => 'Literal',
        'options' => array(
            'route'    => '/tema-router',
            'defaults' => array(
                '__NAMESPACE__' => 'TemaRouter\Controller',
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
            ),
            'destino' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/destino-como-ruta-hija',
                    'defaults' => array(
                        'controller' => 'Index',
                        'action'     => 'destino',
                    ),
                ),
            ),
        ),
    ),
    'destino' => array(
        'type'    => 'Literal',
        'options' => array(
            'route'    => '/destino-como-ruta-padre',
            'defaults' => array(
                '__NAMESPACE__' => 'TemaRouter\Controller',
                'controller'    => 'Index',
                'action'        => 'destino',
            ),
        ),
        'may_terminate' => true,
    ),
    'bridge.js' => array(
        'type'    => 'Literal',
        'options' => array(
            'route'    => '/static/bridge.js',
            'defaults' => array(
                '__NAMESPACE__' => 'TemaRouter\Controller',
                'controller'    => 'Index',
                'action'        => 'bridge',
            ),
        ),
        'may_terminate' => true,
    ),
    'destino-params' => array(
        'type'    => 'Segment',
        'options' => array(
            'route'    => '/destino-acepta-parametros/ciudad/[:id]/pais/[:pais]',
            'constraints' => array(
//                        'id' => '[0-9]*',
            ),
            'defaults' => array(
                '__NAMESPACE__' => 'TemaRouter\Controller',
                'controller'    => 'Index',
                'action'        => 'destino',
            ),
        ),
        'may_terminate' => true,
    ),
    'destino-seo' => array(
        'type'    => 'Segment',
        'options' => array(
            'route'    => '/destino/[:ciudad]/[:pais]/[:id]',
            'constraints' => array(
                'ciudad' => '[a-zA-Z][a-zA-Z-]*',
                'pais' => '[a-zA-Z][a-zA-Z-]*',
                'id' => '[0-9]*',
            ),
            'defaults' => array(
                '__NAMESPACE__' => 'TemaRouter\Controller',
                'controller'    => 'Index',
                'action'        => 'destino',
            ),
        ),
        'may_terminate' => true,
    ),
);