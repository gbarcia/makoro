<?php

/**
 * Description of TipoServicioclass
 * Clase para manejar el tipo servicio
 * @author Diana Uribe
 */
class TipoServicioclass {
    private $id;
    private $abreviatura;
    private $nombre;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function getAbreviatura() {
        return $this->abreviatura;
    }

    public function setAbreviatura($abreviatura) {
        $this->abreviatura = strtoupper($abreviatura);
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = strtoupper($nombre);
    }


}
?>
