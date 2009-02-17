<?php
/**
 * Description of Tripulanteclass
 * Clase para manejar la informacion de un tripulante
 * @author gerardobarcia
 */
class Tripulanteclass {

    private $cedula;

    private $nombre;

    private $apellido;

    private $sexo;

    private $telefono;

    private $estado;

    private $ciudad;

    private $direccion;

    private $habilitado;

    private $cargo;

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        if (is_numeric($cedula))
            $this->cedula = $cedula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {

        $this->nombre = strtoupper($nombre);
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = strtoupper($apellido);
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo($sexo) {
        if (($sexo == 'M') || ($sexo == 'F') ||($sexo == 'm') || ($sexo == 'f'))
        $this->sexo = strtoupper($sexo);

    }
    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
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

    public function getHabilitado() {
        return $this->habilitado;
    }

    public function setHabilitado($habilitado) {
        if (is_numeric($habilitado))
        $this->habilitado = $habilitado;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function setCargo($cargo) {
        $this->cargo = strtoupper($cargo);
    }

}
?>
