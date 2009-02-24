<?php

/**
 * Description of Boletoclass
 * Clase para el manejo de los boletos
 * @author Diana Uribe
 */
class Boletoclass {
    private $id;
    private $pagoId;
    private $pasajeroId;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function getPagoId() {
        return $this->pagoId;
    }

    public function setPagoId($pagoId) {
        if (is_numeric($pagoId)) {
            $this->pagoId = $pagoId;
        }
    }

    public function getPasajeroId() {
        return $this->pasajeroId;
    }

    public function setPasajeroId($pasajeroId) {
        if (is_numeric($pasajeroId)) {
            $this->pasajeroId = $pasajeroId;
        }
    }
}
?>
