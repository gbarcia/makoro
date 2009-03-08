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
        $query = "INSERT INTO RESERVA (`fecha`, `estado`, `solicitud`, `TIPO_SERVICIO_id`, `SUCURSAL_id`,
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
    function agregarReserva($reserva){
        $resultado = false;
        $query = "";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>