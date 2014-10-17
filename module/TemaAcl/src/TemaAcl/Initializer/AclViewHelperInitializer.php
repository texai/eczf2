<?php

namespace TemaAcl\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 */
class AclViewHelperInitializer implements InitializerInterface
{

    /**
     *
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        
        if ($instance instanceof \TemaAcl\View\Helper\Acl) {
//            echo '123';exit;
//            $instance->setServiceLocator($serviceLocator);
        }
    }
}
