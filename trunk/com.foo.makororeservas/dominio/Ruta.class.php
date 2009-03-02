<?php
/**
 * Description of Rutaclass
 *
 * @author Diana Uribe
 */
class Rutaclass {

    private $sitioSalida;
    private $sitioLlegada;
    private $tiempo;
    private $abreviaturaSalida;
    private $abreviaturaLlegada;
    private $costo;
    private $generaIVA;

    public function getSitioSalida() {
        return $this->sitioSalida;
    }

    public function setSitioSalida($sitioSalida) {
        $this->sitioSalida = strtoupper($sitioSalida);
    }

    public function getSitioLlegada() {
        return $this->sitioLlegada;
    }

    public function setSitioLlegada($sitioLlegada) {
        $this->sitioLlegada = strtoupper($sitioLlegada);
    }

    public function getTiempo() {
        return $this->tiempo;
    }

    public function setTiempo($tiempo) {
        if (is_numeric($tiempo)) {
            $this->tiempo = $tiempo;
        }
    }

    public function getAbreviaturaSalida() {
        return $this->abreviaturaSalida;
    }

    public function setAbreviaturaSalida($abreviaturaSalida) {
        $this->abreviaturaSalida = strtoupper($abreviaturaSalida);
    }

    public function getAbreviaturaLlegada() {
        return $this->abreviaturaLlegada;
    }

    public function setAbreviaturaLlegada($abreviaturaLlegada) {
        $this->abreviaturaLlegada = strtoupper($abreviaturaLlegada);
    }

    public function getCosto() {
        return $this->costo;
    }

    public function setCosto($costo) {
        if(is_numeric($costo))
        $this->costo = $costo;
    }

    public function getGeneraIVA() {
        return $this->generaIVA;
    }

    public function getGeneraIVAString() {
        if ($this->generaIVA == 1)
        return "SI";
        if ($this->generaIVA == 0)
        return "NO";
    }

    public function setGeneraIVA($generaIVA) {
        if (is_numeric($generaIVA)) {
            $this->generaIVA = $generaIVA;
        }
    }
}
?>
