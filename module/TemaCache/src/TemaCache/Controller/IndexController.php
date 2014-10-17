<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaCache\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $view = new ViewModel();
        $cache = $this->getServiceLocator()->get('cache');        
        
//        $cache = new \Zend\Cache\Storage\Adapter\Filesystem();
//        $cache->get
        
//        var_dump(get_class($cache));
        
        $key = 'top10';
        if($cache->hasItem($key)){
            $data = $cache->getItem($key);
        }else{
//            $data = rand(0,99).'';
            $data = new \stdClass;
            $data->v = rand(0,99).'';
            $cache->setItem($key, $data);
        }
        var_dump($data);
        return $view;
    }

}
