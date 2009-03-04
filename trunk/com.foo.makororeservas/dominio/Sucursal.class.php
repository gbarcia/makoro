<?php
/**
 * Description of Sucursalclass
 * Clase para manejar la informacion de las sucursales del sistema
 * @author maya
 */
class Sucursalclass {
    
    private $id;

    private $nombre;

    private $estado;

    private $ciudad;

    private $direccion;

    private $telefono;
    
    private $habilitado;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if(is_numeric($id))
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = strtoupper($nombre);
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

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = strtoupper($direccion);
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getHabilitado() {
        return $this->habilitado;
    }

    public function getHabilitadoString() {
        if ($this->habilitado == 1)
        return "SI";
        else
        return "NO";
    }

    public function setHabilitado($habilitado) {
        if (is_numeric($habilitado))
        $this->habilitado = $habilitado;
    }

    public function setHabilitadoString ($habilitado) {
        if ($habilitado == 1) {
            $this->habilitado = "SI";
        }
        else if ($habilitado == 0) {
            $this->habilitado = "NO";
        }
    }

}
?>
