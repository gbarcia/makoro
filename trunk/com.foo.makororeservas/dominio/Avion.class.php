<?php

/**
 * Description of Avionclass
 * Clase para manejar la informacion de los aviones del sistema
 * @author Diana Uribe
 */
class Avionclass {
    private $matricula;
    private $asientos;
    private $habilitado;

    public function getMatricula() {
        return $this->matricula;
    }

    public function setMatricula($matricula) {
        $this->matricula = strtoupper($matricula);
    }

    public function getAsientos() {
        return $this->asientos;
    }

    public function setAsientos($asientos) {
        if (is_numeric($asientos)) {
            $this->asientos = $asientos;
        }
    }

    public function getHabilitado() {
        return $this->habilitado;
    }

    public function setHabilitado($habilitado) {
        if (is_numeric($habilitado)) {
            $this->habilitado = $habilitado;
        }
    }
}
?>
