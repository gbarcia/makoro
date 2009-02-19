<?php
/**
 * Description of PagoNominaTripulacionclass
 * Clase para almacenar informacion sobre los pagos de las nominas.
 * @author gerardobarcia
 */
class PagoNominaTripulacionclass {

    private $coleccionDetalles;

    private $totalPago;

    private $tripulante;

    function __construct($coleccionDetalles, $totalPago, $infoTripulante) {
        $this->coleccionDetalles = $coleccionDetalles;
        $this->totalPago = $totalPago;
        $this->tripulante = $infoTripulante;
    }


    public function getColeccionDetalles() {
        return $this->coleccionDetalles;
    }

    public function setColeccionDetalles($coleccionDetalles) {
        $this->coleccionDetalles = $coleccionDetalles;
    }

    public function getTotalPago() {
        return $this->totalPago;
    }

    public function setTotalPago($totalPago) {
        $this->totalPago = $totalPago;
    }

    public function getTripulante() {
        return $this->tripulante;
    }

    public function setTripulante($tripulante) {
        $this->tripulante = $tripulante;
    }
}
?>
