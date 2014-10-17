<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaAcl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        
//        $sl = $this->getServiceLocator();
//        $acl = $sl->get('tema-acl/acl');
        
        $this->acl->isAllowed('manager', 'categoria', 'ver');

        
        var_dump(array(
            'ver' => $this->acl->isAllowed('manager', 'categoria', 'ver'),
            'crear' => $this->acl->isAllowed('manager', 'categoria', 'crear'),
            'editar' => $this->acl->isAllowed('manager', 'categoria', 'editar'),
            'borrar' => $this->acl->isAllowed('manager', 'categoria', 'borrar'),
        ));
        
        
        var_dump('En el Controlador: '.get_class($this->acl));
        
        return $view;
    }
    
}