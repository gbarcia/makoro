<?php
/**
 * Description of controladorRutaBDclass
 * Clase para el manejo de las Ruta en la base de datos
 * @author maya
 */
class controladorRutaBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar una nueva ruta
     * @param <RUTA> $ruta
     * @return <boolean>
     */
    function agregarRuta($ruta){
        $resultado = false;
        $query = "INSERT INTO RUTA(sitioSalida, sitioLlegada, tiempo,
                                   abreviaturaSalida, abreviaturaLlegada, generaIVA)
                  VALUES('" . $ruta->getSitioSalida() . "',
                         '" . $ruta->getSitioLlegada() . "',
                          " . $ruta->getTiempo() . ",
                         '" . $ruta->getAbreviaturaSalida() . "',
                         '" . $ruta->getAbreviaturaLlegada() . "',
                          " . $ruta->getGeneraIVA() . ")";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function editarRuta($ruta){
        $resultado = false;
    }

}
?>
