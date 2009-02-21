<?php
/**
 * Description of Posadaclass
 * Clase para manejar la informacion de las posadas
 * @author jonathan
 */
class Posadaclass {
    private $id;
    private $nombrePosada;
    private $nombreEncargado;
    private $apellidoEncargado;
    private $telefono;

    function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombrePosada() {
        return $this->nombrePosada;
    }

    public function setNombrePosada($nombrePosada) {
        $this->nombrePosada = $nombrePosada;
    }

    public function getNombreEncargado() {
        return $this->nombreEncargado;
    }

    public function setNombreEncargado($nombreEncargado) {
        $this->nombreEncargado = $nombreEncargado;
    }

    public function getApellidoEncargado() {
        return $this->apellidoEncargado;
    }

    public function setApellidoEncargado($apellidoEncargado) {
        $this->apellidoEncargado = $apellidoEncargado;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
        
}
?>
