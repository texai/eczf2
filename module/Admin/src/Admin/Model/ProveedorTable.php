<?php

namespace Admin\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProveedorTable {
    
    private $tableGateway;
    private $sl;
    
    public function __construct(TableGateway $tableGateway, $sl) {
        $this->tableGateway = $tableGateway;
        $this->sl = $sl;
    }
    
    public function fetchAll($paginated = false){
        if ($paginated) {
            $select = new Select('proveedor');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Proveedor());
            
            $paginatorAdapter = new DbSelect(
                    $select, $this->tableGateway->getAdapter(), $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getById($id) {
        return $this->tableGateway->select(array('id=?'=>$id))->current();
    }
    
    public function grabar(\Admin\Model\Proveedor $categoria){
        $data = $categoria->toArray();
        $extra = array(
            'creado' => date('Y-m-d H:i:s'),
            'activo' => 1,
        );
        $this->tableGateway->insert(array_merge($data,$extra));
    }
    
    public function editar(\Admin\Model\Proveedor $categoria, $id) {
        $this->tableGateway->update($categoria->toArray(true), array('id=?'=>$id));
    }
    
    public function setActivo($flag, $id) {
        $this->tableGateway->update(array('activo'=>(int)$flag), array('id=?'=>$id));
    }
    
    public function borrar($id) {
        $this->tableGateway->delete(array('id=?'=>$id));
    }
   
}