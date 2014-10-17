<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TemaHttpClient\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Zend\Http\Client;

class IndexController extends AbstractActionController {

    const API_URL = 'http://local.eczf2.pe';
    
    public function indexAction() {
        $view = new ViewModel();
        return $view;
    }

    public function listarAction() {
        $view = new ViewModel();
        
//        $requestLocal = $this->getRequest();
        
        $request = new Request();
        $request->setUri(self::API_URL . '/tema-rest');
        $request->setMethod(Request::METHOD_GET);
        
        $request->getHeaders()->addHeaderLine('X-AppToken', md5('yox'));

        $client = new Client();
        $response = $client->dispatch($request);

//        $responseLocal = $this->getResponse();
        
        $view->data = null;
        if ($response->isSuccess()) {
            // JSON
            $view->data = json_decode($response->getContent());
            
            // XML
//            $sxe = new \SimpleXMLElement($response->getContent());
//            $view->data = $sxe->xpath('//buses[0]/pisos');
            
        }else{
            throw new \Exception('Status code: '.$response->getStatusCode());
//            $this->getResponse()->setStatusCode($response->getStatusCode());
        }
        
        return $view;
    }

    public function verDetalleAction() {
        $view = new ViewModel();
        
        $request = new Request();
        $request->setUri(self::API_URL . '/tema-rest/8');
        $request->setMethod(Request::METHOD_GET);

        $client = new Client();
        $response = $client->dispatch($request);

        $view->data = null;
        if ($response->isSuccess()) {
            $view->data = json_decode($response->getContent());
        }
        
        return $view;
    }
    
    public function nuevoAction() {
        $view = new ViewModel();
        
        $request = new Request();
        $request->setUri(self::API_URL . '/tema-rest');
        $request->setMethod(Request::METHOD_POST);
        $request->getPost()->set('a', '1');
        $request->getPost()->set('b', '2');

        $client = new Client();
        $client->setEncType(Client::ENC_URLENCODED);
        $response = $client->dispatch($request);

        $view->data = null;
        if ($response->isSuccess()) {
            $view->data = json_decode($response->getContent());
        }
        
        return $view;
    }
    
    public function editarAction() {
        $view = new ViewModel();
        
        $request = new Request();
        $request->setUri(self::API_URL . '/tema-rest/8');
        $request->setMethod(Request::METHOD_PUT);
        $request->getPost()->set('a', '1');
        $request->getPost()->set('b', '2');

        $client = new Client();
        $client->setEncType(Client::ENC_URLENCODED);
        $response = $client->dispatch($request);

        $view->data = null;
        if ($response->isSuccess()) {
            $view->data = json_decode($response->getContent());
        }
        
        return $view;
    }
    
    
    public function borrarAction() {
        $view = new ViewModel();
        
        $request = new Request();
        $request->setUri(self::API_URL . '/tema-rest/8');
        $request->setMethod(Request::METHOD_DELETE);

        $client = new Client();
        $response = $client->dispatch($request);

        $view->data = null;
        if ($response->isSuccess()) {
            $view->data = json_decode($response->getContent());
        }
        
        return $view;
    }
    
}
