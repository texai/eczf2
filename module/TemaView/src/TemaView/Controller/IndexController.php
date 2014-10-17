<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaView\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $viewHelperManager = $sl->get('viewHelperManager');
        
        // Agregando nodos al title
        $viewHelperManager->get('headTitle')->append('VISTA');
        
        // Obteniendo el Helper BasePath.
        $basePath = $viewHelperManager->get('basepath');
        
        // Agregando hojas de estilos
        $viewHelperManager->get('headLink')->appendStylesheet($basePath('/css/estilo1.css'));
        $viewHelperManager->get('headLink')->prependStylesheet($basePath('/css/estilo2.css'));

        // Todos los estáticos que se ven en el layout
        
        
        return $view;
    }
}
