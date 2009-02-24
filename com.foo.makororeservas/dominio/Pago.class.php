<?php

/**
 * Description of Pagoclass
 * Clase para el manejo de la informacion de los pagos
 * @author Diana Uribe
 */
class Pagoclass {
    private $id;
    private $tipo;
    private $monto;
    private $nombreBanco;
    private $numeroTransaccion;
    private $monedaId;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = strtoupper($tipo);
    }

    public function getMonto() {
        return $this->monto;
    }

    public function setMonto($monto) {
        if (is_numeric($monto)) {
            $this->monto = $monto;
        }
    }

    public function getNombreBanco() {
        return $this->nombreBanco;
    }

    public function setNombreBanco($nombreBanco) {
        $this->nombreBanco = strtoupper($nombreBanco);
    }

    public function getNumeroTransaccion() {
        return $this->numeroTransaccion;
    }

    public function setNumeroTransaccion($numeroTransaccion) {
        $this->numeroTransaccion = $numeroTransaccion;
    }

    public function getMonedaId() {
        return $this->monedaId;
    }

    public function setMonedaId($monedaId) {
        if (is_numeric($monedaId)) {
            $this->monedaId = $monedaId;
        }
    }
}
?>
