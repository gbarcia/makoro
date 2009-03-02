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
    private $fechaVuelta;
    private $lugarSalida;
    private $lugarLlegada;
    private $coleccionPasajero;
    private $servicio;

    function __construct($agente, $solicitud, $fechaIda, $fechaVuelta, $lugarSalida, $lugarLlegada, $coleccionPasajero, $servicio) {
        $this->agente = $agente;
        $this->solicitud = $solicitud;
        $this->fechaIda = $fechaIda;
        $this->fechaVuelta = $fechaVuelta;
        $this->lugarSalida = $lugarSalida;
        $this->lugarLlegada = $lugarLlegada;
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

    public function getLugarSalida() {
        return $this->lugarSalida;
    }

    public function setLugarSalida($lugarSalida) {
        $this->lugarSalida = $lugarSalida;
    }

    public function getLugarLlegada() {
        return $this->lugarLlegada;
    }

    public function setLugarLlegada($lugarLlegada) {
        $this->lugarLlegada = $lugarLlegada;
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