<?php

namespace TemaRest\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulController {

     const VALID_TOKEN = '6d0007e52f7afb7d5a0650b0ffb8a4d1';


     /**
     * @tutorial curl http://local.czf2.com/tema-rest
     * @return \Zend\View\Model\JsonModel
     */
    public function getList() {
        $token = $this->getRequest()->getHeaders()->get('X-AppToken')->getFieldValue();
        
        if($token!=self::VALID_TOKEN){
            $this->response->setStatusCode(401);
        }
        
        return new JsonModel(array(
            'saludo' => 'Hola desde el Servidor Rest',
            'token' => $token,
            'method' => __FUNCTION__,
            'params' => func_get_args(),
        ));
    }

    /**
     * @tutorial curl http://local.czf2.com/tema-rest/8
     * @return \Zend\View\Model\JsonModel
     */
    public function get($id) {
        return new JsonModel(array(
            'method' => __FUNCTION__,
            'params' => func_get_args(),
        ));
    }
    
    /**
     * @tutorial curl -X POST -d "a=1&b=2" http://local.czf2.com/tema-rest
     * @return \Zend\View\Model\JsonModel
     */
    public function create($data) {
        return new JsonModel(array(
            'saludo' => __NAMESPACE__,
            'method' => __FUNCTION__,
            'params' => func_get_args(),
        ));
    }
    
    /**
     * @tutorial curl -X PUT -d "a=1&b=2" http://local.czf2.com/tema-rest/8
     * @return \Zend\View\Model\JsonModel
     */
    public function update($id, $data) {
        return new JsonModel(array(
            'method' => __FUNCTION__,
            'params' => func_get_args(),
        ));
    }
    
    /**
     * @tutorial curl -X DELETE http://local.czf2.com/tema-rest/8
     * @return \Zend\View\Model\JsonModel
     */
    public function delete($id) {
        return new JsonModel(array(
            'method' => __FUNCTION__,
            'params' => func_get_args(),
        ));
    }
    
//    public function head(){
//        return array();
////        $this->getResponse()->setHeader('count',rand(1,99).'');
//    }
    
    
    
    
    
    
}
