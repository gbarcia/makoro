<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Reserva.class.php';
/**
 * Description of controladorReservaBDclass
 * Clase para manejar las reservas en la base de datos
 * @author Diana Uribe
 */
class controladorReservaBDclass {
    private $transaccion;

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
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
    
    /**
     * Metodo para consultar la cantidad de asientos disponibles en un vuelo
     * @param <type> $idVuelo El id del vuelo a verificar
     * @param <type> $cantPasajeros La cantidad de pasajeros
     * @return <type>
     */
    function asientosDisponiblesAdultoNino($idVuelo,$cantAdultoNino){
        $query = "SELECT IF(a.asientos-(COUNT(vre.RESERVA_id)+".$cantAdultoNino.")>=0,TRUE,FALSE) as disponibleAdultoNino
                  FROM VUELO_RESERVA vre, VUELO vu, RESERVA re, AVION a
                  WHERE re.id = vre.RESERVA_id
                  AND vu.id = vre.VUELO_id
                  AND vu.AVION_matricula = a.matricula
                  AND vre.VUELO_id = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
    
    function asientosDisponiblesInfante($idVuelo,$cantInfantes){
        $query = "SELECT IF(2-(vu.cantidadInfantes+".$cantInfantes.")>=0,TRUE,FALSE) as disponibleInfante
                  FROM VUELO vu
                  WHERE vu.id  = ".$idVuelo."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar una reserva en la base de datos 
     * @param <type> $reserva la reserva a editar
     * @return <type> El resultado de la operacion 
     */
    function editarReserva($reserva){
        $resultado = false;
        $query = "UPDATE RESERVA r SET r.PASAJERO_id = ".$reserva->getPasajeroId().",
                                       r.TIPO_SERVICIO_id = ".$reserva->getTipoServicioId()."
                  WHERE r.id = ".$reserva->getId()."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function buscarIdReserva($solicitud){
        $query = "SELECT R.id idReserva
                  FROM RESERVA R
                  WHERE R.solicitud = '".$solicitud."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

}
?>