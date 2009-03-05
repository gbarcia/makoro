<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
/**
 * Description of controladorVueloBDclass
 * Clase para manejar los vuelos en la base de datos
 * @author Diana Uribe
 */
class controladorVueloBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agregar un nuevo vuelo en la base de datos
 * @param <VUELO> $vuelo
 * @return <boolean>
 */
    function agregarNuevoVuelo($vuelo) {
        $resultado = false;
        $query = "INSERT INTO VUELO (fecha,hora,AVION_matricula,RUTA_sitioSalida,RUTA_sitioLlegada)
                  VALUES ('".$vuelo->getFecha()."',
                          '".$vuelo->getHora()."',
                          '".$vuelo->getAvionMatricula()."',
                          '".$vuelo->getRutaSitioSalida()."',
                          '".$vuelo->getRutaSitioLlegada()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para modificar cualquier dato del vuelo
 * @param <VUELO> $vuelo
 * @return <boolean>
 */
    function editarVuelo($vuelo) {
        $resultado = false;
        $query = "UPDATE VUELO v SET v.fecha = '".$vuelo->getFecha()."',
                                     v.hora = '".$vuelo->getHora()."',
                                     v.AVION_matricula = '".$vuelo->getAvionMatricula()."',
                                     v.RUTA_sitioSalida = '".$vuelo->getRutaSitioSalida()."',
                                     v.RUTA_sitioLlegada = '".$vuelo->getRutaSitioLlegada()."'
                  WHERE v.id = ".$vuelo->getId()."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar los vuelos
 * @param <VUELO> $vuelo
 * @return <recurso>
 */
    function consultarVuelo($fecha,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada,$capacidad) {
        $resultado = false;
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula avionMatricula,v.RUTA_sitioSalida rutaSitioSalida,
                         v.RUTA_sitioLlegada rutaSitioLlegada,a.asientos,ru.abreviaturaSalida abreviaturaSalida,
                         ru.abreviaturaLlegada abreviaturaLlegada,a.asientos-COUNT(vr.RESERVA_id) as quedan";
                         if($capacidad != ""){
                             $query .= ",if(a.asientos-(COUNT(vr.RESERVA_id)+".$capacidad.")>=0,TRUE,FALSE) as disponibilidad ";
                         }
                  $query .= "FROM VUELO v, RUTA ru, AVION a, RESERVA r, VUELO_RESERVA vr
                  WHERE v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND v.AVION_matricula = a.matricula
                  AND vr.VUELO_id = v.id
                  AND r.id = vr.RESERVA_id
                  AND a.habilitado = 1 ";
                  if($hora != "")
                  $query.= "AND v.hora = '".$hora."'";
                  if($fecha != "")
                  $query.= "AND v.fecha = '".$fecha."'";
                  if($rutaSitioSalida != "")
                  $query.= "AND ru.sitioSalida = '".$rutaSitioSalida."'";
                  if($rutaSitioLlegada != "")
                  $query.= "AND ru.sitioLlegada = '".$rutaSitioLlegada."'";
                  if($avionMatricula != "")
                  $query.= "AND a.matricula = '".$avionMatricula."'";
                  $query.= " GROUP BY v.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar la cantidad de asientos reservados
 * @param <Integer> $id
 * @return <recurso>
 */
    function consultarVueloCantidadReserva($id) {
        $resultado = false;
        $query = "SELECT COUNT(vr.vuelo_id) cantidadReservada, a.asientos asientos, a.matricula
                  FROM VUELO_RESERVA vr, AVION a, VUELO v
                  WHERE vr.VUELO_id IN (SELECT v.id
                                        FROM VUELO v
                                        WHERE v.id = '".$id."')
                  AND vr.VUELO_id = v.id
                  AND v.AVION_matricula = a.matricula";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar los vuelos realizados
 * @return <recurso>
 */
    function consultarVuelosRealizados() {
        $resultado = false;
        $query = "SELECT v.id,v.fecha, v.hora, v.AVION_matricula avionMatricula,
                         v.RUTA_sitioSalida sitioSalida, v.RUTA_sitioLlegada sitioLlegada, 
                         ru.abreviaturaSalida abreviaturaSalida,ru.abreviaturaLlegada abreviaturaLlegada, a.asientos asientos
                  FROM VUELO v,VUELO_RESERVA vr, RESERVA r, RUTA ru, AVION a
                  WHERE v.fecha < SYSDATE(v.fecha)
                  AND v.id = vr.VUELO_id
                  AND vr.RESERVA_id = r.id
                  AND v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND v.AVION_matricula = a.matricula
                  GROUP BY v.id,v.fecha, v.hora, v.AVION_matricula, v.RUTA_sitioSalida, v.RUTA_sitioLlegada,ru.abreviaturaSalida,ru.abreviaturaLlegada
                 ORDER BY v.fecha ASC";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }


    function consultarTodosVuelos() {
        $resultado = false;
        $query = "SELECT v.id id,v.fecha,v.hora,v.AVION_matricula avionMatricula,v.RUTA_sitioSalida rutaSitioSalida,
                         v.RUTA_sitioLlegada rutaSitioLlegada,a.asientos asientos,
                         ru.abreviaturaSalida abreviaturaSalida,ru.abreviaturaLlegada abreviaturaLlegada
                  FROM VUELO v, RUTA ru, AVION a
                  WHERE v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND v.AVION_matricula = a.matricula
                  AND v.fecha > SYSDATE(v.fecha)
                  AND a.habilitado = 1
                  ORDER BY v.id ASC";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar detalles de un vuelo
     * @param <type> $idVuelo El identificador del vuelo a consultar
     * @param <type> $idSucursal El identificador de la sucursal a consultar
     * @return <type> Los detalles de un vuelo
     */
    function consultarDetallesVuelo($idVuelo){
        $query = "SELECT R.id,TP.id as tipoPasajero,
                         IF(R.PASAJERO_id is not null,
                            (SELECT CONCAT(P.cedula,' ',P.nombre,' ',P.apellido)
                             FROM PASAJERO P
                             WHERE P.id = R.PASAJERO_id),
                            IF(R.CLIENTE_AGENCIA_rif is not null,
                               CA.nombre,
                               CONCAT(CP.nombre,' ',CP.apellido))) as pasajero,
                         TS.nombre as servicio,E.nombre as encargadoNombre, VR.tipo,
                         R.CLIENTE_AGENCIA_rif as agencia, R.CLIENTE_PARTICULAR_cedula as particular,
                         IF(R.CLIENTE_AGENCIA_rif is not null,CA.nombre,CONCAT(CP.nombre,' ',CP.apellido)) as clienteNombre,
                         IF(R.PAGO_id is not null,(SELECT IF(P.tipo='E','E',P.tipo) FROM PAGO P WHERE R.PAGO_id = P.id),NULL) as pago,
                         IF(R.PAGO_id is not null,(SELECT IF(P.tipo='E',NULL,P.nombreBanco) FROM PAGO P WHERE R.PAGO_id = P.id),NULL) as banco,
                         IF(R.PAGO_id is not null,(SELECT IF(P.tipo='E',NULL,P.numeroTransaccion) FROM PAGO P WHERE R.PAGO_id = P.id),NULL) as numeroTran,
                         IF(R.PAGO_id is not null,(SELECT P.monto FROM PAGO P WHERE R.PAGO_id = P.id),NULL) as monto,
                         IF((SELECT R.id FROM PAGO P, BOLETO B WHERE R.PAGO_id = P.id AND P.id = B.PAGO_id
                             GROUP BY(R.id)),TRUE,FALSE) as boleto
                  FROM VUELO V, VUELO_RESERVA VR, SUCURSAL S, RESERVA R, PASAJERO P, TIPO_SERVICIO TS,
                       ENCARGADO E, TIPO_PASAJERO TP, CLIENTE_PARTICULAR CP, CLIENTE_AGENCIA CA, BOLETO B
                  WHERE V.id = VR.VUELO_id
                  AND R.id = VR.RESERVA_id
                  AND VR.VUELO_id = ".$idVuelo."
                  AND TP.id = P.TIPO_PASAJERO_id
                  AND TS.id = R.TIPO_SERVICIO_id
                  AND S.id = R.SUCURSAL_id
                  AND E.cedula = R.ENCARGADO_cedula
                  AND (R.CLIENTE_PARTICULAR_cedula = CP.cedula
                       OR R.CLIENTE_AGENCIA_rif = CA.rif)
                  GROUP BY(R.id)
                  ORDER BY(R.id)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar los clientes con mas reservas pagadas
     * @param <type> $idSucursal El id de la sucursal a consultar
     * @param <type> $fechaInicio La fecha de inicio a consultar
     * @param <type> $fechaFin La fecha de fin a consultar
     * @return <type> Los clientes con mas vuelos
     */
    function consultarClienteConMasVuelos($idSucursal,$fechaInicio,$fechaFin){
        $query = "SELECT r.id,r.CLIENTE_PARTICULAR_cedula as particular,r.CLIENTE_AGENCIA_rif as agencia,
                         if(r.CLIENTE_PARTICULAR_cedula is null,(SELECT ca.nombre FROM CLIENTE_AGENCIA ca WHERE r.CLIENTE_AGENCIA_rif = ca.rif),(SELECT CONCAT(cp.nombre,' ',cp.apellido) FROM CLIENTE_PARTICULAR cp WHERE r.CLIENTE_PARTICULAR_cedula = cp.cedula)) as cliente,
                         if(r.CLIENTE_PARTICULAR_cedula is null,COUNT(r.CLIENTE_AGENCIA_rif),COUNT(r.CLIENTE_PARTICULAR_cedula)) as cantidad
                  FROM SUCURSAL s, RESERVA r
                  WHERE s.id = r.SUCURSAL_id
                  AND s.id = ".$idSucursal."
                  AND r.estado = 'PA'
                  AND r.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'
                  GROUP BY agencia,particular
                  ORDER BY cantidad desc";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>