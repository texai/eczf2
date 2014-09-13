<?php

namespace TemaDb\Model;

class Categoria {
    
    protected $id;
    protected $nombre;
    protected $creado;
    protected $activo;
    
    
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCreado() {
        return $this->creado;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setCreado($creado) {
        $this->creado = $creado;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }


    public function exchangeArray(array $data)
    {
        $this->id       = (isset($data['id'])) ? $data['id']: null;
        $this->nombre   = (isset($data['nombre'])) ? $data['nombre']: null;
        $this->creado   = (isset($data['creado'])) ? $data['creado']: null;
        $this->activo   = (isset($data['activo'])) ? $data['activo']: null;
    }
    
    public function isImportacion(){
        return rand(0,1);
    }
    
    
}
