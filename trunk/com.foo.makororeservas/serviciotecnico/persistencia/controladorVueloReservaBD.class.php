<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloReserva.class.php';
/**
 * Description of controladorVueloReservaBDclass
 * Clase para el manejo de la base de datos vuelo_reserva 
 * @author maya
 */
class controladorVueloReservaBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agregar asignar un vuelo a una reserva
 * @param <type> $vueloReserva El vuelo y la reserva a agregar
 * @return <type> El resultado de la operacion 
 */
    function agregarVueloReserva($vueloReserva){
        $resultado = false;
        $query = "INSERT INTO VUELO_RESERVA (VUELO_id,RESERVA_id,tipo)
                  VALUES (". $vueloReserva->getVueloId() .",
                          ". $vueloReserva->getReservaId() .",
                          '". $vueloReserva->getTipo()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
