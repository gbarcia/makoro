<?php
/**
 * Description of Rutaclass
 *
 * @author Diana Uribe
 */
class Rutaclass {
    private $id;
    private $sitioSalida;
    private $sitioLlegada;
    private $tiempo;
    private $abreviaturaSalida;
    private $abreviaturaLlegada;
    private $generarIVA;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_integer($id)){
            $this->id = $id;
        }
    }

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
        if (is_float($tiempo)) {
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

    public function getGenerarIVA() {
        return $this->generarIVA;
    }

    public function setGenerarIVA($generarIVA) {
        $this->generarIVA = $generarIVA;
    }

}
?>
