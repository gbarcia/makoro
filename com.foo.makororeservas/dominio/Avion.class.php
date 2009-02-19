<?php

/**
 * Description of Avionclass
 *
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
        $this->matricula = $matricula;
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
