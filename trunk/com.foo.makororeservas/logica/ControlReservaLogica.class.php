<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Reserva.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/Conexion.class.php';
/**
 * Description of ControlReservaLogicaclass
 *
 * @author maya
 */
class ControlReservaLogicaclass {
    private $controlBD;
    private $controlConexion;

    function __construct() {
        $this->controlBD = new controladorReservaBDclass();
        $this->controlConexion = new Conexionclass();
    }

    /**
     * Metodo para agregar una nueva reserva en el sistema
     * @param <type> $fecha La fecha de la reserva
     * @param <type> $estado El estado de la reserva
     * @param <type> $solicitud El numero de solicitud de la reserva
     * @param <type> $tipoServicioId El tipo de servicio
     * @param <type> $sucursalId La sucursal donde ser realizo la reserva
     * @param <type> $encargadoCedula El encargado que realizo la reserva
     * @param <type> $clienteParticularCedula El cliente particular de la reserva
     * @param <type> $clienteAgenciaRif El cliente agencia de la reserva
     * @param <type> $PAGO_id El pago de la reserva
     * @param <type> $pasajeroId El pasajero de la reserva
     * @param <type> $posadaId La posada en la que se hospedara
     * @return <type> El resultado de la operacion
     */
    function nuevaReserva($fecha, $estado, $solicitud, $tipoServicioId, $sucursalId,
        $encargadoCedula, $clienteParticularCedula, $clienteAgenciaRif,
        $pagoId, $pasajeroId, $posadaId) {
        $reserva = new Reservaclass();
        $reserva->setFecha($fecha);
        $reserva->setEstado($estado);
        $reserva->setSolicitud($solicitud);
        $reserva->setTipoServicioId($tipoServicioId);
        $reserva->setSucursalId($sucursalId);
        $reserva->setEncargadoCedula($encargadoCedula);
        $reserva->setClienteParticularCedula($clienteParticularCedula);
        $reserva->setClienteAgenciaRif($clienteAgenciaRif);
        $reserva->setPagoId($pagoId);
        $reserva->setPasajeroId($pasajeroId);
        $reserva->setPosadaId($posadaId);
        $resultado = $this->controlBD->agregarReserva($reserva);
        return ($resultado);
    }

    function crearReserva($cantidadPasajeros,$fecha, $tipoServicioId, $sucursalId,
                          $encargadoCedula, $clienteParticularCedula, $clienteAgenciaRif,
                          $posadaId){
        $estado = 'PP';
        $pagoId = 'null';
        $pasajeroId = 'null';
        $solicitud = $this->generarSolicitud();
        do{
            $resultado = $this->nuevaReserva($fecha, $estado, $solicitud, $tipoServicioId, 
                                             $sucursalId, $encargadoCedula, $clienteParticularCedula,
                                             $clienteAgenciaRif, $pagoId, $pasajeroId, $posadaId);
                                         echo $resultado;
                                         echo '<p></p>';
            $cantidadPasajeros = $cantidadPasajeros - 1;
        }while ($cantidadPasajeros != 0);
        return $resultado;
    }

    function generarSolicitud(){
        do{
            $variableNumerica    = rand(000000,999999);
            $arreglo             = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            $variableNumericaDos = rand(0,25);
            $variableNumericaTres = rand(0,25);
            $codigo              = $arreglo[$variableNumericaDos].$arreglo[$variableNumericaTres].$variableNumerica;
            $acceso              = $this->controlConexion->conectarBaseDatos();
            $query               = "SELECT * FROM RESERVA R
                                        WHERE R.solicitud = '".$codigo."' ";
            $operacion           = mysql_query ($query,$acceso);
            $row                 = mysql_num_rows($operacion);
        } while ($row != 0);
        return $codigo;
    }
}
?>