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
    function consultarVuelo($fecha,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada) {
        $resultado = false;
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula avionMatricula,v.RUTA_sitioSalida rutaSitioSalida,
                         v.RUTA_sitioLlegada rutaSitioLlegada,a.asientos
                  FROM VUELO v, RUTA ru, AVION a
                  WHERE v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND v.AVION_matricula = a.matricula ";
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
    function consultarDetallesVuelo($idVuelo,$idSucursal){
        $query = "SELECT P.cedula, P.nombre as pasajeroNombre, P.apellido as pasajeroApellido, TP.id as tipoPasajero, TS.nombre as servicio,
                         E.nombre as encargadoNombre, VR.tipo, R.CLIENTE_AGENCIA_rif as agencia, R.CLIENTE_PARTICULAR_cedula as particular,
                         IF(R.CLIENTE_AGENCIA_rif is not null,CA.nombre,CONCAT(CP.nombre,' ',CP.apellido)) as clienteNombre
                  FROM VUELO V, VUELO_RESERVA VR, SUCURSAL S, RESERVA R, PASAJERO P, TIPO_SERVICIO TS,
                       ENCARGADO E, TIPO_PASAJERO TP, CLIENTE_PARTICULAR CP, CLIENTE_AGENCIA CA
                  WHERE V.id = VR.VUELO_id
                  AND R.id = VR.RESERVA_id
                  AND V.id = ".$idVuelo."
                  AND P.id = R.PASAJERO_id
                  AND TP.id = P.TIPO_PASAJERO_id
                  AND TS.id = R.TIPO_SERVICIO_id
                  AND S.id = R.SUCURSAL_id
                  AND S.id = ".$idSucursal."
                  AND E.cedula = R.ENCARGADO_cedula
                  AND (R.CLIENTE_PARTICULAR_cedula = CP.cedula
                       OR R.CLIENTE_AGENCIA_rif = CA.rif)
                  GROUP BY(cedula)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
