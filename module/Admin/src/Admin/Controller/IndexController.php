<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        
        $view->portal = 'ADMIN!';
        
        $sl = $this->getServiceLocator();
        $auth = $sl->get('AuthService');

        // asignacion en cadena
//        $estoyLogueado = $view->isAuth = $auth->hasIdentity();
        
        $estoyLogueado = $auth->hasIdentity();
        $view->isAuth = $auth->hasIdentity();
        
//        var_dump('estoyLogueado');
//        var_dump($estoyLogueado);
        
        if($estoyLogueado){
//            var_dump('$auth->getStorage()->read()');
//            var_dump($auth->getStorage()->read());
        }
        
        
        return $view;
    }
    
    public function logoutAction()
    {
        $sl = $this->getServiceLocator();
        $auth = $sl->get('AuthService');
        $auth->clearIdentity();
        $this->redirect()->toUrl('/admin');
        
    }
    
    public function loginAction()
    {
        
        if(1){
//            throw new \Exception('Algo salio mal');
//            4/0;
        }
        
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
                
                $values = $formLogin->getData();
                
                /* @var $auth \Zend\Authentication\AuthenticationService */
                $auth = $sl->get('AuthService');
                
                /* @var $adapter \Zend\Authentication\Adapter\DbTable */
                $adapter = $auth->getAdapter();
                
                $adapter->setIdentity($values['login']);
                $adapter->setCredential($values['pwd']);
                
                /* @var $result \Zend\Authentication\Result */
                $result = $auth->authenticate($adapter);
                
                if($result->isValid()){
                    $userRow = $adapter->getResultRowObject();
                    $auth->getStorage()->write($userRow);
                    $this->redirect()->toUrl('/admin');
                }else{
                    var_dump('Usuario o pwd oincorrecto');
                }
                
                
                
                
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
