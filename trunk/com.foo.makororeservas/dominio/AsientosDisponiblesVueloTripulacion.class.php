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
    private $disponibilidad;
    private $idVuelo;
    private $cantInfantes;

    function __construct($coleccionVuelo, $asientosDisponibles, $piloto, $copiloto, $disponibilidad, $idVuelo, $cantInfantes) {
        $this->coleccionVuelo = $coleccionVuelo;
        $this->asientosDisponibles = $asientosDisponibles;
        $this->piloto = $piloto;
        $this->copiloto = $copiloto;
        $this->disponibilidad = $disponibilidad;
        $this->idVuelo = $idVuelo;
        $this->cantInfantes = $cantInfantes;
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

    public function getDisponibilidad() {
        return $this->disponibilidad;
    }

    public function setDisponibilidad($disponibilidad) {
        $this->disponibilidad = $disponibilidad;
    }

    public function getIdvuelo() {
        return $this->idVuelo;
    }

    public function setIdvuelo($idVuelo) {
        $this->idVuelo = $idVuelo;
    }

    public function getCantinfantes() {
        return $this->cantInfantes;
    }

    public function setCantinfantes($cantInfantes) {
        $this->cantInfantes = $cantInfantes;
    }
       
}
?>
