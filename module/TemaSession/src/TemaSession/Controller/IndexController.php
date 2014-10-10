<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaSession\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction() {
//        $_SESSION['__ZF']['tienda']['carrito'] = array();
        $view = new ViewModel();
        $sess = new \Zend\Session\Container('tienda');
        $view->carrito = $sess->carrito;
//        $view->carrito = null;
//        var_dump($_COOKIE);
//        var_dump($this->getRequest()->getHeaders()->get('Cookie'));
//        var_dump($_SESSION);
//        
        // SIN usar ZF2
        // escribir variable de sesión
//        $_SESSION['kkm']['uid'] = 23;
        // leer variable de sesión
//        $uid = $_SESSION['uid']['jh'][0];
        //borrar
//        unset($_SESSION['uid']['jh']);
        
        
        
        return $view;
    }

    public function addItemAction() {
        $sess = new \Zend\Session\Container('tienda');
        
        if ($sess->carrito == null) {
            $sess->carrito = array();
        }

        $sess->carrito[] = substr(md5(rand(0, 9999)), rand(0, 10), rand(10, 21));

        return $this->redirect()->toRoute(
                'tema-session/default',
                array('controller' => 'index', 'action' => 'index')
        );
    }
    
    public function emptyCartAction() {
        $sess = new \Zend\Session\Container('tienda');
        $sess->carrito = null;
        return $this->redirect()->toRoute(
                'tema-session/default',
                array('controller' => 'index', 'action' => 'index')
        );
    }

    public function emptyCartSecsAction() {
        $sess = new \Zend\Session\Container('tienda');
        $sess->setExpirationSeconds(5,'carrito');
        
        return $this->redirect()->toRoute(
                'tema-session/default',
                array('controller' => 'index', 'action' => 'index')
        );
    }

    public function emptyCartHopsAction() {
        $sess = new \Zend\Session\Container('tienda');
        $sess->setExpirationHops(5,'carrito');
        return $this->redirect()->toRoute(
                'tema-session/default',
                array('controller' => 'index', 'action' => 'index')
        );
    }

}
