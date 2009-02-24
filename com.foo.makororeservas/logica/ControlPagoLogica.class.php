<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPagoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';
/**
 * Description of ControlPagoLogicaclass
 * Clase para manejar la logica de la gestion de la base de datos
 * @author Diana Uribe
 */
class ControlPagoLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorPagoBDclass();
    }

/**
 * Metodo para agregar un nuevo pago
 * @param <String> $tipo
 * @param <double> $monto
 * @param <String> $nombreBanco
 * @param <Integer> $numeroTransaccion
 * @param <Integer> $monedaId
 * @return <boolean> resultado de la operacion 
 */
    function nuevoPago($tipo,$monto,$nombreBanco,$numeroTransaccion,$monedaId) {
        $pago = new Pagoclass();
        $pago->setTipo($tipo);
        $pago->setMonto($monto);
        $pago->setNombreBanco($nombreBanco);
        $pago->setNumeroTransaccion($numeroTransaccion);
        $pago->setMonedaId($monedaId);
        $resultado = $this->controlBD->agregarPago($pago);

        return ($resultado);
    }

/**
 * Metodo para actulizar los datos del pago
 * @param <Integer> $id
 * @param <String> $tipo
 * @param <double> $monto
 * @param <String> $nombreBanco
 * @param <Integer> $numeroTransaccion
 * @param <Integer> $monedaId
 * @return <boolean> resultado de la operacion
 */
    function actualizarPago($id,$tipo,$monto,$nombreBanco,$numeroTransaccion,$monedaId) {
        $pago = new Pagoclass();
        $pago->setId($id);
        $pago->setTipo($tipo);
        $pago->setMonto($monto);
        $pago->setNombreBanco($nombreBanco);
        $pago->setNumeroTransaccion($numeroTransaccion);
        $pago->setMonedaId($monedaId);
        $resultado = $this->controlBD->editarPago($pago);
        return $resultado;
    }

/**
 * Metodo para consultar todos los pagos
 * @return <recurso>
 */
    function buscarPagos() {
        $recurso = false;
        $recurso = $this->controlBD->consultarPagos();
        return $recurso;
    }

    function buscarCancelacionPagoClienteParticular($cedula, $fechaini, $fechafin) {
        $reserva->setEstado("CA");
        $this->controlBD->editarPago($reserva);
    }
}
?>
