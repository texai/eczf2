<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

$envFile = getcwd() . '/config/autoload/env';
$env = trim(file_get_contents($envFile));
define('APPLICATION_ENV', $env);

if($env=='development'){
    ini_set('display_errors', true);
}

if($env=='production'){
    ini_set('display_errors', false);
}

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
