<?php
/**
 * Description of Equipajeclass
 * Clase para el manejo del equipaje de un pasajero
 * @author jonathan
 */
class Equipajeclass {

    private $descripcion;

    private $tipo;

    private $peso;

    private $reservaId;

    function __construct() {
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        if (($tipo == "M") || ($tipo == "C") || ($tipo == "A") || ($tipo == "O")){
            $this->tipo = $tipo;
        }
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        if (is_numeric($peso)){
            $this->peso = $peso;
        }
    }

    public function getReservaId() {
        return $this->reservaId;
    }

    public function setReservaId($reservaId) {
        if (is_numeric($reservaId)){
            $this->reservaId = $reservaId;
        }
    }

}
?>
