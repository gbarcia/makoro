<?php

/**
 * Description of TipoServicioclass
 * Clase para manejar el tipo servicio
 * @author Diana Uribe
 */
class TipoServicioclass {
    private $id;
    private $tipo;

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
}
?>
