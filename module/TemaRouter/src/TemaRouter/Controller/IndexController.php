<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaRouter\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }

    public function destinoAction() {
        $view = new ViewModel();
        $view->params = $this->params()->fromRoute();
        var_dump($_GET);
        return $view;
    }

    public function bridgeAction() {
        
        $view = new ViewModel();
        $this->layout('admin/blank');
        $view->uid = 402;
//        header('Content-type: text/javascript');
//        header('Content-Description: File Transfer');
//        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $response = $this->getResponse();
        $headers = $response->getHeaders();
        $headers->addHeaders(array(
                'Content-type: text/javascript',
//                'Content-Description: File Transfer',
//                'Content-Disposition: attachment; filename="file1.js"',
            ));
        
        return $view;
    }


}
