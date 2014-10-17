<?php

namespace TemaAcl\View\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;


class Acl extends AbstractHelper implements ServiceLocatorAwareInterface {
    
    protected $serviceManager;

    public function __invoke($permiso,$recurso) {
        $viewHelperPluginManager = $this->serviceManager;
        $serviceManager = $viewHelperPluginManager ->getServiceLocator();
        $auth = $serviceManager->get('AuthService');
        
        if(!$auth->hasIdentity()){
            return false;
        }
        
        $acl = $serviceManager->get('tema-acl/acl');
        $rol = $auth->getStorage()->read()->rol;
        return $acl->isAllowed($rol,$recurso,$permiso);
    }
    

    public function getServiceLocator()
    {
        return $this->serviceManager;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
        return $this;
    }
    
}
