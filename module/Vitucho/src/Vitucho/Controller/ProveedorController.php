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
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Admin\Model\CategoriaTable */
        $mCategoria = $sl->get('Admin\Model\ProveedorTable');
        $view->rows = $mCategoria->fetchAll();
        return $view;
        
        
//        $paginator = $this->getProveedorTable()->fetchAll(true);
//        $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
//        $paginator->setItemCountPerPage(3);
//
//        return new ViewModel(array(
//            'albums' => $paginator
//        ));
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
