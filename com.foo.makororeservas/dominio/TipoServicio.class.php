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
    private $habilitado;

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

    public function getHabilitado() {
        return $this->habilitado;
    }

    public function getHabilitadoString() {
        if ($this->habilitado == 1) {
            return "SI";
        }
        else if ($this->habilitado == 0) {
            return "NO";
        }
    }

    public function setHabilitado($habilitado) {
        if (is_numeric($habilitado)) {
            $this->habilitado = $habilitado;
        }
    }

    public function setHabilitadoString ($habilitado) {
        if ($habilitado == 1) {
            $this->habilitado = "SI";
        }
        else if ($habilitado == 0) {
            $this->habilitado = "NO";
        }
    }
}
?>
