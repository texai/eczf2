<?php

namespace Karina\Model;

use Zend\Db\TableGateway\TableGateway;

class ProveedorTable {
    
    private $tableGateway;
    private $sl;
    
    public function __construct(TableGateway $tableGateway, $sl) {
        $this->tableGateway = $tableGateway;
        $this->sl = $sl;
    }
    
    public function fetchAll(){
        return $this->tableGateway->select();
    }
   
}