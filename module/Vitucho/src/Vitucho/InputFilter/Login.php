<?php
namespace Admin\InputFilter;

use Zend\InputFilter\InputFilter;

class Login extends InputFilter{
    
    public function __construct() {
        
        $login = new \Zend\InputFilter\Input('login');
        
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>20, 'encoding'=>'UTF-8'));
        $login->getValidatorChain()->attach($v);
        
//        $v = new \Zend\Validator\Db\NoRecordExists();
//        $login->getValidatorChain()->attach($v);
        
        $f = new \Zend\Filter\StringTrim();
        $login->getFilterChain()->attach($f);
        
        $f = new \Zend\Filter\Callback(function($value){
            return $value.'!';
        });
        $login->getFilterChain()->attach($f);
        
        $f = new \Admin\Filter\Word\SeparatorToDashSpanish();
        $login->getFilterChain()->attach($f);
        
        $f = new \Zend\Filter\StringToUpper();
        $login->getFilterChain()->attach($f);
        
        $this->add($login);
        

        
        
        $pwd = new \Zend\InputFilter\Input('pwd');
        
        $v = new \Zend\Validator\StringLength(array('min'=>3,'max'=>20, 'encoding'=>'UTF-8'));
        $pwd->getValidatorChain()->attach($v);
        
        $this->add($pwd);
        
    }
    
}

