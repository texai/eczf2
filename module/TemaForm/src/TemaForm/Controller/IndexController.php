<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaForm\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;
use Zend\Form\Form;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function basicoAction(){
        $view = new ViewModel();
        $form = new Form();
        
        $e = new Element\Text('nombre');
        $e->setLabel('Nombre');
        $form->add($e);
        
        $e = new Element\Textarea('mensaje');
        $e->setLabel('Mensaje');
        $form->add($e);
        
        $e = new Element\Submit('enviar');
        $e->setValue('Enviar');
        $form->add($e);
        
        $view->form = $form;
        return $view;
    }
    

    public function claseFormAction(){
        $view = new ViewModel();
        $form = new \TemaForm\Form\Contacto();
        $view->form = $form;
        return $view;
    }
    
    public function claseFormEnPostAction(){
        $view = new ViewModel();
        $form = new \TemaForm\Form\Contacto();
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                var_dump($form->getData());
            }
        }
        $view->form = $form;
        return $view;
    }
    
    public function inputFilterAction(){
        $view = new ViewModel();
        $form = new \TemaForm\Form\Contacto();
        $inputFilter = new \TemaForm\InputFilter\Contacto();
        $form->setInputFilter($inputFilter);
        
        $form->get('nombre')->setValue('xxsS');
        
        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($request->getPost());
            if($form->isValid()){
                $data = $form->getData();
                var_dump($data);
            }
        }
        $view->form = $form;
        return $view;
    }
    
    
}
