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
 * @param <PAGO> $pago Coleccion con los datos del pago
 * @return <boolean> resultado de la operacion true o false
 */
    function agregarPago($pago) {
        $resultado = false;
        $query = "INSERT INTO PAGO (tipo,monto,nombreBanco,numeroTransaccion,
                                    MONEDA_id) VALUES ('".$pago->getTipo()."',
                                                       ".$pago->getMonto().",
                                                       '".$pago->getNombreBanco()."',
                                                       ".$pago->getNumeroTransaccion().",
                                                       ".$pago->getMonedaId().")";
        echo $query;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para editar algun pago en la base de datos
 * @param <PAGO> $pago Coleccion con los datos del pago
 * @return <boolean> resultado de la operacion true o false
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
 * @param <Integer> $cedula Cedula del cliente particular
 * @param <Date> $fecha Fecha de la reserva a anular
 * @return <boolean> resultado de la operacion
 */
    function cancelarPagoRealizadoClienteParticular($cedula, $fecha) {
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
 * @param <String> $rif RIF de la agencia
 * @param <Date> $fecha Fecha de la reserva
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

/**
 * Metodo para consultar la cantidad de ninos y adultos en una reservacion segun el localizador
 * @param <String> $solicitud Localizador de la reserva
 * @param <String> $tipoPasajero Clasificacion del pasajero puede ser: ADL, CHD o INF
 * @param <String> $tipoVuelo Descripcion del tipo de vuelo puede ser: IDA o VUELTA
 * @return <boolean> resultado de la operacion true o false
 */
    function cantidadAdultosNinosPorSolicitud($solicitud, $tipoPasajero, $tipoVuelo){
        $resultado = false;
        $query = "SELECT COUNT(TIPO_PASAJERO_id) cantidad, t.porcentajeDescuento descuento
                  FROM RESERVA r, PASAJERO p, TIPO_PASAJERO t, VUELO_RESERVA vr
                  WHERE r.solicitud = '" . $solicitud . "'
                  AND r.PASAJERO_id = p.id
                  AND p.TIPO_PASAJERO_id = '".$tipoPasajero."'
                  AND p.TIPO_PASAJERO_id = t.id
                  AND vr.RESERVA_id = r.id
                  AND vr.tipo = '".$tipoVuelo."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
