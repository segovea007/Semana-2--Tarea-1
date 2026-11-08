<?php

class Cliente {

    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $telefono;

    public function __construct($id, $nombre, $apellido, $correo, $telefono) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->telefono = $telefono;
    }
}
?>