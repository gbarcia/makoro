<?php
/**
 * Description of Reservaclass
 * Clase para manejar las reservas
 * @author Diana Uribe
 */
class Reservaclass {
    private $id;
    private $fecha;
    private $estado;
    private $solicitud;
    private $tipoServicioId;
    private $sucursalId;
    private $encargadoCedula;
    private $clienteParticularCedula;
    private $clienteAgenciaRif;
    private $pagoId;
    private $pasajeroId;
    private $posadaId;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if(is_numeric($id)){
            $this->id = $id;
        }
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = strtoupper($estado);
    }

    public function getSolicitud() {
        return $this->solicitud;
    }

    public function setSolicitud($solicitud) {
        $this->solicitud = $solicitud;
    }

    public function getTipoServicioId() {
        return $this->tipoServicioId;
    }

    public function setTipoServicioId($tipoServicioId) {
        if(is_numeric($tipoServicioId)){
            $this->tipoServicioId = $tipoServicioId;
        }
    }

    public function getSucursalId() {
        return $this->sucursalId;
    }

    public function setSucursalId($sucursalId) {
        if(is_numeric($sucursalId)){
            $this->sucursalId = $sucursalId;
        }
    }

    public function getEncargadoCedula() {
        return $this->encargadoCedula;
    }

    public function setEncargadoCedula($encargadoCedula) {
        if(is_numeric($encargadoCedula)){
            $this->encargadoCedula = $encargadoCedula;
        }
    }

    public function getClienteParticularCedula() {
        return $this->clienteParticularCedula;
    }

    public function setClienteParticularCedula($clienteParticularCedula) {
        $this->clienteParticularCedula = $clienteParticularCedula;
    }

    public function getClienteAgenciaRif() {
        return $this->clienteAgenciaRif;
    }

    public function setClienteAgenciaRif($clienteAgenciaRif) {
        if (is_null($clienteAgenciaRif)){
            $this->clienteAgenciaRif = null;
        }else{
            $this->clienteAgenciaRif = strtoupper($clienteAgenciaRif);
        }
    }

    public function getPagoId() {
        return $this->pagoId;
    }

    public function setPagoId($pagoId) {
        if(is_numeric($pagoId)){
            $this->pagoId = $pagoId;
        }
    }

    public function getPasajeroId() {
        return $this->pasajeroId;
    }

    public function setPasajeroId($pasajeroId) {
        if(is_numeric($pasajeroId)){
            $this->pasajeroId = $pasajeroId;
        }
    }

    public function getPosadaId() {
        return $this->posadaId;
    }

    public function setPosadaId($posadaId) {
        if(is_numeric($posadaId)){
            $this->posadaId = $posadaId;
        }
    }

}
?>