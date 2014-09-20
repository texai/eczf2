<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace HelmutProducto\Controller;

use Admin\Model\Producto;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        
        $view->portal = 'HELMUT PRODUCTO!';
        
        return $view;
    }
    
    public function loginAction()
    {
        $this->layout('login');
        $sl = $this->getServiceLocator();
        $vhm = $sl->get('viewHelperManager');
        $basePath = $vhm->get('basePath');
        $helperHeadLink = $vhm->get('headLink');
        $helperHeadLink->appendStylesheet($basePath('/css/login-admin.css'));
        $helperHeadtitle = $vhm->get('headTitle');
        $helperHeadtitle->append('LOGIN');
        $helperHeadScript = $vhm->get('headScript');
        $helperHeadScript->appendFile(
                $basePath('/js/fixie7.js'),
                'text/javascript',
                array('conditional' => 'lt IE 7')
        );

        $view = new ViewModel();

        
        $formLogin = new \Admin\Form\Login();
        $inputFilterLogin = new \Admin\InputFilter\Login();
        $formLogin->setInputFilter($inputFilterLogin);
        $formLogin->prepare();
        
        if($this->getRequest()->isPost()){
            $data = $this->params()->fromPost();
            $formLogin->setData($data);
            if($formLogin->isValid()){
                
                $auth = $sl->get('AuthService');
                
            }else{
                var_dump($formLogin->getMessages());
            }
            
        }
        
        
        $view->form = $formLogin;
        
        return $view;
    }
    
    
    public function configAction(){
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $config = $sl->get('config');
        $view->config = $config;
        return $view;
    }
    
}
