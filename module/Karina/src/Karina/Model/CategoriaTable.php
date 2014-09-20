<?php

namespace Karina\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoriaTable {
    
    private $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        return $this->tableGateway->select();
    }
    
    public function getById($id) {
        return $this->tableGateway->select(array('id=?'=>$id))->current();
    }
    
    public function grabar(\Karina\Model\Categoria $categoria){
        $data = $categoria->toArray();
        $extra = array(
            'creado' => date('Y-m-d H:i:s'),
            'activo' => 1,
        );
        $this->tableGateway->insert(array_merge($data,$extra));
    }
    
    public function editar(\Karina\Model\Categoria $categoria, $id) {
        $this->tableGateway->update($categoria->toArray(true), array('id=?'=>$id));
    }
    
    public function setActivo($flag, $id) {
        $this->tableGateway->update(array('activo'=>(int)$flag), array('id=?'=>$id));
    }
    
    public function borrar($id) {
        $this->tableGateway->delete(array('id=?'=>$id));
    }
    
   
}