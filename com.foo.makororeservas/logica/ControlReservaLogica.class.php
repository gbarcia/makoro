<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPagoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlPagoLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlPasajeroLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Reserva.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloReserva.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/Conexion.class.php';
/**
 * Description of ControlReservaLogicaclass
 * Clase para el manejo de las reservas del sistema
 * @author maya
 */
class ControlReservaLogicaclass {
    private $controlBD;
    private $controlVueloReservaBD;
    private $controlConexion;
    private $controlVuelo;
    private $controlPasajero;
    private $controlPago;

    function __construct() {
        $this->controlBD = new controladorReservaBDclass();
        $this->controlVueloReservaBD = new controladorVueloReservaBDclass;
        $this->controlConexion = new Conexionclass();
        $this->controlVuelo = new ControlVueloLogicaclass();
        $this->controlPago = new ControlPagoLogicaclass();
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
        $encargadoCedula, $clienteParticularCedula, $clienteAgenciaRif,$pagoId,
        $pasajeroId, $posadaId) {
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
    function crearReserva($tipoViaje,$idVuelo,$cantAdultoNino,$cantidadInfantes,$fecha, $tipoServicioId, $sucursalId,$encargadoCedula, $clienteParticularCedula, $clienteAgenciaRif,
        $posadaId,$solicitud,$estado){
        $resultado = false;
        $disponibleAdultoNino = $this->asientosDisponiblesAdultoNino($idVuelo, $cantAdultoNino);
        $disponibleInfante = $this->asientosDisponiblesInfante($idVuelo, $cantidadInfantes);
        $arrayInf = new ArrayObject();
        $arrayAdl = new ArrayObject();
        $solicitudGenerada = false;
        $cantAdlChlOriginal = $cantAdultoNino;
        $cantInfOriginal = $cantidadInfantes;
        $result = false;
        if($disponibleAdultoNino && $disponibleInfante){
            $pagoId = 'null';
            $pasajeroId = 'null';
            if($solicitud == ''){
                $solicitud = $this->generarSolicitud();
                $solicitudGenerada = true;
            }
            if($cantAdultoNino>0){
                do{
                    $resultado = $this->nuevaReserva($fecha, $estado, $solicitud, $tipoServicioId, $sucursalId, $encargadoCedula, $clienteParticularCedula,
                        $clienteAgenciaRif, $pagoId, $pasajeroId, $posadaId);
                    $arrayAdl->append($resultado);
                    $cantAdultoNino = $cantAdultoNino - 1;
                }while ($cantAdultoNino > 0);
            }
            if($cantidadInfantes>0){
                $contador = $cantidadInfantes;
                do{
                    $idPasajeroInf = $this->controlPasajero->nuevoPasajero('INFANTE', '', 'M', NULL, NULL, NULL, 'INF');
                    $resultadoInf = $this->nuevaReserva($fecha, $estado, $solicitud, $tipoServicioId, $sucursalId, $encargadoCedula, $clienteParticularCedula,
                        $clienteAgenciaRif, 1, $idPasajeroInf, $posadaId);
                    $arrayInf->append($resultadoInf);
                    $contador = $contador - 1;
                }while ($contador >0);
            }
            if($tipoViaje == 'ida' && $solicitudGenerada){
                $recurso = $this->controlBD->buscarIdReserva($solicitud,$idVuelo);
                while ($row = mysql_fetch_array($recurso)) {
                    $vueloReserva = new VueloReservaclass();
                    $vueloReserva->setVueloid($idVuelo);
                    $vueloReserva->setReservaid($row[idReserva]);
                    $vueloReserva->setTipo($tipoViaje);
                    $this->controlVueloReservaBD->agregarVueloReserva($vueloReserva);
                }
            }else if($tipoViaje == 'ida' && !$solicitudGenerada){
                foreach ($arrayAdl as $variable) {
                    $vueloReserva = new VueloReservaclass();
                    $vueloReserva->setVueloid($idVuelo);
                    $vueloReserva->setReservaid($variable);
                    $vueloReserva->setTipo($tipoViaje);
                    $this->controlVueloReservaBD->agregarVueloReserva($vueloReserva);
                }
                foreach ($arrayInf as $variable) {
                    $vueloReserva = new VueloReservaclass();
                    $vueloReserva->setVueloid($idVuelo);
                    $vueloReserva->setReservaid($variable);
                    $vueloReserva->setTipo($tipoViaje);
                    $this->controlVueloReservaBD->agregarVueloReserva($vueloReserva);
                }
            }else if($tipoViaje == 'vuelta'){
                $result = $this->verificarCantidadPasajeros($solicitud, $cantAdlChlOriginal, $cantInfOriginal);
                if($result == true){
                    foreach ($arrayAdl as $variable) {
                        $vueloReserva = new VueloReservaclass();
                        $vueloReserva->setVueloid($idVuelo);
                        $vueloReserva->setReservaid($variable);
                        $vueloReserva->setTipo($tipoViaje);
                        $this->controlVueloReservaBD->agregarVueloReserva($vueloReserva);
                    }
                    foreach ($arrayInf as $variable) {
                        $vueloReserva = new VueloReservaclass();
                        $vueloReserva->setVueloid($idVuelo);
                        $vueloReserva->setReservaid($variable);
                        $vueloReserva->setTipo($tipoViaje);
                        $this->controlVueloReservaBD->agregarVueloReserva($vueloReserva);
                    }
                }else{
                    $this->rollBackReserva($arrayAdl, $arrayInf);
                }
            }
            if($tipoViaje == 'ida'){
                $infantesVuelo = $this->controlVuelo->consultarCantidadInfantesVuelo($idVuelo);
                $row = mysql_fetch_array($infantesVuelo);
                $cantidadInfantesVuelo = $row[cantidadInfantes];
                $cantidadNueva = $cantidadInfantesVuelo+$cantidadInfantes;
                $cambio = $this->controlVuelo->actualizarCantidadInfantesVuelo($idVuelo, $cantidadNueva);
            }else if(($tipoViaje == 'vuelta') && ($result == true)){
                $infantesVuelo = $this->controlVuelo->consultarCantidadInfantesVuelo($idVuelo);
                $row = mysql_fetch_array($infantesVuelo);
                $cantidadInfantesVuelo = $row[cantidadInfantes];
                $cantidadNueva = $cantidadInfantesVuelo+$cantidadInfantes;
                $cambio = $this->controlVuelo->actualizarCantidadInfantesVuelo($idVuelo, $cantidadNueva);
            }
        }else{
            return $disponible;
        }
        if ($resultado || $resultadoInf)
        return $solicitud;
        else
        return "";
    }

    function rollBackReserva($arrayAdl,$arrayInf){
        foreach ($arrayAdl as $variable) {
            $this->controlBD->eliminarReserva($variable);
        }
        foreach ($arrayInf as $inf) {
            $this->controlBD->eliminarReserva($inf);
        }
        return true;
    }

    /**
     * Metodo para actualizar un pasajero en una reserva determinada
     * @param <String> $nombre Nombre del pasajero
     * @param <String> $apellido Apellido del pasajero
     * @param <String> $sexo Sexo del pasajero
     * @param <Integer> $cedula Cedula del pasajero
     * @param <String> $pasaporte Pasaporte del pasajero
     * @param <String> $nacionalidad Nacionalidad del pasajero
     * @param <Integer> $tipoPasajeroId Clasificacion del pasajero
     * @param <Integer> $idReserva Identificador de la reserva
     * @return <recurso> resultado de la operacion
     */
    function actualizarPasajeroReserva($nombre,$apellido,$sexo,$cedula,$pasaporte,$nacionalidad,$tipoPasajeroId,$idReserva){
        $controlPasajero = new ControlPasajeroLogicaclass();
        $existePasajero = $this->existePasajero($cedula, $pasaporte);
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

    /**
     * Metodo para actualizar un pasajero de una reserva
     * @param <Integer> $idPasajero Identificador del pasajero
     * @param <Integer> $idReserva Identificador de la reserva
     * @return <recurso> resultado de la operacion
     */
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
     * Metodo para verificar la existencia de una solicitud
     * @param <type> $solicitud La solicitud a consultar
     * @return <type> Si existe devuelve la solicitud, de lo contrario devuelve 0
     */
    function existeSolicitud($solicitud){
        $recurso = $this->controlBD->existeSolicitud($solicitud);
        $row = mysql_fetch_array($recurso);
        $validacion = $row[validacion];
        return $validacion;
    }

    /**
     * Metodo para verificar la existencia de una reserva
     * @param <type> $idReserva El id de la reserva a consultar
     * @return <type> Si existe devuelve el id de la reserva, de lo contrario devuelve 0
     */
    function existeReserva($idReserva){
        $recurso = $this->controlBD->existeReserva($idReserva);
        $row = mysql_fetch_array($recurso);
        $validacion = $row[validacion];
        return $validacion;
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

    /**
     * Metodo para pagar una reserva, además se actualiza el estado a PA (pagado)
     * @param <Integer> $idReserva Identificador de la reserva
     * @param <String> $tipo Tipo de pago
     * @param <double> $monto Monto a pagar
     * @param <String> $nombreBanco Nombre del banco
     * @param <Integer> $numeroTransaccion Numero de la transaccion del pago
     * @param <Integer> $monedaId Identificador de la moneda
     * @return <boolean> resultado de la operacion
     */
    function pagarReserva($solicitud,$tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId){
        if($estadoReserva != 'CA'){
            $estado = "PA";
            $pagoId = $this->controlPago->nuevoPago($tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId);
            if($pagoId > 0){
                $estadoReserva = $this->estadoReserva($solicitud);
                $resultado = $this->controlBD->editarEstadoPagadoReserva($solicitud, $estado, $pagoId);
            }
        }
        return $resultado;
    }

    /**
     * Metodo para consultar el estado de varias reservas
     * @param <String> $solicitud Localizador de la reserva
     * @return <recurso> estado de la reserva
     */
    function estadoReserva($solicitud) {
        $recurso = $this->controlBD->consultarEstadoReserva($solicitud);
        $row = mysql_fetch_array($recurso);
        $estado = $row[estado];
        return $estado;
    }

    /**
     * Metodo para consultar el estado de una reserva
     * @param <Integer> $idReserva Identificador de la reserva
     * @return <recurso> Estado de la reserva
     */
    function estadoReservaPorPersona($idReserva) {
        $recurso = $this->controlBD->consultarEstadoReservaPorPersona($idReserva);
        $row = mysql_fetch_array($recurso);
        $estado = $row[estado];
        return $estado;
    }

    /**
     * Metodo para consultar los identificadores de la reserva segun la solicitud
     * @param <String> $solicitud Localizador de la reserva
     * @return <recurso> recurso con los identificadores de la reserva
     */
    function consultarIdsReservasPorSolicitud($solicitud) {
        $recurso = $this->controlBD->buscarLosIdRelacionadosPorSolicitud($solicitud);
        $row = mysql_fetch_array($recurso);
        $idReservas = $row[idReserva];
        return $idReservas;
    }

    /**
     * Metodo para actualizar los estados de varias reservas
     * @param <String> $solicitud
     * @param <String> $estado
     * @param <String> $tipo
     * @param <double> $monto
     * @param <String> $nombreBanco
     * @param <Integer> $numeroTransaccion
     * @param <Integer> $monedaId
     * @return <recurso> resultado de la operación
     *
     * Resultados:
     * 8 = No existe el localizador
     * 1 = PP -> CO
     * 2 = PP -> PA
     * 3 = PP -> CA 
     * 4 = PP -> PP
     *
     * 5 = CO -> PA
     * 6 = CO -> CA 
     * 7 = CO -> PP
     * 17 = CO -> CO
     *
     * 9 = PA -> PP
     * 10 = PA -> CO
     * 11 = PA -> CA se hace un reembolso
     * 12 = PA -> PA
     *
     * 13 = CA -> PP
     * 14 = CA -> CO
     * 15 = CA -> PA
     * 16 = CA -> CA
     */
    function actualizarEstadoReserva($solicitud, $estado, $tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId) {
        $verificarSolicitud = $this->existeSolicitud($solicitud);
        if($verificarSolicitud != $solicitud){
            $resultado = 8;
        }
        else if ($verificarSolicitud == $solicitud){

            $estadoBD = $this->estadoReserva($solicitud);
            if($estadoBD == 'PP'){
                if($estado == 'CO'){
                    $editaEstado = $this->controlBD->editarEstadoReserva($solicitud, $estado);
                    $resultado = 1;
                }
                if($estado == 'PA'){
                    $pagoId = $this->controlPago->nuevoPago($tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId);
                    if($pagoId > 0){
                        $estadoReserva = $this->estadoReserva($solicitud);
                        $editaEstado = $this->controlBD->editarEstadoPagadoReserva($solicitud, $estado, $pagoId);
                        $resultado = 2;
                    }
                }
                if($estado == 'CA'){
                    $editaEstado = $this->controlBD->editarEstadoReserva($solicitud, $estado);
                    $recurso = $this->controlBD->buscarLosIdRelacionadosPorSolicitud($solicitud);
                    while($row = mysql_fetch_array($recurso)){
                        $idReservas = $row[idReserva];
                        $eliminacionVuelosReserva = $this->controlVueloReservaBD->eliminarVueloReserva($idReservas);
                        $resultado = 3;
                    }
                }
                if($estado == 'PA'){
                    $resultado = 4;
                }
            }

            if($estadoBD == 'CO'){
                if($estado == 'PA'){
                    $pagoId = $this->controlPago->nuevoPago($tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId);
                    if($pagoId > 0){
                        $estadoReserva = $this->estadoReserva($solicitud);
                        $editaReserva = $this->controlBD->editarEstadoPagadoReserva($solicitud, $estado, $pagoId);
                        $resultado = 5;
                    }
                }
                if($estado == 'CA'){
                    $editaEstado = $this->controlBD->editarEstadoReserva($solicitud, $estado);
                    $recurso = $this->controlBD->buscarLosIdRelacionadosPorSolicitud($solicitud);
                    while($row = mysql_fetch_array($recurso)){
                        $idReservas = $row[idReserva];
                        $eliminacionVuelosReserva = $this->controlVueloReservaBD->eliminarVueloReserva($idReservas);
                        $resultado = 6;
                    }
                }
                if($estado == 'PP'){
                    $resultado = 7;
                }
                if($estado == 'CO'){
                    $resultado = 17;
                }
            }

            if($estadoBD == 'PA'){
                if($estado == 'PP'){
                    $resultado = 9;
                }
                if($estado == 'CO'){
                    $resultado = 10;
                }
                if($estado == 'CA'){
                    $editaEstado = $this->controlBD->editarEstadoReserva($solicitud, $estado);
                    $recurso = $this->controlBD->buscarLosIdRelacionadosPorSolicitud($solicitud);
                    while($row = mysql_fetch_array($recurso)){
                        $idReservas = $row[idReserva];
                        $eliminacionVuelosReserva = $this->controlVueloReservaBD->eliminarVueloReserva($idReservas);
                        $resultado = 11;
                    }
                }
                if($estado == 'PA'){
                    $resultado = 12;
                }
            }

            if($estadoBD == 'CA'){
                if($estado == 'PP'){
                    $resultado = 13;
                }
                if($estado == 'CO'){
                    $resultado = 14;
                }
                if($estado == 'PA'){
                    $resultado = 15;
                }
                if($estado == 'CA'){
                    $resultado = 16;
                }
            }
        }
        return $resultado;
    }

    /**
     * Metodo para actualizar el estado de una reserva
     * @param <Integer> $idReserva Identificador de la reserva
     * @param <String> $estado Estado de la reserva
     * @return <recurso> resultado de la operacion
     *
     * Resultados:
     * 8 = No existe el localizador
     * 1 = PP -> CO
     * 2 = PP -> PA
     * 3 = PP -> CA 
     * 4 = PP -> PP
     *
     * 5 = CO -> PA
     * 6 = CO -> CA 
     * 7 = CO -> PP
     * 17 = CO -> CO
     *
     * 9 = PA -> PP
     * 10 = PA -> CO
     * 11 = PA -> CA se hace un reembolso
     * 12 = PA -> PA
     *
     * 13 = CA -> PP
     * 14 = CA -> CO
     * 15 = CA -> PA
     * 16 = CA -> CA
     */
    function actualizarEstadoReservaPorPersona($idReserva, $estado, $tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId) {
        $verificarReserva = $this->existeReserva($idReserva);
        if($verificarReserva != $idReserva){
            $resultado = 8;

        }else if ($verificarSolicitud == $idReserva){
            $estadoBD = $this->estadoReservaPorPersona($idReserva);
            if($estadoBD == 'PP'){
                if($estado == 'CO'){
                    $editaEstado = $this->controlBD->editarEstadoReservaPorPersona($idReserva, $estado);
                    $resultado = 1;
                }
                if($estado == 'PA'){
                    $pagoId = $this->controlPago->nuevoPago($tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId);
                    if($pagoId > 0){
                        $estadoReserva = $this->estadoReservaPorPersona($idReserva);
                        $editaEstado = $this->controlBD->editarEstadoPagadoReservaPorPersona($idReserva, $estado, $pagoId);
                        $resultado = 2;
                    }
                }
                if($estado == 'CA'){
                    $editaEstado = $this->controlBD->editarEstadoReservaPorPersona($idReserva, $estado);
                    $eliminacionVuelosReserva = $this->controlVueloReservaBD->eliminarVueloReserva($idReserva);
                    $resultado = 3;
                }
                if($estado == 'PA'){
                    $resultado = 4;
                }
            }

            if($estadoBD == 'CO'){
                if($estado == 'PA'){
                    $pagoId = $this->controlPago->nuevoPago($tipo, $monto, $nombreBanco, $numeroTransaccion, $monedaId);
                    if($pagoId > 0){
                        $estadoReserva = $this->estadoReservaPorPersona($idReserva);
                        $editaReserva = $this->controlBD->editarEstadoPagadoReservaPorPersona($idReserva, $estado, $pagoId);
                        $resultado = 5;
                    }
                }
                if($estado == 'CA'){
                    $editaEstado = $this->controlBD->editarEstadoReservaPorPersona($idReserva, $estado);
                    $eliminacionVuelosReserva = $this->controlVueloReservaBD->eliminarVueloReserva($idReserva);
                    $resultado = 6;
                }
                if($estado == 'PP'){
                    $resultado = 7;
                }
                if($estado == 'CO'){
                    $resultado = 17;
                }
            }

            if($estadoBD == 'PA'){
                if($estado == 'PP'){
                    $resultado = 9;
                }
                if($estado == 'CO'){
                    $resultado = 10;
                }
                if($estado == 'CA'){
                    $editaEstado = $this->controlBD->editarEstadoReservaPorPersona($idReserva, $estado);
                    $eliminacionVuelosReserva = $this->controlVueloReservaBD->eliminarVueloReserva($idReserva);
                    $resultado = 11;
                }
                if($estado == 'PA'){
                    $resultado = 12;
                }
            }

            if($estadoBD == 'CA'){
                if($estado == 'PP'){
                    $resultado = 13;
                }
                if($estado == 'CO'){
                    $resultado = 14;
                }
                if($estado == 'PA'){
                    $resultado = 15;
                }
                if($estado == 'CA'){
                    $resultado = 16;
                }
            }
        }
        return $resultado;
    }

    /**
     * Metodo para calcular la cantidad de adultos y ninos que existen bajo una solicitud
     * @param <type> $solicitud La solicitud a consultar
     * @return <type> La cantidad de adultos y ninos que existen para una solicitud
     */
    function cantidadAdlChlIda($solicitud){
        $recurso = $this->controlBD->cantidadPasajerosIda($solicitud);
        $row = mysql_fetch_array($recurso);
        $cantidadPasajeros = $row[cantidadPasajeros];
        $cantidadInfantes = $this->cantidadInfantesIda($solicitud);
        $cantidadAdlChl = $cantidadPasajeros-$cantidadInfantes;

        return $cantidadAdlChl;
    }

    /**
     * Metodo para calcular la cantidad de infantes que existen bajo una solicitud
     * @param <type> $solicitud La solicitud a consultar
     * @return <type> La cantidad de infantes que existen para una solicitud
     */
    function cantidadInfantesIda($solicitud){
        $recurso = $this->controlBD->cantidadInfantesIda($solicitud);
        $row = mysql_fetch_array($recurso);
        $cantidadInfantes = $row[cantidadInfantes];
        return $cantidadInfantes;
    }
    
    function verificarCantidadPasajeros($solicitud,$cantAdl,$cantInf){
        $cantidadAdultos = $this->cantidadAdlChlIda($solicitud);
        $cantidadInfantes = $this->cantidadInfantesIda($solicitud);
        if(($cantidadAdultos == $cantAdl) && ($cantidadInfantes == $cantInf)){
            return true;
        }else{
            return false;
        }
    }
}
?>