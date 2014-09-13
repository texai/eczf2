<?php


namespace TemaDb\Model;

class Proveedor {
    
    protected $id;
    protected $nombre;
    protected $ruc;
    protected $email;
    protected $creado;
    protected $activo;

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRuc() {
        return $this->ruc;
    }

    public function getEmail() {
        return $this->email;
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

    public function setRuc($ruc) {
        $this->ruc = $ruc;
    }

    public function setEmail($email) {
        $this->email = $email;
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
        $this->ruc      = (isset($data['ruc'])) ? $data['ruc']: null;
        $this->email    = (isset($data['email'])) ? $data['email']: null;
        $this->creado   = (isset($data['creado'])) ? $data['creado']: null;
        $this->activo   = (isset($data['activo'])) ? $data['activo']: null;
    }
    

    
}