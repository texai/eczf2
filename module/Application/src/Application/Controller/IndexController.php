<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

//use Application\Ec\Unt\Form\Contacto;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        
        $view->portal = 'Nombre del portal';
        
        return $view;
    }
    
    public function contactoAction()
    {
        $view = new ViewModel();
        
        $sl = $this->getServiceLocator();

        $formContacto = $sl->get('ContactoForm');
//        $formContacto2 = $sl->get('cffc');
//        $formContacto3 = $sl->get('EcUntFormContacto');
        
//        var_dump(spl_object_hash($formContacto));
//        var_dump(spl_object_hash($formContacto2));
        
//        $formContacto  = new Contacto();
        $view->form = $formContacto;
        
        return $view;
    }
}
