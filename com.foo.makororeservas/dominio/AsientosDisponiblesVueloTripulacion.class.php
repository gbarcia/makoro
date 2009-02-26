<?php

/**
 * Description of AsientosDisponiblesVueloTripulacionclass
 * Clase para manejar la cantidad de asietos disponibles en un vuelo
 * determinado por el usuario
 * @author Diana Uribe
 */
class AsientosDisponiblesVueloTripulacionclass {
    private $vuelo;
    private $asientosDisponibles;
    private $piloto;
    private $copiloto;

    function __construct($vuelo, $asientosDisponibles, $piloto, $copiloto) {
        $this->vuelo = $vuelo;
        $this->asientosDisponibles = $asientosDisponibles;
        $this->piloto = $piloto;
        $this->copiloto = $copiloto;
    }

    public function getVuelo() {
        return $this->vuelo;
    }

    public function setVuelo($vuelo) {
        $this->vuelo = $vuelo;
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
