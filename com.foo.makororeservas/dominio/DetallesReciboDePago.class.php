<?php
/**
 * Description of DetallesReciboDePagoclass
 * Clase para manejar los detalles del recibo de pago, cantidad de pasajeros,
 * costos, subtotales, comisiones
 * @author Diana Uribe
 */
class DetallesReciboDePagoclass {
    private $cantidadAdultosSalida;
    private $cantidadAdultosLlegada;
    private $cantidadNinosSalida;
    private $cantidadNinosLlegada;
    private $cantidadInfantes;
    private $costoSalida;
    private $costoPasajeNinosSalida;
    private $costoLlegada;
    private $costoPasajeNinosLlegada;
    private $subtotalAdultosSalida;
    private $subtotalAdultosLlegada;
    private $subtotalNinosSalida;
    private $subtotalNinosLlegada;
    private $subtotalAdultosNinos;
    private $porcentajeIvaSalida;
    private $porcentajeIvaLlegada;
    private $comisionAgencia;
    private $totalApagar;

    function __construct($cantidadAdultosSalida, $cantidadAdultosLlegada, $cantidadNinosSalida, $cantidadNinosLlegada, $cantidadInfantes, $costoSalida, $costoPasajeNinosSalida, $costoLlegada, $costoPasajeNinosLlegada, $subtotalAdultosSalida, $subtotalAdultosLlegada, $subtotalNinosSalida, $subtotalNinosLlegada, $subtotalAdultosNinos, $porcentajeIvaSalida, $porcentajeIvaLlegada, $comisionAgencia, $totalApagar) {
        $this->cantidadAdultosSalida = $cantidadAdultosSalida;
        $this->cantidadAdultosLlegada = $cantidadAdultosLlegada;
        $this->cantidadNinosSalida = $cantidadNinosSalida;
        $this->cantidadNinosLlegada = $cantidadNinosLlegada;
        $this->cantidadInfantes = $cantidadInfantes;
        $this->costoSalida = $costoSalida;
        $this->costoPasajeNinosSalida = $costoPasajeNinosSalida;
        $this->costoLlegada = $costoLlegada;
        $this->costoPasajeNinosLlegada = $costoPasajeNinosLlegada;
        $this->subtotalAdultosSalida = $subtotalAdultosSalida;
        $this->subtotalAdultosLlegada = $subtotalAdultosLlegada;
        $this->subtotalNinosSalida = $subtotalNinosSalida;
        $this->subtotalNinosLlegada = $subtotalNinosLlegada;
        $this->subtotalAdultosNinos = $subtotalAdultosNinos;
        $this->porcentajeIvaSalida = $porcentajeIvaSalida;
        $this->porcentajeIvaLlegada = $porcentajeIvaLlegada;
        $this->comisionAgencia = $comisionAgencia;
        $this->totalApagar = $totalApagar;
    }

    public function getCantidadAdultosSalida() {
        return $this->cantidadAdultosSalida;
    }

    public function setCantidadAdultosSalida($cantidadAdultosSalida) {
        $this->cantidadAdultosSalida = $cantidadAdultosSalida;
    }

    public function getCantidadAdultosLlegada() {
        return $this->cantidadAdultosLlegada;
    }

    public function setCantidadAdultosLlegada($cantidadAdultosLlegada) {
        $this->cantidadAdultosLlegada = $cantidadAdultosLlegada;
    }

    public function getCantidadNinosSalida() {
        return $this->cantidadNinosSalida;
    }

    public function setCantidadNinosSalida($cantidadNinosSalida) {
        $this->cantidadNinosSalida = $cantidadNinosSalida;
    }

    public function getCantidadNinosLlegada() {
        return $this->cantidadNinosLlegada;
    }

    public function setCantidadNinosLlegada($cantidadNinosLlegada) {
        $this->cantidadNinosLlegada = $cantidadNinosLlegada;
    }

    public function getCantidadInfantes() {
        return $this->cantidadInfantes;
    }

    public function setCantidadInfantes($cantidadInfantes) {
        $this->cantidadInfantes = $cantidadInfantes;
    }

    public function getCostoSalida() {
        return $this->costoSalida;
    }

    public function setCostoSalida($costoSalida) {
        $this->costoSalida = $costoSalida;
    }

    public function getCostoPasajeNinosSalida() {
        return $this->costoPasajeNinosSalida;
    }

    public function setCostoPasajeNinosSalida($costoPasajeNinosSalida) {
        $this->costoPasajeNinosSalida = $costoPasajeNinosSalida;
    }

    public function getCostoLlegada() {
        return $this->costoLlegada;
    }

    public function setCostoLlegada($costoLlegada) {
        $this->costoLlegada = $costoLlegada;
    }

    public function getCostoPasajeNinosLlegada() {
        return $this->costoPasajeNinosLlegada;
    }

    public function setCostoPasajeNinosLlegada($costoPasajeNinosLlegada) {
        $this->costoPasajeNinosLlegada = $costoPasajeNinosLlegada;
    }

    public function getSubtotalAdultosSalida() {
        return $this->subtotalAdultosSalida;
    }

    public function setSubtotalAdultosSalida($subtotalAdultosSalida) {
        $this->subtotalAdultosSalida = $subtotalAdultosSalida;
    }

    public function getSubtotalAdultosLlegada() {
        return $this->subtotalAdultosLlegada;
    }

    public function setSubtotalAdultosLlegada($subtotalAdultosLlegada) {
        $this->subtotalAdultosLlegada = $subtotalAdultosLlegada;
    }

    public function getSubtotalNinosSalida() {
        return $this->subtotalNinosSalida;
    }

    public function setSubtotalNinosSalida($subtotalNinosSalida) {
        $this->subtotalNinosSalida = $subtotalNinosSalida;
    }

    public function getSubtotalNinosLlegada() {
        return $this->subtotalNinosLlegada;
    }

    public function setSubtotalNinosLlegada($subtotalNinosLlegada) {
        $this->subtotalNinosLlegada = $subtotalNinosLlegada;
    }

    public function getSubtotalAdultosNinos() {
        return $this->subtotalAdultosNinos;
    }

    public function setSubtotalAdultosNinos($subtotalAdultosNinos) {
        $this->subtotalAdultosNinos = $subtotalAdultosNinos;
    }

    public function getPorcentajeIvaSalida() {
        return $this->porcentajeIvaSalida;
    }

    public function setPorcentajeIvaSalida($porcentajeIvaSalida) {
        $this->porcentajeIvaSalida = $porcentajeIvaSalida;
    }

    public function getPorcentajeIvaLlegada() {
        return $this->porcentajeIvaLlegada;
    }

    public function setPorcentajeIvaLlegada($porcentajeIvaLlegada) {
        $this->porcentajeIvaLlegada = $porcentajeIvaLlegada;
    }

    public function getComisionAgencia() {
        return $this->comisionAgencia;
    }

    public function setComisionAgencia($comisionAgencia) {
        $this->comisionAgencia = $comisionAgencia;
    }

    public function getTotalApagar() {
        return $this->totalApagar;
    }

    public function setTotalApagar($totalApagar) {
        $this->totalApagar = $totalApagar;
    }
}
?>