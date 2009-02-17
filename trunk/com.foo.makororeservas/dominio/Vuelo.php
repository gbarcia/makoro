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
    private $rutaId;
    private $avionMatricula;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_integer($id)) {
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

    public function getRutaId() {
        return $this->rutaId;
    }

    public function setRutaId($rutaId) {
        if (is_integer($rutaId)) {
            $this->rutaId = $rutaId;
        }
    }

    public function getAvionMatricula() {
        return $this->avionMatricula;
    }

    public function setAvionMatricula($avionMatricula) {
        $this->avionMatricula = strtoupper($avionMatricula);
    }
}
?>
