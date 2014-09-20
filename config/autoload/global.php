<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
use Zend\Config\Config;


if (!is_readable(__DIR__ . '/env')) {
    throw new RuntimeException(
    'Running environment has not been defined, please create a ' .
    'file "' . __DIR__ . '/env" with read privileges to web server user'
    );
}

$env = APPLICATION_ENV;
$envConfigFile = __DIR__ . '/' . $env . '.php';
$envConfig = array();
if (is_readable($envConfigFile)) {
    $envConfig = include $envConfigFile;
}

$globalConfig =  array(
    'home_max_sliders' => 5,
    'portal' => array(
        'mant' => array(
            'proveedor' => array(
                'page_range' => 6,
                'count_per_page' => 5,
            ),
        ),
    ),
);


$config = new Config($globalConfig);
$config->merge(new Config($envConfig));
return $config->toArray();