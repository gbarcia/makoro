<?php
/**
 * Description of ClienteParticularclass
 * Clase para manejar la informacion de los clientes particulares del sistema
 * @author maya
 */
class ClienteParticularclass {
    private $cedula;
    private $nombre;
    private $apellido;
    private $sexo;
    private $fechaNacimiento;
    private $telefono;
    private $estado;
    private $ciudad;
    private $direccion;

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        if(is_numeric($cedula))
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

    public function getFechanacimiento() {
        return $this->fechaNacimiento;
    }

    public function setFechanacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
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


}
?>
