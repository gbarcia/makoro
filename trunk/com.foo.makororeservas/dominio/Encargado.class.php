<?php

/**
 * Description of Encargadoclass
 * Entidad con los datos de los encargados (Vendedores del Sistema)
 * @author gerardobarcia
 */
class Encargadoclass {
    
    private $cedula;

    private $nombre;

    private $apellido;

    private $sexo;

    private $fechaNac;

    private $tipo;

    private $login;

    private $clave;

    private $estado;

    private $ciudad;

    private $direccion;

    private $telefono;

    private $habilitado;

    private $sucursalDondeTrabaja;

    private $sucursalDondeTrabajaString;

    function __construct() {
    }

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
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
        $this->sexo = strtoupper($sexo);
    }

    public function getFechaNac() {
        return $this->fechaNac;
    }

    public function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
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
        $this->telefono = strtoupper($telefono);
    }

    public function getHabilitado() {
        return $this->habilitado;
    }

    public function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    public function getSucursalDondeTrabaja() {
        return $this->sucursalDondeTrabaja;
    }

    public function setSucursalDondeTrabaja($sucursalDondeTrabaja) {
        $this->sucursalDondeTrabaja = $sucursalDondeTrabaja;
    }

    public function getSucursalDondeTrabajaString() {
        return $this->sucursalDondeTrabajaString;
    }

    public function setSucursalDondeTrabajaString($sucursalDondeTrabajaString) {
        $this->sucursalDondeTrabajaString = strtoupper($sucursalDondeTrabajaString);
    }
}
?>
