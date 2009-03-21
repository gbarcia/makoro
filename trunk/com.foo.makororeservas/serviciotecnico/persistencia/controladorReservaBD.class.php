<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Reserva.class.php';
/**
 * Description of controladorReservaBDclass
 * Clase para manejar las reservas en la base de datos
 * @author Diana Uribe
 */
class controladorReservaBDclass {
    public $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar una reserva
     * @param <type> $reserva La reserva a agregar
     * @return <type> El resultado de la operacion
     */
    function agregarReserva($reserva){
        $resultado = false;
        $query = " INSERT INTO RESERVA (`fecha`, `estado`, `solicitud`, `TIPO_SERVICIO_id`, `SUCURSAL_id`,
                                       `ENCARGADO_cedula`, `CLIENTE_PARTICULAR_cedula`, `CLIENTE_AGENCIA_rif`,
                                       `PAGO_id`, `PASAJERO_id`, `POSADA_id`)
                                VALUES('". $reserva->getFecha() ."',
                                       '". $reserva->getEstado() ."',
                                       '". $reserva->getSolicitud() ."',
                                        ". $reserva->getTipoServicioId() .",
                                        ". $reserva->getSucursalId() .",
                                        ". $reserva->getEncargadoCedula() .",";
        if(is_null($reserva->getClienteParticularCedula())){
            $query .= "null,";
        }else{
            $query .= $reserva->getClienteParticularCedula() .",";
        }
        if(is_null($reserva->getClienteAgenciaRif())){
            $query .= "null,";
        }else{
            $query .= "'". $reserva->getClienteAgenciaRif() ."',";
        }
        if(is_null($reserva->getPagoId())){
            $query .= "null,";
        }else{
            $query .= $reserva->getPagoId() .",";
        }
        if(is_null($reserva->getPasajeroId())){
            $query .= "null,";
        }else{
            $query .= $reserva->getPasajeroId() .",";
        }
        if(is_null($reserva->getPosadaId())){
            $query .= "null)";
        }else{
            $query .= $reserva->getPosadaId() .")";
        }
        $resultado = $this->transaccion->realizarTransaccionInsertId($query);
        return $resultado;
    }

    /**
     * Metodo para consultar la cantidad de asientos disponibles en un vuelo
     * @param <type> $idVuelo El id del vuelo a verificar
     * @param <type> $cantPasajeros La cantidad de pasajeros adultos o ninos
     * @return <type>
     */
    function asientosDisponiblesAdultoNino($idVuelo,$cantAdultoNino){
        $query = "SELECT IF(a.asientos-(COUNT(vre.RESERVA_id)+".$cantAdultoNino."-vu.cantidadInfantes)>=0,TRUE,FALSE) as disponibleAdultoNino
                  FROM VUELO_RESERVA vre, VUELO vu, RESERVA re, AVION a
                  WHERE re.id = vre.RESERVA_id
                  AND vu.id = vre.VUELO_id
                  AND vu.AVION_matricula = a.matricula
                  AND vre.VUELO_id = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar la cantidad de asientos disponibles en un vuelo
     * @param <type> $idVuelo El id del vuelo a verificar
     * @param <type> $cantInfantes La cantidad de pasajeros infantes
     * @return <type>
     */
    function asientosDisponiblesInfante($idVuelo,$cantInfantes){
        $query = "SELECT IF(2-(vu.cantidadInfantes+".$cantInfantes.")>=0,TRUE,FALSE) as disponibleInfante
                  FROM VUELO vu
                  WHERE vu.id  = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para verificar la existencia de un pasajero
     * @param <type> $cedula La cedula del pasajero
     * @param <type> $pasaporte el pasaporte del pasajero
     * @return <type> El resultado de la operacion
     */
    function existePasajero($cedula,$pasaporte){
        $query = "";
        if($cedula != ""){
            $query = "SELECT IF((".$cedula.") = PA.cedula,
                             (SELECT CONCAT(PAS.id,', ',PAS.cedula,', ',PAS.nombre,', ',PAS.apellido,', ',PAS.sexo,
                                            ', ',PAS.nacionalidad,', ',PAS.TIPO_PASAJERO_id)
                              FROM PASAJERO PAS
                              WHERE PAS.cedula = ".$cedula."),
                             NULL) as pasajero
                      FROM PASAJERO PA
                      WHERE PA.cedula  = ".$cedula."";
        }else if(($pasaporte != "") && ($cedula == "")){
            $query = "SELECT IF(('".$pasaporte."') = PA.pasaporte,
                             (SELECT CONCAT(PAS.id,', ',PAS.pasaporte,', ',PAS.nombre,', ',PAS.apellido,', ',PAS.sexo,
                                            ', ',PAS.nacionalidad,', ',PAS.TIPO_PASAJERO_id)
                              FROM PASAJERO PAS
                              WHERE PAS.pasaporte = ".$pasaporte."),
                             NULL) as pasajero
                      FROM PASAJERO PA
                      WHERE PA.pasaporte  = '".$pasaporte."'";
        }
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para verificar la existencia de un cliente agencia
     * @param <type> $rif El rif del cliente a verificar
     * @return <type> Si el cliente existe o no
     */
    function existeClienteAgencia($rif){
        $query = "SELECT IF(('".$rif."') = CA.rif,
                            (SELECT CLA.nombre
                              FROM CLIENTE_AGENCIA CLA
                              WHERE CLA.rif = '".$rif."'),
                             NULL) as existeAgencia
                  FROM CLIENTE_AGENCIA CA
                  WHERE CA.rif  = '".$rif."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para verificar la existencia de un cliente particular
     * @param <type> $cedula La cedula del cliente a verificar
     * @return <type> Si el cliente existe o no
     */
    function existeClienteParticular($cedula){
        $query = "SELECT IF((".$cedula.") = CP.cedula,
                            (SELECT CONCAT(CLP.apellido,', ',CLP.nombre)
                              FROM CLIENTE_PARTICULAR CLP
                              WHERE CLP.cedula = ".$cedula."),
                             NULL) as existeParticular
                  FROM CLIENTE_PARTICULAR CP
                  WHERE CP.cedula  = ".$cedula."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar el estado de una reserva a pagado
     * @param <Integer> $idReserva Identificador de la reserva
     * @param <String> $estado Nuevo estado
     * @param <Integer> $pagoId Identificador del pago realizado
     * @return <boolean> resultado de la operacion
     */
    function editarEstadoPagadoReserva($idReserva, $estado, $pagoId){
        $resultado = false;
        $query = "UPDATE RESERVA r SET r.estado = '".$estado."',
                                       r.PAGO_id = ".$pagoId."
                  WHERE r.id = ".$idReserva."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar el estado de una reserva
     * @param <Integer> $idReserva Identificador de la reserva
     * @param <String> $estado Nuevo estado
     * @return <type> El resultado de la operacion
     */
    function editarEstadoReserva($idReserva, $estado){
        $resultado = false;
        $query = "UPDATE RESERVA r SET r.estado = '".$estado."'
                                   WHERE r.id = ".$idReserva."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para buscar los identificadores de las reservas de una solicitud
     * @param <type> $solicitud la solicitud a consultar
     * @return <type> los id de las reservas
     */
    function buscarIdReserva($solicitud,$idVuelo){
        $query = "SELECT R.id idReserva
                  FROM RESERVA R, VUELO V
                  WHERE R.solicitud = '".$solicitud."'
                  AND V.id = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar el estado de una reserva
     * @param <Integer> $idReserva Identificador de la reserva
     * @return <recurso> estado de la reserva
     */
    function consultarEstadoReserva($idReserva){
        $query = "SELECT R.estado estado
                  FROM RESERVA R
                  WHERE R.id = ".$idReserva."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para actualizar reserva, asignar un pasajero a una reserva
     * @param <type> $idPasajero El id del pasajero a asignar
     * @return <type> El resultado de la operacion
     */
    function actualizarIdReserva($idPasajero, $idReserva){
        $query = "UPDATE RESERVA R SET R.PASAJERO_id = ".$idPasajero."
                                   WHERE R.id = ".$idReserva."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function consultarClienteReserva($solicitud){
        $query = "SELECT r.CLIENTE_PARTICULAR_cedula cedula, r.CLIENTE_AGENCIA_rif rif, IF(r.CLIENTE_PARTICULAR_cedula,'particular','juridico') grupo
                  FROM RESERVA r
                  WHERE r.solicitud = '" . $solicitud . "'
                  GROUP BY r.solicitud";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    public function getTransaccion() {
        return $this->transaccion;
    }

    public function setTransaccion($transaccion) {
        $this->transaccion = $transaccion;
    }

}
?>