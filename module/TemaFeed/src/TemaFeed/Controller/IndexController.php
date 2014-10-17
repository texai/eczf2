<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaFeed\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    
    public function readerAction(){
    
        $view = new ViewModel();
        $feedWriter = new \TemaFeed\Model\Feed();
        $view->data = $feedWriter->getFeedReaderExample();
        return $view;

        
    }
    
    public function writerAction(){
        
        $view = new ViewModel();
        $this->layout('tema-feed/blank');
        $feedWriter = new \TemaFeed\Model\Feed();
        $view->xml = $feedWriter->getFeedWriterExample();
        return $view;
        
    }
    
    public function exposeFeedAction() {
        $view = new ViewModel();
        $this->layout('tema-feed/blank');
        $feedWriter = new \TemaFeed\Model\Feed();
        $view->xml = $feedWriter->getFeedWriterExercise();
        return $view;
    }
    
    public function consumeFeedAction() {
        $view = new ViewModel();
        $feedWriter = new \TemaFeed\Model\Feed();
        $view->data = $feedWriter->getFeedReaderExercise();
        return $view;
    }
}
