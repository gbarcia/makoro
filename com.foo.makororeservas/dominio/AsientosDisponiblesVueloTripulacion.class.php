<?php

/**
 * Description of AsientosDisponiblesVueloTripulacionclass
 * Clase para manejar la cantidad de asietos disponibles en un vuelo
 * determinado por el usuario
 * @author Diana Uribe
 */
class AsientosDisponiblesVueloTripulacionclass {
    private $coleccionVuelo;
    private $asientosDisponibles;
    private $piloto;
    private $copiloto;

    function __construct($coleccionVuelo, $asientosDisponibles, $piloto, $copiloto) {
        $this->coleccionVuelo = $coleccionVuelo;
        $this->asientosDisponibles = $asientosDisponibles;
        $this->piloto = $piloto;
        $this->copiloto = $copiloto;
    }


    public function getColeccionVuelo() {
        return $this->coleccionVuelo;
    }

    public function setColeccionVuelo($coleccionVuelo) {
        $this->coleccionVuelo = $coleccionVuelo;
    }

    public function getAsientosDisponibles() {
        return $this->asientosDisponibles;
    }

    public function setAsientosDisponibles($asientosDisponibles) {
        $this->asientosDisponibles = $asientosDisponibles;
    }

    public function getPiloto() {
        return $this->piloto;
    }

    public function setPiloto($piloto) {
        $this->piloto = $piloto;
    }

    public function getCopiloto() {
        return $this->copiloto;
    }

    public function setCopiloto($copiloto) {
        $this->copiloto = $copiloto;
    }
}
?>
