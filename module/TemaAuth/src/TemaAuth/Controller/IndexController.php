<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        return $view;
    }
    
    
    public function miCuentaAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $auth = $sl->get('AuthService');
        
        // si es que no estoy logged in, entonces redirect al login form
        if(!$auth->hasIdentity()){
            return $this->redirect()->toRoute(
                'tema-auth/default',
                array('controller'=>'index','action'=>'login')
            );
        }
        
        // obteniendo la data del storage // ternaty operator
        $view->data = $auth->hasIdentity()?$auth->getStorage()->read():null;

        return $view;
    }
    
    public function logoutAction(){
        $sm = $this->getServiceLocator();
        $auth = $sm->get('AuthService');
        $auth->clearIdentity();
        return $this->redirect()->toRoute(
            'tema-auth/default',
            array('controller'=>'index','action'=>'login')
        );
        
    }
    
    public function loginAction(){
        
        // llamo al service locator
        $sl = $this->getServiceLocator();
        
//        // llamo a la clase de servicio de authentication
//        $auth = $sl->get('AuthService');
        
        // pregunto si tenco una sesion
//        if($auth->hasIdentity()){
//            // si estoy logueado voy al index
//            // no tiene sentido mostrar un login form 
//            // cuando ya estas logged in
//            return $this->redirect()->toRoute('tema-auth/default',array('controller'=>'index','action'=>'index'));
//        }
        
//         cambio el layout
        $this->layout('login');
        
        $view = new ViewModel();
        $form = new \TemaAuth\Form\Login();
        $inputFilter = new \TemaAuth\InputFilter\Login();
        $form->setInputFilter($inputFilter);
        $view->form = $form;
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost();
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                
//                $auth->getAdapter()
//                        ->setIdentity($values['usuario'])
//                        ->setCredential($values['pwd']);
//                $result = $auth->authenticate();
//                
//                if ( $result->isValid() ) {
//                    $auth->getStorage()->write(
//                        $auth->getAdapter()
//                       // acepta: lista de inclusion, lista de exclusion
//                            ->getResultRowObject(null,array('password'))
//                    );
//                    
//                    // una vez que ya está validado el usuario
//                    // hago un redirect 
//                    return $this->redirect()->toRoute(
//                        'tema-auth/default',
//                        array('controller'=>'index','action'=>'mi-cuenta')
//                    );
//                }else {
//                    $view->errorMsg = 'User or password incorrect';
//                }
            }
        }
        return $view;
    }
    
}
