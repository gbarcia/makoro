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
     * @param <RUTA> $ruta la ruta a agregar
     * @return <boolean> resultado de la operacion
     */
    function agregarRuta($ruta){
        $resultado = false;
        $query = "INSERT INTO RUTA(sitioSalida, sitioLlegada, tiempo,
                                   abreviaturaSalida, abreviaturaLlegada, costo,generaIVA)
                  VALUES('" . $ruta->getSitioSalida() . "',
                         '" . $ruta->getSitioLlegada() . "',
                          " . $ruta->getTiempo() . ",
                         '" . $ruta->getAbreviaturaSalida() . "',
                         '" . $ruta->getAbreviaturaLlegada() . "',
                         '" . $ruta->getCosto() . "',
                          " . $ruta->getGeneraIVA() . ")";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar una ruta dado su id
     * @param <RUTA> $ruta la ruta a editar
     * @return <boolean> resultado de la operacion
     */
    function editarRuta($ruta){
        $resultado = false;
        $query = "UPDATE RUTA r
                  SET r.tiempo = " . $ruta->getTiempo() . ",".
                     "r.abreviaturaSalida = '" . mysql_real_escape_string($ruta->getAbreviaturaSalida()) . "',".
                     "r.abreviaturaLlegada = '" . mysql_real_escape_string($ruta->getAbreviaturaLlegada()) . "',".
                     "r.costo = '" . mysql_real_escape_string($ruta->getCosto()) . "',".
                     "r.generaIVA = " . $ruta->getGeneraIVA() . " ".
                  "WHERE r.sitioSalida = '" . mysql_real_escape_string($ruta->getSitioSalida()) . "' AND ".
                        "r.sitioLlegada = '" . mysql_real_escape_string($ruta->getSitioLlegada()) . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar todas las rutas
     * @return <recurso> todas las rutas de la base de datos
     */
    function consultarRutas(){
        $query = "SELECT * FROM RUTA r";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar una ruta por su id
     * @param <int> $id el identificador de la ruta
     * @return <RUTA> la ruta del identificador seleccionado
     */
    function consultarRutaID($sitioSalida, $sitioLlegada){
        $query = "SELECT * FROM RUTA r
                 WHERE r.sitioSalida = '" . mysql_real_escape_string($sitioSalida) . "' AND ".
                      "r.sitioLlegada = '" . mysql_real_escape_string($sitioLlegada) . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
