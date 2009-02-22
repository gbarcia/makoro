<?php
/**
 * Description of Pasajeroclass
 * Clase para manejar la información de los pasajeros
 * @author Diana Uribe
 */
class Pasajeroclass {
    private $id;
    private $nombre;
    private $apellido;
    private $sexo;
    private $cedula;
    private $pasaporte;
    private $nacionalidad;
    private $tipoPasajeroId;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_numeric($id)) {
            $this->id = $id;
        }
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

    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        if (is_numeric($cedula)) {
            $this->cedula = $cedula;
        }
    }

    public function getPasaporte() {
        return $this->pasaporte;
    }

    public function setPasaporte($pasaporte) {
        $this->pasaporte = strtoupper($pasaporte);
    }

    public function getNacionalidad() {
        return $this->nacionalidad;
    }

    public function setNacionalidad($nacionalidad) {
        $this->nacionalidad = strtoupper($nacionalidad);
    }

    public function getTipoPasajeroId() {
        return $this->tipoPasajeroId;
    }

    public function setTipoPasajeroId($tipoPasajeroId) {
        $this->tipoPasajeroId = strtoupper($tipoPasajeroId);
    }
}
?>
