<?php
/**
 * Description of EmitirBoletoclass
 * Clase para guardar información adicional acerca de los boletos como
 * la cantidad de adultos, niños e infantes que van a ir en el viaje
 * @author Diana Uribe
 */
class DetallesEmitirBoletoclass {
    private $cantidadAdultos;
    private $cantidadNinos;
    private $cantidadInfantes;

    function __construct($cantidadAdultos, $cantidadNinos, $cantidadInfantes) {
        $this->cantidadAdultos = $cantidadAdultos;
        $this->cantidadNinos = $cantidadNinos;
        $this->cantidadInfantes = $cantidadInfantes;
    }

    public function getCantidadAdultos() {
        return $this->cantidadAdultos;
    }

    public function setCantidadAdultos($cantidadAdultos) {
        $this->cantidadAdultos = $cantidadAdultos;
    }

    public function getCantidadNinos() {
        return $this->cantidadNinos;
    }

    public function setCantidadNinos($cantidadNinos) {
        $this->cantidadNinos = $cantidadNinos;
    }

    public function getCantidadInfantes() {
        return $this->cantidadInfantes;
    }

    public function setCantidadInfantes($cantidadInfantes) {
        $this->cantidadInfantes = $cantidadInfantes;
    }
        
}
?>