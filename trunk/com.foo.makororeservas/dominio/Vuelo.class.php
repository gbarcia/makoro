<?php
/**
 * Description of Vueloclass
 * Clase para manejar los vuelos
 * @author Diana Uribe
 */
class Vueloclass {
    private $id;
    private $fecha;
    private $hora;
    private $rutaSitioSalida;
    private $rutaSitioLLegada;
    private $avionMatricula;
    private $asientos;
    private $cantidadInfantes;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function getAvionMatricula() {
        return $this->avionMatricula;
    }

    public function setAvionMatricula($avionMatricula) {
        $this->avionMatricula = strtoupper($avionMatricula);
    }

    public function getRutaSitioSalida() {
        return $this->rutaSitioSalida;
    }

    public function setRutaSitioSalida($rutaSitioSalida) {
        $this->rutaSitioSalida = strtoupper($rutaSitioSalida);
    }

    public function getRutaSitioLLegada() {
        return $this->rutaSitioLLegada;
    }

    public function setRutaSitioLLegada($rutaSitioLLegada) {
        $this->rutaSitioLLegada = strtoupper($rutaSitioLLegada);
    }

    public function getAsientos() {
        return $this->asientos;
    }

    public function setAsientos($asientos) {
        if (is_numeric($asientos)) {
            $this->asientos = $asientos;
        }
    }

    public function getCantidadinfantes() {
        return $this->cantidadInfantes;
    }

    public function setCantidadinfantes($cantidadInfantes) {
        $this->cantidadInfantes = $cantidadInfantes;
    }
        
}
?>