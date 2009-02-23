<?php

/**
 * Description of Monedaclass
 * Clase para manejar la informacion del tipo de moneda
 * @author Diana Uribe
 */
class Monedaclass {
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
