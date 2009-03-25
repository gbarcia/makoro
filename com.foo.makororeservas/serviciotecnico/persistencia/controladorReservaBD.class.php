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
        $query ="SELECT IF((SELECT AV.asientos-COUNT(VRE.RESERVA_id)-".$cantAdultoNino."+V.cantidadInfantes
                                 FROM VUELO_RESERVA VRE, VUELO VU , RESERVA RE
                                 WHERE RE.id = VRE.RESERVA_id
                                 AND VU.id = VRE.VUELO_id
                                 AND VRE.VUELO_id = V.id)>=0,TRUE,FALSE) as disponibleAdultoNino
                  FROM VUELO V, AVION AV
                  WHERE V.id = ".$idVuelo."
                  AND V.AVION_matricula = AV.matricula ";
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
     * Metodo para verificar la existencia de una solicitud
     * @param <type> $solicitud La solicitud a consultar
     * @return <type> Si existe devuelve la solicitud, de lo contrario devuelve 0
     */
    function existeSolicitud($solicitud) {
        $query = "SELECT IFNULL((SELECT DISTINCT r.solicitud
                                 FROM RESERVA r
                                 WHERE r.solicitud = '".$solicitud."'),0) as validacion";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para verificar la existencia de una reserva
     * @param <type> $idReserva La reserva de consultar
     * @return <type> Si existe devuelve el id de la reserva, de lo contrario devuelve 0
     */
    function existeReserva($idReserva) {
        $query = "SELECT IFNULL((SELECT DISTINCT r.id
                                 FROM RESERVA r
                                 WHERE r.id= ".$idReserva."),0) as validacion";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar el estado de varias reservas a pagado
     * @param <String> $solicitud Identificador de la reserva
     * @param <String> $estado Nuevo estado
     * @param <Integer> $pagoId Identificador del pago realizado
     * @return <boolean> resultado de la operacion
     */
    function editarEstadoPagadoReserva($solicitud, $estado, $pagoId){
        $resultado = false;
        $query = "UPDATE RESERVA r SET r.estado = '".$estado."',
                                       r.PAGO_id = ".$pagoId."
                  WHERE r.solicitud = '".$solicitud."'";
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
    function editarEstadoPagadoReservaPorPersona($idReserva, $estado, $pagoId){
        $resultado = false;
        $query = "UPDATE RESERVA r SET r.estado = '".$estado."',
                                       r.PAGO_id = ".$pagoId."
                  WHERE r.id = '".$idReserva."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar el estado de una reserva
     * @param <Integer> $idReserva Identificador de la reserva
     * @param <String> $estado Nuevo estado
     * @return <boolean> El resultado de la operacion
     */
    function editarEstadoReserva($solicitud, $estado){
        $resultado = false;
        $query = "UPDATE RESERVA r SET r.estado = '".$estado."'
                                   WHERE r.solicitud = '".$solicitud."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar el estado de una reserva
     * @param <Integer> $idReserva Identificador de la reserva
     * @param <String> $estado Nuevo estado
     * @return <boolean> El resultado de la operación
     */
    function editarEstadoReservaPorPersona($idReserva, $estado){
        $resultado = false;
        $query = "UPDATE RESERVA r SET r.estado = '".$estado."'
                                   WHERE r.id = '".$idReserva."'";
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
     * Metodo para consultar los identificadores de las reservas relacionadas
     * con una solicitud suministrada
     * @param <String> $solicitud Localizador de la reserva
     * @return <recurso> recurso con los identificadores de la reserva
     */
    function buscarLosIdRelacionadosPorSolicitud($solicitud){
        $query = "SELECT R.id idReserva
                  FROM RESERVA R
                  WHERE R.solicitud = '".$solicitud."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar el estado de una reserva
     * @param <String> $solicitud Localizador de la reserva
     * @return <recurso> estado de la reserva
     */
    function consultarEstadoReserva($solicitud){
        $query = "SELECT DISTINCT R.estado estado
                  FROM RESERVA R
                  WHERE R.solicitud = '".$solicitud."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar el estado de una reserva determinada
     * @param <Integer> $idReserva Identificador de la reserva
     * @return <recurso> estado de la reserva de la persona
     */
    function consultarEstadoReservaPorPersona($idReserva){
        $query = "SELECT DISTINCT R.estado estado
                  FROM RESERVA R
                  WHERE R.id = '".$idReserva."'";
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

    /**
     * Metodo para consultar los clientes que estan bajo una solicitud
     * @param <type> $solicitud La solicitud a consultar
     * @return <type> Los clientes que estan en la solicitud consultada
     */
    function consultarClienteReserva($solicitud){
        $query = "SELECT r.CLIENTE_PARTICULAR_cedula cedula, r.CLIENTE_AGENCIA_rif rif, IF(r.CLIENTE_PARTICULAR_cedula,'particular','juridico') grupo
                  FROM RESERVA r
                  WHERE r.solicitud = '" . $solicitud . "'
                  GROUP BY r.solicitud";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para calcular la cantidad de pasajeros que existen bajo una solicitud
     * @param <type> $solicitud La solicitud a consultar
     * @return <type>  La cantidad de pasajeros que existen bajo una solicitud
     */
    function cantidadPasajerosIda($solicitud){
        $query = "SELECT COUNT(R.id) as cantidadPasajeros
                  FROM RESERVA R, VUELO_RESERVA VR, VUELO V
                  WHERE R.solicitud = '".$solicitud."'
                  AND R.id = VR.RESERVA_id
                  AND V.id = VR.VUELO_id
                  AND VR.tipo = 'ida'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para calcular la cantidad de infantes que existen bajo una solicitud
     * @param <type> $solicitud La solicitud a consultar
     * @return <type> La cantidad de infantes que existen para una solicitud
     */
    function cantidadInfantesIda($solicitud){
        $query = "SELECT COUNT(R.id) as cantidadInfantes
                  FROM RESERVA R, PASAJERO P, VUELO_RESERVA VR, VUELO V, TIPO_PASAJERO TP
                  WHERE R.solicitud = '".$solicitud."'
                  AND R.PASAJERO_id = P.id
                  AND TP.id = P.TIPO_PASAJERO_id
                  AND TP.id = 'INF'
                  AND R.id = VR.RESERVA_id
                  AND V.id = VR.VUELO_id
                  AND VR.tipo = 'ida'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function obtenerIdVueloInfantesIda($solicitud){
        $query = "SELECT V.id as idVueloIda, COUNT(R.id) as cantidadInfantesIda
                  FROM RESERVA R, PASAJERO P, VUELO_RESERVA VR, VUELO V, TIPO_PASAJERO TP
                  WHERE R.solicitud = '".$solicitud."'
                  AND R.PASAJERO_id = P.id
                  AND TP.id = P.TIPO_PASAJERO_id
                  AND TP.id = 'INF'
                  AND R.id = VR.RESERVA_id
                  AND V.id = VR.VUELO_id
                  AND VR.tipo = 'ida'
                  GROUP BY(V.id)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function obtenerIdVueloInfantesVuelta($solicitud){
        $query = "SELECT V.id as idVueloVuelta, COUNT(R.id) as cantidadInfantesVuelta
                  FROM RESERVA R, PASAJERO P, VUELO_RESERVA VR, VUELO V, TIPO_PASAJERO TP
                  WHERE R.solicitud = '".$solicitud."'
                  AND R.PASAJERO_id = P.id
                  AND TP.id = P.TIPO_PASAJERO_id
                  AND TP.id = 'INF'
                  AND R.id = VR.RESERVA_id
                  AND V.id = VR.VUELO_id
                  AND VR.tipo = 'vuelta'
                  GROUP BY(V.id)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function obtenerCantInfVuelo($idVuelo){
        $query = "SELECT V.cantidadInfantes as cantidadInfantesVuelo
                  FROM VUELO V
                  WHERE V.id = $idVuelo";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function eliminarReserva($idReserva){
        $query = "DELETE FROM RESERVA WHERE id = $idReserva";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function eliminarInfante($idPasajero){
        $query = "DELETE FROM PASAJERO WHERE id = $idPasajero";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function existePasajeroVuelo($idVuelo,$idPasajero) {
        $resultado = false;
        $query = "SELECT r.id FROM RESERVA r, VUELO_RESERVA vr, PASAJERO p
                  WHERE r.id = vr.RESERVA_id
                  AND vr.VUELO_id = $idVuelo
                  AND r.PASAJERO_id = $idPasajero
                  AND r.PASAJERO_id = p.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        $can = mysql_num_rows($resultado);
        if ($can > 0)
        $resultado = true;
        else
        $resultado = false;
        return $resultado;
    }

    public function getTransaccion() {
        return $this->transaccion;
    }

    public function setTransaccion($transaccion) {
        $this->transaccion = $transaccion;
    }
/**
 * Operacion para determinar la cantidad de vuelos que hay para una solicitud
 * @param <String> $nSolicitud el numero de la solicitud
 * @return <Integer> la cantidad de vuelos para una solicitud
 */
    function cantidadVuelosParaSolicitud ($nSolicitud) {
        $resultado = false;
        $query = "SELECT DISTINCT(v.id) FROM VUELO_RESERVA vr, VUELO v, RESERVA r
                  WHERE v.id = vr.VUELO_id AND
                  r.solicitud = '".$nSolicitud."'
                  AND vr.RESERVA_id = r.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        $can = mysql_num_rows($resultado);
        return $can;
    }

    function existeAlgunOtroVuelo ($idVueloActual,$numeroSolicitud) {
        $query = "SELECT DISTINCT(v.id) FROM VUELO_RESERVA vr, VUELO v, RESERVA r
                  WHERE
                  v.id = vr.VUELO_id AND
                  r.solicitud = '".$numeroSolicitud."'
                  AND vr.RESERVA_id = r.id
                  AND v.id != $idVueloActual";
        $resultado = $this->transaccion->realizarTransaccion($query);
        $can = mysql_num_rows($resultado);
        if ($can !=1)
        $resultado = -1;
        return $resultado;
    }

    function obtenerIdReservaVueloExistente($numeroSolicitud,$idVueloActual) {
        $idVueloRegistrado = $this->existeAlgunOtroVuelo($idVueloActual, $numeroSolicitud);
        if ($idVueloRegistrado != -1) {
            $rowVueloConPasajeros = mysql_fetch_array($idVueloRegistrado);
            $query = "SELECT r.id FROM RESERVA r, VUELO v, VUELO_RESERVA vr
                      WHERE r.id = vr.RESERVA_id
                      AND v.id = vr.VUELO_id
                      AND r.Pasajero_id is NULL
                      AND r.solicitud = '".$numeroSolicitud."'
                      AND v.id = $rowVueloConPasajeros[id]";
            $resultado = $this->transaccion->realizarTransaccion($query);
            $cantidad = mysql_num_rows($resultado);
            if ($cantidad > 0) {
                $rowReservaId = mysql_fetch_array($resultado);
                return $rowReservaId[id];
            }else
            return -1;
        }else
        return -1;
    }

    function obtenerSolicitudPorVueloReserva ($idVuelo, $idReserva) {
        $query = "SELECT r.solicitud FROM RESERVA r, VUELO_RESERVA vr, VUELO v
                  WHERE r.id = vr.RESERVA_id
                  AND vr.VUELO_id = v.id
                  AND v.id = $idVuelo
                  AND r.id = $idReserva";
        $resultado = $this->transaccion->realizarTransaccion($query);
        $row = mysql_fetch_array($resultado);
        return $row[solicitud];
    }

}
?>