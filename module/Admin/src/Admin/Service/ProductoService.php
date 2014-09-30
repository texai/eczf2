<?php

namespace Admin\Service;

use Zend\EventManager\EventInterface;


class ProductoService
{
    
    
    
    public function onNuevaSubasta(EventInterface $e){
        $file = __DIR__.'/../../../em.log';
        $logw = new \Zend\Log\Writer\Stream($file);
        $log = new \Zend\Log\Logger;
        $log->addWriter($logw);
        
        $target = $e->getTarget();
        $params = $e->getParams();
        
        $log->log(\Zend\Log\Logger::INFO, get_class($target));
        $log->log(\Zend\Log\Logger::INFO, print_r($params,true));
    }
    
    
    
}