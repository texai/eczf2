<?php

namespace TemaDb\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoriaTable {
    
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        return $this->tableGateway->select();
    }
    
   
}