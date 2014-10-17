<?php

namespace TemaForm\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Contacto extends Form {

    public function __construct($name = null) {
        
        parent::__construct('contacto');
        
        $e = new Element\Text('nombre');
        $e->setLabel('Nombre');
        $this->add($e);
        
        $e = new Element\Textarea('mensaje');
        $e->setLabel('Mensaje');
        $this->add($e);
        
        $e = new Element\Email('email');
        $e->setLabel('E-Mail');
        $this->add($e);
        
        $e = new Element\Select('tipo');
        $e->setLabel('Tipo');
        $e->setValueOptions(array(
            '1' => 'Sugerencia',
            '2' => 'Queja',
            '3' => 'Reclamo',
        ));
        $this->add($e);
        
        $e = new Element\Submit('enviar');
        $e->setValue('Enviar');
        $this->add($e);
    }

}
