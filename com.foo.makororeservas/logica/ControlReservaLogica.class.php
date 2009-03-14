<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlPasajeroLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Reserva.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloReserva.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/Conexion.class.php';
/**
 * Description of ControlReservaLogicaclass
 *
 * @author maya
 */
class ControlReservaLogicaclass {
    private $controlBD;
    private $controlVueloReservaBD;
    public $controlConexion;
    private $controlVuelo;
    private $controlPasajero;

    function __construct() {
        $this->controlBD = new controladorReservaBDclass();
        $this->controlVueloReservaBD = new controladorVueloReservaBDclass;
        $this->controlConexion = new Conexionclass();
        $this->controlVuelo = new ControlVueloLogicaclass();
        $this->controlPasajero = new ControlPasajeroLogicaclass();
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

    /**
     * Metodo para crear una nueva reserva en el sistema
     * @param <type> $cantidadPasajeros La cantidad de pasajeros que desean realizar la reserva
     * @param <type> $fecha La fecha de reserva
     * @param <type> $tipoServicioId El id del tipo de servicio de la reserva
     * @param <type> $sucursalId El id de la sucursal en donde se realizo la reserva
     * @param <type> $encargadoCedula El encargado que realizo la reserva
     * @param <type> $clienteParticularCedula El cliente particular que realizo la reserva
     * @param <type> $clienteAgenciaRif El cliente agencia que realizo la reserva
     * @param <type> $posadaId La posada en la que se hospedara el pasajero
     * @return <type> El resultado de la operacion
     */
    function crearReserva($idVuelo,$tipoViaje,$cantAdultoNino,$cantidadInfantes,$fecha, $tipoServicioId, $sucursalId,$encargadoCedula, $clienteParticularCedula, $clienteAgenciaRif,
        $posadaId){
        $resultado = false;
        $disponibleAdultoNino = $this->asientosDisponiblesAdultoNino($idVuelo, $cantAdultoNino);
        $disponibleInfante = $this->asientosDisponiblesInfante($idVuelo, $cantidadInfantes);
        $cantidadPasajeros = $cantAdultoNino+$cantidadInfantes;

        echo ' Adulto: '.$disponibleAdultoNino.' Infante: '.$disponibleInfante;

        if($disponibleAdultoNino && $disponibleInfante){
            $estado = 'PP';
            $pagoId = 'null';
            $pasajeroId = 'null';
            $solicitud = $this->generarSolicitud();
            do{
                $resultado = $this->nuevaReserva($fecha, $estado, $solicitud, $tipoServicioId, $sucursalId, $encargadoCedula, $clienteParticularCedula,
                    $clienteAgenciaRif, $pagoId, $pasajeroId, $posadaId);
                $cantidadPasajeros = $cantidadPasajeros - 1;
            }while ($cantidadPasajeros != 0);
            $recurso = $this->controlBD->buscarIdReserva($solicitud);
            while ($row = mysql_fetch_array($recurso)) {
                $vueloReserva = new VueloReservaclass();
                $vueloReserva->setVueloid($idVuelo);
                $vueloReserva->setReservaid($row[idReserva]);
                $vueloReserva->setTipo($tipoViaje);
                $this->controlVueloReservaBD->agregarVueloReserva($vueloReserva);
            }
            $infantesVuelo = $this->controlVuelo->consultarCantidadInfantesVuelo($idVuelo);
            $row = mysql_fetch_array($infantesVuelo);
            $cantidadInfantesVuelo = $row[cantidadInfantes];
            $cantidadNueva = $cantidadInfantesVuelo+$cantidadInfantes;
            $cambio = $this->controlVuelo->actualizarCantidadInfantesVuelo($idVuelo, $cantidadNueva);
            return $resultado;
        }else{
            return $disponible;
        }
        return $resultado;
    }

    function actualizarPasajeroReserva($nombre,$apellido,$sexo,$cedula,$pasaporte,$nacionalidad,$tipoPasajeroId,$idReserva){
        $controlPasajero = new ControlPasajeroLogicaclass();
        // verificar si ya existe el pasajero
        $existePasajero = $this->existePasajero($cedula, $pasaporte);
        echo $existePasajero;
        if(!(is_null($existePasajero))){
            $split = explode(', ', $existePasajero);
            $idPasajero = $split[0];
        }
        if(is_null($existePasajero)){
            $idPasajero = $controlPasajero->nuevoPasajero($nombre,$apellido,$sexo,$cedula,
                                                          $pasaporte,$nacionalidad,$tipoPasajeroId);
        }
        $resultado = $this->actualizarIdReserva($idPasajero, $idReserva);
        return $resultado;
    }

    function actualizarIdReserva($idPasajero,$idReserva){
        $recurso = $this->controlBD->actualizarIdReserva($idPasajero, $idReserva);
        return $recurso;
    }


    /**
     * Metodo para crear el codigo de solicitud aleatorio
     * @return <type> Codigo solicitud
     */
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

    /**
     * Metodo para comprobar la existencia de un pasajero
     * @param <type> $cedula La cedula del pasajero
     * @param <type> $pasaporte El pasaporte del pasajero
     * @return <type> El resultado de la operacion
     */
    function existePasajero($cedula, $pasaporte){
        $recurso = $this->controlBD->existePasajero($cedula, $pasaporte);
        $row = mysql_fetch_array($recurso);
        $disponible = $row[pasajero];
        return $disponible;
    }

    /**
     * Metodo para comprobar la existencia de un cliente agencia
     * @param <type> $rif El rif del cliente agencia
     * @return <type> El resultado de la operacion
     */
    function existeClienteAgencia($rif){
        $recurso = $this->controlBD->existeClienteAgencia($rif);
        $row = mysql_fetch_array($recurso);
        $disponible = $row[existeAgencia];
        return $disponible;
    }

    /**
     * Metodo para comprobar la existencia de un cliente particular
     * @param <type> $cedula La cedula del cliente particular
     * @return <type> El resultado de la operacion
     */
    function existeClienteParticular($cedula){
        $recurso = $this->controlBD->existeClienteParticular($cedula);
        $row = mysql_fetch_array($recurso);
        $disponible = $row[existeParticular];
        return $disponible;
    }

    /**
     * Metodo para consultar la disponibilidad de asientos a un vuelo determinado
     * @param <type> $idVuelo El id del vuelo a consultar
     * @param <type> $cantAdultoNino La cantidad de pasajeros adultos o ninos
     * @return <type> Si la cantidad de asientos esta disponible para este vuelo
     */
    function asientosDisponiblesAdultoNino($idVuelo,$cantAdultoNino){
        $recurso = $this->controlBD->asientosDisponiblesAdultoNino($idVuelo, $cantAdultoNino);
        $row = mysql_fetch_array($recurso);
        $disponible = $row[disponibleAdultoNino];
        return $disponible;
    }

    /**
     * Metodo para consultar la disponibilidad de asientos a un vuelo determinado
     * @param <type> $idVuelo El id del vuelo a consultar
     * @param <type> $cantInfantes La cantidad de pasajeros infantes
     * @return <type> Si la cantidad de asientos esta disponible para este vuelo
     */
    function asientosDisponiblesInfante($idVuelo,$cantInfantes){
        $recurso = $this->controlBD->asientosDisponiblesInfante($idVuelo, $cantInfantes);
        $row = mysql_fetch_array($recurso);
        $disponible = $row[disponibleInfante];
        return $disponible;
    }
}
?>