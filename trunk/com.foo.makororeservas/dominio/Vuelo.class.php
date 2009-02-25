<?php

/**
 * Description of Vuelo
 * 
 * @author Diana Uribe
 */
class Vuelo {
    private $id;
    private $fecha;
    private $hora;
    private $rutaSitioSalida;
    private $rutaSitioLLegada;
    private $avionMatricula;
    private $piloto;
    private $copiloto;

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
