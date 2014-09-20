<?php

namespace Karina\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoriaController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Karina\Model\CategoriaTable */
        $mCategoria = $sl->get('Karina\Model\CategoriaTable');
        $view->rows = $mCategoria->fetchAll();
        return $view;
    }
    
    public function nuevoAction() {
        $view = new ViewModel();
        $sl = $this->getServiceLocator();
        $form = new \Karina\Form\Categoria();
        $if = new \Karina\InputFilter\Categoria();
        $form->setInputFilter($if);
        $view->form = $form;
        $req = $this->getRequest();
        if($req->isPost()){
            $data = $req->getPost();
            var_dump($data);
            $form->setData($data);
            if($form->isValid()){
                $values = $form->getData();
                /* @var $mCategoria \Karina\Model\CategoriaTable */
                $mCategoria = $sl->get('Karina\Model\CategoriaTable');
                $categoria = new \Karina\Model\Categoria();
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
        /* @var $mCategoria \Karina\Model\CategoriaTable */
        $mCategoria = $sl->get('Karina\Model\CategoriaTable');
        $form = new \Karina\Form\Categoria();
        $if = new \Karina\InputFilter\Categoria();
        
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
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
                $categoria = new \Karina\Model\Categoria();
                $categoria->exchangeArray($values);
                $mCategoria->editar($categoria,$id);
                $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
            }
            
        }
        return $view;        
    }
    
    public function activarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Karina\Model\CategoriaTable */
        $mCategoria = $sl->get('Karina\Model\CategoriaTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
        }
        $mCategoria->setActivo(true,$id);
        $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
    }
    
    public function desactivarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Karina\Model\CategoriaTable */
        $mCategoria = $sl->get('Karina\Model\CategoriaTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
        }
        $mCategoria->setActivo(false,$id);
        $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
    }
    
    public function borrarAction() {
        $sl = $this->getServiceLocator();
        /* @var $mCategoria \Karina\Model\CategoriaTable */
        $mCategoria = $sl->get('Karina\Model\CategoriaTable');
        $id = $this->params()->fromRoute('id', -1);
        if($id == -1){
            $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
        }
        $mCategoria->borrar($id);
        $this->redirect()->toRoute('karina/default', array('controller'=>'categoria','action'=>'index'));
    }
    
}
