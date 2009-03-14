<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoPasajero.class.php';

/**
 * Description of controladorTipoPasajeroBDclass
 * Clase para el manejo de la base de datos de los tipo de pasajeros
 * @author Diana Uribe
 */
class controladorTipoPasajeroBDclass {
    private $transaccion;

    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para actualizar el porcentaje de descuento de los tipos de pasajeros
 * @param <TIPO_PASAJERO> $tipoPasajero Coleccion de datos con el tipo pasajero
 * @return <boolean> resultado de la operacion
 */
    function editarTipoPasajero($tipoPasajero){
        $resultado = false;
        $query = "UPDATE TIPO_PASAJERO tp SET tp.porcentajeDescuento = ".$tipoPasajero->getPorcentajeDescuento()."
                                          WHERE tp.id = '".$tipoPasajero->getId()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para consultar todos los tipos de pasajeros que existen
 * en la base de datos
 * @return <Coleccion> Objecto tipo pasajero
 */
    function consultarTipoPasajero(){
        $resultado = false;
        $query = "SELECT * FROM TIPO_PASAJERO";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
