<?php

namespace HelmutProducto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProductoController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        /* @var $mProducto \Admin\Model\CategoriaTable */
        $mProducto = $sl->get('Admin\Model\ProductoTable');
        $view->rows = $mProducto->fetchAll();
        return $view;
    }
    
    public function nuevoAction() {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $form = new \HelmutProducto\Form\Producto();
        $if = new \HelmutProducto\InputFilter\Producto();
        $form->setInputFilter($if);
        $view->form = $form;
        $req = $this->getRequest();
        if($req->isPost()){
            $data = $req->getPost();
            var_dump($data);
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                /* @var $mProducto \Admin\Model\CategoriaTable */
                $mProducto = $sl->get('Admin\Model\ProductoTable');
                $producto = new \Admin\Model\Producto();
                $producto->exchangeArray($values);
                $mProducto->grabar($producto);
                $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
            }
            
        }
        return $view;
    }
    
    public function editarAction() {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        /* @var $mProducto \Admin\Model\CategoriaTable */
        $mProducto = $sl->get('Admin\Model\ProductoTable');
        $form = new \HelmutProducto\Form\Producto();
        $if = new \HelmutProducto\InputFilter\Producto();
        
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
        }
        
        $form->setData($mProducto->getById($id)->toArray());
        $form->get('enviar')->setValue('Editar');
        
        $form->setInputFilter($if);
        $view->form = $form;
        $req = $this->getRequest();
        if($req->isPost()){
            $data = $req->getPost();
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                $producto = new \Admin\Model\Producto();
                $producto->exchangeArray($values);
                $mProducto->editar($producto,$id);
                $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
            }
            
        }
        return $view;        
    }
    
    public function activarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mProducto \Admin\Model\CategoriaTable */
        $mProducto = $sl->get('Admin\Model\ProductoTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
        }
        $mProducto->setActivo(true,$id);
        $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
    }
    
    public function desactivarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mProducto \Admin\Model\CategoriaTable */
        $mProducto = $sl->get('Admin\Model\ProductoTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
        }
        $mProducto->setActivo(false,$id);
        $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
    }
    
    public function borrarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mProducto \Admin\Model\CategoriaTable */
        $mProducto = $sl->get('Admin\Model\ProductoTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
        }
        $mProducto->borrar($id);
        $this->redirect()->toRoute('helmut-producto/default', array('controller'=>'producto','action'=>'index'));
    }
    
}
