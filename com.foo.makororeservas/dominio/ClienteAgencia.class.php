<?php

/**
 * Description of ClienteAgenciaclass
 * Clase para manejar la informacion de los clientes agencias del sistema
 * @author Diana Uribe
 */
class ClienteAgenciaclass {
    private $rif;
    private $nombre;
    private $telefono;
    private $direccion;
    private $estado;
    private $ciudad;
    private $porcentajeComision;

    public function getRif() {
        return $this->rif;
    }

    public function setRif($rif) {
        $this->rif = strtoupper($rif);
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = strtoupper($nombre);
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = strtoupper($direccion);
    }
        
    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = strtoupper($estado);
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = strtoupper($ciudad);
    }

    public function getPorcentajeComision() {
        return $this->porcentajeComision;
    }

    public function setPorcentajeComision($porcentajeComision) {
        if (is_numeric($porcentajeComision)){
            $this->porcentajeComision = $porcentajeComision;
        }
    }
}
?>
