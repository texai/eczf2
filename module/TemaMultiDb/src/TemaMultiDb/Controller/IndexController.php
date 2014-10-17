<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaMultiDb\Controller;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    
    public function indexAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $adapter = $sl->get('db2');
        $tableGateway = new TableGateway('categoria', $adapter);
        $view->data = $tableGateway->select();
        return $view;
    }
    
}
