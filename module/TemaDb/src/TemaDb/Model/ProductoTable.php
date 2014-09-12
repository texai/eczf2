<?php

namespace TemaDb\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ProductoTable {
    
    private $tableGateway;
    private $sl;
    
    public function __construct(TableGateway $tableGateway, $sl) {
        $this->tableGateway = $tableGateway;
        $this->sl = $sl;
    }
    
    public function fetchAll(){
        return $this->tableGateway->select();
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
   
}