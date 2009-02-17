<?php

/**
 * Description of TipoCargoclass
 * Clase para manejar los tipos de cargo diponibles para los tripulantes
 * @author jonathan
 */
class TipoCargoclass {

    private $id;

    private $cargo;

    private $descripcion;

    function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        if (is_numeric($id)) {
            $this->id = $id;
        }
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function setCargo($cargo) {
        $this->cargo = strtoupper($cargo);
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = strtoupper($descripcion);
    }

}
?>
