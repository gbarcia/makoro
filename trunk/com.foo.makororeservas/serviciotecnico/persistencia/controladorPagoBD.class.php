<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';

/**
 * Description of controladorPagoBDclass
 * Clase para el manejo de los pagos en la base de datos
 * @author Diana Uribe
 */
class controladorPagoBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agregar un nuevo pago en la besa de datos
 * @param <PAGO> $pago
 * @return <boolean> resultado de la operacion
 */
    function agregarPago($pago) {
        $resultado = false;
        $query = "INSERT INTO PAGO (tipo,monto,nombreBanco,numeroTransaccion,
                                    MONEDA_id) VALUES ('".$pago->getTipo()."',
                                                       ".$pago->getMonto().",
                                                       '".$pago->getNombreBanco()."',
                                                       ".$pago->getNumeroTransaccion().",
                                                       '".$pago->getMonedaId()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para editar algun pago en la base de datos
 * @param <PAGO> $pago
 * @return <boolean> resultado de la operacion
 */
    function editarPago($pago) {
        $resultado = false;
        $query = "UPDATE PAGO p SET p.tipo = '".$pago->getTipo()."',
                                        p.monto = ".$pago->getMonto().",
                                        p.nombreBanco = '".$pago->getNombreBanco()."',
                                        p.numeroTransaccion = '".$pago->getNumeroTransaccion()."',
                                        p.MONEDA_id = '".$pago->getMonedaId()."'

                  WHERE p.id = '".$pago->getId()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar los pagos de la base de datos
 * @return <recurso> Coleccion de pago
 */
    function consultarPagos() {
        $resultado = false;
        $query = "SELECT * FROM PAGO";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para eliminar el pago de un cliente particular en la base de datos
 * @param <Integer> $cedula
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @return <boolean> resultado de la operacion
 */
    function cancelarPagoRealizadoClienteParticular($cedula, $fechaini, $fechafin) {
        $resultado = false;
        $query = "DELETE PAGO p
                  FROM RESERVA re, CLIENTE_PARTICULAR cp, PAGO p
                  WHERE cp.cedula = re.CLIENTE_PARTICULAR_cedula
                  AND re.PAGO_id = p.id
                  AND re.CLIENTE_PARTICULAR_cedula = " . $cedula . "
                  AND re.estado = 'CA'
                  AND re.fecha = '" . $fecha . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para eliminar el pago de un cliente agencia en la base de datos
 * @param <String> $rif
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @return <boolean> resultado de la operacion
 */
    function cancelarPagoRealizadoClienteAgencia($rif, $fecha) {
        $resultado = false;
        $query = "DELETE PAGO p
                  FROM RESERVA re, CLIENTE_AGENCIA ca, PAGO p
                  WHERE ca.rif = re.CLIENTE_AGENCIA_rif
                  AND re.PAGO_id = p.id
                  AND re.CLIENTE_AGENCIA_rif = '" . $rif . "'
                  AND re.estado = 'CA'
                  AND re.fecha = '" . $fecha . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
