<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
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
                  VALUES('" . mysql_real_escape_string($ruta->getSitioSalida()) . "',
                         '" . mysql_real_escape_string($ruta->getSitioLlegada()) . "',
                          " . $ruta->getTiempo() . ",
                         '" . mysql_real_escape_string($ruta->getAbreviaturaSalida()) . "',
                         '" . mysql_real_escape_string($ruta->getAbreviaturaLlegada()) . "',
                          " . $ruta->getGeneraIVA() . ")";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function editarRuta($ruta){
        $resultado = false;
        $query = "UPDATE RUTA r
                  SET r.sitioSalida = '" . mysql_real_escape_string($ruta->getSitioSalida()) . "',".
                     "r.sitioLlegada = '" . mysql_real_escape_string($ruta->getSitioLlegada()) . "',".
                     "r.tiempo = " . $ruta->getTiempo() . ",".
                     "r.abreviaturaSalida = '" . mysql_real_escape_string($ruta->getAbreviaturaSalida()) . "',".
                     "r.abreviaturaLlegada = '" . mysql_real_escape_string($ruta->getAbreviaturaLlegada()) . "',".
                     "r.generaIVA = " . $ruta->getGeneraIVA() . " ".
                  "WHERE r.id = " . $ruta->getId() ;
        echo $query;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

}
?>
