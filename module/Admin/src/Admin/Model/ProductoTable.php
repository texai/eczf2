<?php

namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class ProductoTable {
    
    private $tableGateway;
    private $sl;
    
    public function __construct(TableGateway $tableGateway, $sl) {
        $this->tableGateway = $tableGateway;
        $this->sl = $sl;
    }
    
    public function fetchAll($paginated = false){
        if ($paginated) {
            $select = new Select('producto');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(new Producto());
            
            $paginatorAdapter = new DbSelect(
                    $select, $this->tableGateway->getAdapter(), $resultSetPrototype
            );
            $paginator = new Paginator($paginatorAdapter);           
            return $paginator;
        }
        
        $paginated = $this->tableGateway->select();
        return $paginated;
        
    }
    
    public function getById($id) {
        return $this->tableGateway->select(array('id=?'=>$id))->current();
    }
    
    public function listarProductosCompleto(){
        return $this->tableGateway->select(function (Select $select){
            $select->columns(array(
                'id',
                'producto' => 'nombre',
                'costo'=>'precio_compra',
                'precio'=>'precio_venta'
            ))
            ->join(
                array('c'=>'categoria'),
                'c.id=producto.categoria_id',
                array('categoria'=>'nombre')
            )->join(
                array('pr'=>'proveedor'),
                'pr.id=producto.proveedor_id',
                array('proveedor'=>'nombre')
            );
            
        });
    }
   
    public function grabar(\Admin\Model\Producto $producto){
        $data = $producto->toArray();
        $extra = array(
            'categoria_id' => 1,
            'proveedor_id' => 1,
            'precio_compra' => 400,
            'precio_venta' => 750,
            'activo' => 1,
        );
        $this->tableGateway->insert(array_merge($data,$extra));
    }
     public function editar(\Admin\Model\Producto $producto, $id) {
        $this->tableGateway->update($producto->toArray(true), array('id=?'=>$id));
    }
    
    public function setActivo($flag, $id) {
        $this->tableGateway->update(array('activo'=>(int)$flag), array('id=?'=>$id));
    }
    
    public function borrar($id) {
        $this->tableGateway->delete(array('id=?'=>$id));
    }
}