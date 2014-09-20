<?php

namespace Vitucho\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProveedorController extends AbstractActionController
{
    protected $proveedorTable;
    
    public function indexAction()
    {
        $view = new ViewModel();
        
        $view->qs = $this->params()->fromQuery();
        $view->orden = $this->params()->fromQuery('orden','id');
        $view->dir = $this->params()->fromRoute('dir','ASC');
        
        $sl = $this->getServiceLocator();
        $config = $sl->get('config');
        $pageRange = $config['portal']['mant']['proveedor']['page_range'];
        $cpp = $config['portal']['mant']['proveedor']['count_per_page'];
        /* @var $mCategoria \Admin\Model\ProveedorTable */
        $mCategoria = $sl->get('Admin\Model\ProveedorTable');
        $page = $this->params()->fromQuery('page', '1');
        $view->rows = $mCategoria->fetchAll(true,array('orden'=>$view->orden,'dir'=>$view->dir));
        $view->rows->setItemCountPerPage($cpp);
        $view->rows->setCurrentPageNumber($page);
        $view->rows->setPageRange($pageRange);
        
        return $view;
    }
    
    public function getProveedorTable() {
        if (!$this->proveedorTable) {
            $sm = $this->getServiceLocator();
            $this->proveedorTable = $sm->get('Admin\Model\ProveedorTable');
        }
        return $this->proveedorTable;
    }
    
    public function nuevoAction() {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $form = new \Vitucho\Form\Proveedor();
        $if = new \Vitucho\InputFilter\Proveedor();
        $form->setInputFilter($if);
        $view->form = $form;
        $req = $this->getRequest();
        if($req->isPost()){
            $data = $req->getPost();
            var_dump($data);
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                /* @var $mProveedor \Admin\Model\ProveedorTable */
                $mProveedor = $sl->get('Admin\Model\ProveedorTable');
                $proveedor = new \Admin\Model\Proveedor();
                $proveedor->exchangeArray($values);
                $mProveedor->grabar($proveedor);
                $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
            }
            
        }
        return $view;
    }
    
    public function editarAction() {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        /* @var $mProveedor \Admin\Model\ProveedorTable */
        $mProveedor = $sl->get('Admin\Model\ProveedorTable');
        $form = new \Vitucho\Form\Proveedor();
        $if = new \Vitucho\InputFilter\Proveedor();
        
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
        }
        
        $form->setData($mProveedor->getById($id)->toArray());
        $form->get('enviar')->setValue('Editar');
        
        $form->setInputFilter($if);
        $view->form = $form;
        $req = $this->getRequest();
        if($req->isPost()){
            $data = $req->getPost();
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                $proveedor = new \Admin\Model\Proveedor();
                $proveedor->exchangeArray($values);
                $mProveedor->editar($proveedor,$id);
                $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
            }
            
        }
        return $view;        
    }
    
    public function activarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mProveedor \Admin\Model\ProveedorTable */
        $mProveedor = $sl->get('Admin\Model\ProveedorTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
        }
        $mProveedor->setActivo(true,$id);
        $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
    }
    
    public function desactivarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mProveedor \Admin\Model\ProveedorTable */
        $mProveedor = $sl->get('Admin\Model\ProveedorTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
        }
        $mProveedor->setActivo(false,$id);
        $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
    }
    
    public function borrarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mProveedor \Admin\Model\ProveedorTable */
        $mProveedor = $sl->get('Admin\Model\ProveedorTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
        }
        $mProveedor->borrar($id);
        $this->redirect()->toRoute('vitucho/default', array('controller'=>'proveedor','action'=>'index'));
    }
    
}
