<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorBoletoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/EmitirBoleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';

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
 * Metodo para consultar el pago de un boleto especifico de una reserva
 * @param <String> $solicitud
 * @return <recurso> boleto de una reserva en especifico
 */
    function busquedaBoletoEspecifico($solicitud) {
        $resultado = new ArrayObject();
        $resultado = $this->controlBD->consultarBoletoEspecifico($solicitud);
        return $resultado;
    }

    function emitirBoleto($solicitud) {
        $recurso = $this->busquedaBoletoEspecifico($solicitud);
        $coleccionResultado = new ArrayObject();
            $rowRecurso = mysql_fetch_array($recurso);

            $idPago = $rowRecurso[idPago];
            $pasajeroInfo = $this->controlBD->consultarPasajeros($pagoId);
            
        foreach ($pasajeroInfo as $variable) {

                $pasajero = new Pasajeroclass();
                $pasajero->setId($variable->getId());
                $pasajero->setNombre($variable->getNombre());
                $pasajero->setApellido($variable->getApellido());
                $pasajero->setCedula($variable->getCedula());
                $pasajero->setPasaporte($variable->getPasaporte());
                $pasajero->setNacionalidad($variable->getNacionalidad());
                $pasajero->setTipoPasajeroId($variable->getTipoPasajeroId());
                $Objeto = new EmitirBoletoclass($agente, $solicitud, $fechaIda, $fechaVuelta, $lugarSalida, $lugarLlegada, $coleccionPasajero, $servicio);

                $coleccionResultado ->append($Objeto);


        }
        return $coleccionResultado;
    }
}
?>
