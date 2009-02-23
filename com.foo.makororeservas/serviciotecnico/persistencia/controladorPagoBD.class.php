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
                                        p.nombreBanco = ".$pago->getNombreBanco().",
                                        p.numeroTransaccion = ".$pago->getNumeroTransaccion().",
                                        p.MONEDA_id = '".$pago->getMonedaId()."'

                  WHERE p.id = '".$pago->getId()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
