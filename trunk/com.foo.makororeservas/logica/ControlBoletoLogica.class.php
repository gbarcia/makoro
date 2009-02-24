<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorBoletoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';

/**
 * Description of ControlBoletoLogicaclass
 * Clase para el manejo de la logica de los boletos
 * @author Diana Uribe
 */
class ControlBoletoLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorBoletoBDclass();
    }

/**
 * Metodo para agregar un nuevo boleto
 * @param <Integer> $pagoId
 * @param <Integer> $pasajeroId
 * @return <boolean> resultado de la operacion
 */
    function nuevoBoleto($pagoId, $pasajeroId) {
        $boleto = new Boletoclass();
        $boleto->setPagoId($pagoId);
        $boleto->setPasajeroId($pasajeroId);
        $resultado = $this->controlBD->agregarBoleto($boleto);
        return ($resultado);
    }

/**
 * Metodo para consultar todos los boletos de la base de datos
 * @return <Coleccion> coleccion de boletos de los pasajeros
 */
    function buscarBoletos() {
        $recurso = false;
        $recurso = $this->controlBD->consultarBoletos();
        return $recurso;
    }

/**
 * Metodo para consultar un boleto especifico de una reserva
 * @param <String> $solicitud
 * @return <recurso> boleto de una reserva en especifico
 */
    function buscarBoletoEspecifico($solicitud) {
        $recurso = false;
        $recurso = $this->controlBD->consultarBoletoEspecifico($solicitud);
        return $recurso;
    }
}
?>
