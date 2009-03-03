<?php
/**
 * Description of EmitirBoletoclass
 * Clase para emitir los boletos
 * @author Diana Uribe
 */
class EmitirBoletoclass {
    private $agente;
    private $solicitud;
    private $fechaEmision;
    private $fechaIda;
    private $horaIda;
    private $fechaVuelta;
    private $horaVuelta;
    private $salida;
    private $retorno;
    private $coleccionPasajero;
    private $servicio;

    function __construct($agente, $solicitud, $fechaEmision, $fechaIda, $horaIda, $fechaVuelta, $horaVuelta, $salida, $retorno, $coleccionPasajero, $servicio) {
        $this->agente = $agente;
        $this->solicitud = $solicitud;
        $this->fechaEmision = $fechaEmision;
        $this->fechaIda = $fechaIda;
        $this->horaIda = $horaIda;
        $this->fechaVuelta = $fechaVuelta;
        $this->horaVuelta = $horaVuelta;
        $this->salida = $salida;
        $this->retorno = $retorno;
        $this->coleccionPasajero = $coleccionPasajero;
        $this->servicio = $servicio;
    }

    public function getAgente() {
        return $this->agente;
    }

    public function setAgente($agente) {
        $this->agente = $agente;
    }

    public function getSolicitud() {
        return $this->solicitud;
    }

    public function setSolicitud($solicitud) {
        $this->solicitud = $solicitud;
    }

    public function getFechaEmision() {
        return $this->fechaEmision;
    }

    public function setFechaEmision($fechaEmision) {
        $this->fechaEmision = $fechaEmision;
    }

    public function getFechaIda() {
        return $this->fechaIda;
    }

    public function setFechaIda($fechaIda) {
        $this->fechaIda = $fechaIda;
    }

    public function getFechaVuelta() {
        return $this->fechaVuelta;
    }

    public function setFechaVuelta($fechaVuelta) {
        $this->fechaVuelta = $fechaVuelta;
    }

    public function getHoraIda() {
        return $this->horaIda;
    }

    public function setHoraIda($horaIda) {
        $this->horaIda = $horaIda;
    }

    public function getHoraVuelta() {
        return $this->horaVuelta;
    }

    public function setHoraVuelta($horaVuelta) {
        $this->horaVuelta = $horaVuelta;
    }

    public function getSalida() {
        return $this->salida;
    }

    public function setSalida($salida) {
        $this->salida = $salida;
    }

    public function getRetorno() {
        return $this->retorno;
    }

    public function setRetorno($retorno) {
        $this->retorno = $retorno;
    }



    public function getColeccionPasajero() {
        return $this->coleccionPasajero;
    }

    public function setColeccionPasajero($coleccionPasajero) {
        $this->coleccionPasajero = $coleccionPasajero;
    }

    public function getServicio() {
        return $this->servicio;
    }

    public function setServicio($servicio) {
        $this->servicio = $servicio;
    }

}
?>