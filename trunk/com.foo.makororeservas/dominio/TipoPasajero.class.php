<?php

/**
 * Description of TipoPasajeroclass
 * Clase para manejar los tipos de pasajeros
 * @author Diana Uribe
 */
class TipoPasajeroclass {
    private $id;
    private $porcentajeDescuento;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
            $this->id = $id;        
    }

    public function getPorcentajeDescuento() {
        return $this->porcentajeDescuento;
    }

    public function setPorcentajeDescuento($porcentajeDescuento) {
        if(is_numeric($porcentajeDescuento)){
            $this->porcentajeDescuento = $porcentajeDescuento;
        }
    }


}
?>
