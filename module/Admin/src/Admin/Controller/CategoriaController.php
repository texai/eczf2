<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoriaController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Admin\Model\CategoriaTable */
        $mCategoria = $sl->get('Admin\Model\CategoriaTable');
        $view->rows = $mCategoria->fetchAll();
        return $view;
    }
    
    public function nuevoAction() {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $form = new \Admin\Form\Categoria();
        $if = new \Admin\InputFilter\Categoria();
        $form->setInputFilter($if);
        $view->form = $form;
        $req = $this->getRequest();
        if($req->isPost()){
            $data = $req->getPost();
            var_dump($data);
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                /* @var $mCategoria \Admin\Model\CategoriaTable */
                $mCategoria = $sl->get('Admin\Model\CategoriaTable');
                $categoria = new \Admin\Model\Categoria();
                $categoria->exchangeArray($values);
                $mCategoria->grabar($categoria);
                $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
            }
            
        }
        return $view;
    }
    
    public function editarAction() {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Admin\Model\CategoriaTable */
        $mCategoria = $sl->get('Admin\Model\CategoriaTable');
        $form = new \Admin\Form\Categoria();
        $if = new \Admin\InputFilter\Categoria();
        
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
        }
        
        $form->setData($mCategoria->getById($id)->toArray());
        $form->get('enviar')->setValue('Editar');
        
        $form->setInputFilter($if);
        $view->form = $form;
        $req = $this->getRequest();
        if($req->isPost()){
            $data = $req->getPost();
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                $categoria = new \Admin\Model\Categoria();
                $categoria->exchangeArray($values);
                $mCategoria->editar($categoria,$id);
                $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
            }
            
        }
        return $view;        
    }
    
    public function activarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Admin\Model\CategoriaTable */
        $mCategoria = $sl->get('Admin\Model\CategoriaTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
        }
        $mCategoria->setActivo(true,$id);
        $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
    }
    
    public function desactivarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Admin\Model\CategoriaTable */
        $mCategoria = $sl->get('Admin\Model\CategoriaTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
        }
        $mCategoria->setActivo(false,$id);
        $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
    }
    
    public function borrarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Admin\Model\CategoriaTable */
        $mCategoria = $sl->get('Admin\Model\CategoriaTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
        }
        $mCategoria->borrar($id);
        $this->redirect()->toRoute('admin/default', array('controller'=>'categoria','action'=>'index'));
    }
    
}
