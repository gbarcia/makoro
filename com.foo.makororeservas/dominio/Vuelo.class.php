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
    private $avionMatricula;
    private $rutaSitioSalida;
    private $rutaSitioLLegada;

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
}
?>
