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
    private $disponibilidadAdulto;
    private $disponibilidadInfante;
    private $idVuelo;
    private $cantInfantes;
    private $cantInfantesQuedan;

    function __construct($coleccionVuelo, $asientosDisponibles, $piloto, $copiloto, $disponibilidadAdulto, $disponibilidadInfante, $idVuelo, $cantInfantes, $cantInfantesQuedan) {
        $this->coleccionVuelo = $coleccionVuelo;
        $this->asientosDisponibles = $asientosDisponibles;
        $this->piloto = $piloto;
        $this->copiloto = $copiloto;
        $this->disponibilidadAdulto = $disponibilidadAdulto;
        $this->disponibilidadInfante = $disponibilidadInfante;
        $this->idVuelo = $idVuelo;
        $this->cantInfantes = $cantInfantes;
        $this->cantInfantesQuedan = $cantInfantesQuedan;
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

    public function getDisponibilidadadulto() {
        return $this->disponibilidadAdulto;
    }

    public function setDisponibilidadadulto($disponibilidadAdulto) {
        $this->disponibilidadAdulto = $disponibilidadAdulto;
    }

    public function getDisponibilidadinfante() {
        return $this->disponibilidadInfante;
    }

    public function setDisponibilidadinfante($disponibilidadInfante) {
        $this->disponibilidadInfante = $disponibilidadInfante;
    }

    public function getCantinfantesquedan() {
        return $this->cantInfantesQuedan;
    }
        
    public function setCantinfantesquedan($cantInfantesQuedan) {
        $this->cantInfantesQuedan = $cantInfantesQuedan;
    }

}
?>