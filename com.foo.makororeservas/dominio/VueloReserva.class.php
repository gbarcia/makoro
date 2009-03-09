<?php
/**
 * Description of VueloReservaclass
 * Clase para el manejo de los vuelos que han sido reservados 
 * @author maya
 */
class VueloReservaclass {
    private $vueloId;
    private $reservaId;
    private $tipo;

    public function getVueloid() {
        return $this->vueloId;
    }

    public function setVueloid($vueloId) {
        $this->vueloId = $vueloId;
    }

    public function getReservaid() {
        return $this->reservaId;
    }

    public function setReservaid($reservaId) {
        $this->reservaId = $reservaId;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = strtoupper($tipo);
    }

}
?>
