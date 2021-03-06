<?php

namespace Admin\Model;

class Producto {

    protected $id;
    protected $categoria_id;
    protected $proveedor_id;
    protected $nombre;
    protected $precio_compra;
    protected $precio_venta;
    protected $activo;
    
    
        public function getId() {
        return $this->id;
    }

    public function getCategoria_id() {
        return $this->categoria_id;
    }

    public function getProveedor_id() {
        return $this->proveedor_id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrecio_compra() {
        return $this->precio_compra;
    }

    public function getPrecio_venta() {
        return $this->precio_venta;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCategoria_id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }

    public function setProveedor_id($proveedor_id) {
        $this->proveedor_id = $proveedor_id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPrecio_compra($precio_compra) {
        $this->precio_compra = $precio_compra;
    }

    public function setPrecio_venta($precio_venta) {
        $this->precio_venta = $precio_venta;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }
    
    public function exchangeArray(array $data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->categoria_id = (isset($data['categoria_id'])) ? $data['categoria_id'] : null;
        $this->proveedor_id = (isset($data['proveedor_id'])) ? $data['proveedor_id'] : null;
        $this->nombre = (isset($data['nombre'])) ? $data['nombre'] : null;
        $this->precio_compra = (isset($data['precio_compra'])) ? $data['precio_compra'] : null;
        $this->precio_venta = (isset($data['precio_venta'])) ? $data['precio_venta'] : null;
        $this->activo = (isset($data['activo'])) ? $data['activo'] : null;
    }
    
    public function toArray($partial = false) {
        $arr = array(
            'id'            => $this->getId(),
            'categoria_id'        => $this->getCategoria_id(),
            'proveedor_id'        => $this->getProveedor_id(),
            'nombre'        => $this->getNombre(),
            'precio_compra'        => $this->getPrecio_compra(),
            'precio_venta'        => $this->getPrecio_venta(),
            'activo'        => $this->getActivo()
            
        );
        if($partial){
            foreach ($arr as $key => $value) {
                if(is_null($value)){
                    unset($arr[$key]);
                }
            }
        }
        return $arr;
        
    }    

}
