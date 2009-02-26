<?php

/**
 * Description of CantidadAsientosDisponiblesVueloclass
 * Clase para manejar la cantidad de asietos disponibles en un vuelo
 * determinado por el usuario
 * @author Diana Uribe
 */
class CantidadAsientosDisponiblesVueloclass {
    private $vuelo;
    private $asientosDisponibles;


    function __construct($vuelo, $asientosDisponibles) {
        $this->vuelo = $vuelo;
        $this->asientosDisponibles = $asientosDisponibles;
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
}
?>
