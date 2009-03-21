<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Equipaje.class.php';
/**
 * Description of controladorEquipajeBDclass
 * Clase para el manejo de la base de datos de Equipaje
 * @author jonathan
 */
class controladorEquipajeBDclass {

    private $transaccion;

    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Funcion para agregar un equipaje
     * @param Equipaje $equipaje el equipaje a agregar
     * @return Boolean resultado de la operacion
     */
    function agregarEquipaje($equipaje){
        $resultado = false;
        $query = "INSERT INTO EQUIPAJE (descripcion, tipo, peso, RESERVA_id) ".
                 "VALUES ('" . $equipaje->getDescripcion() . "',
                          '" . $equipaje->getTipo() . "',
                           " . $equipaje->getPeso() . ",
                           " . $equipaje->getReservaId() . ")";
        echo $query;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Funcion para editar el equipaje
     * @param Equipaje $equipaje el equipaje a editar
     * @return Boolean resultado de la operacion
     */
    function editarEquipaje($equipaje){
        $resultado = false;
        $query = "UPDATE EQUIPAJE e SET e.descripcion = '" . $equipaje->getDescripcion() . "',
                                        e.tipo = '" . $equipaje->getTipo() . "' ,
                                        e.peso = " . $equipaje->getPeso()  . ",
                                        e.RESERVA_id = " . $equipaje->getReservaId() . "
                  WHERE e.id = ".$equipaje->getId()."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Funcion para consultar el equipaje
     * @return Recurso todos los equipajes
     */
    function consultarEquipaje(){
        $resultado = false;
        $query = "SELECT descripcion, tipo, peso
                  FROM EQUIPAJE";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Funcion para consultar el equpaje por reservas y sus pasajeros
     * @return Recurso todos los equipajes con sus reservas y pasajeros
     */
    function consultarEquipajeReservaPasajeroVuelo(){
        $resultado = false;
        $query = "SELECT DISTINCT e.descripcion descripcion, e.tipo tipo, e.peso peso, r.id idReserva, r.estado estado,
                         r.solicitud solicitud, p.id idPasajero, p.nombre nombre, p.apellido apellido, p.cedula cedula,
                         p.pasaporte pasaporte, p.nacionalidad nacionalidad, p.TIPO_PASAJERO_id idTipoPasajero, v.id idVuelo,
                         v.fecha fecha, v.hora hora, ru.sitioSalida sitioSalida, ru.sitioLlegada sitioLlegada,
                         ru.abreviaturaSalida abreviaturaSalida, ru.abreviaturaLlegada abreviaturaLlegada,
                         CONCAT(ru.abreviaturaSalida, ' - ',ru.abreviaturaLlegada) ruta
                  FROM EQUIPAJE e, RESERVA r, PASAJERO p, VUELO_RESERVA vr, VUELO v, RUTA ru
                  WHERE e.RESERVA_id = r.id
                        AND r.PASAJERO_id = p.id
                        AND vr.RESERVA_id = r.id
                        AND vr.VUELO_id = v.id
                        AND v.RUTA_sitioSalida = ru.sitioSalida
                        AND v.RUTA_sitioLlegada = ru.sitioLlegada";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Funcion para consultar todos los equipajes de un pasajero
     * @param String/int $cedulaOPasaporte la cedula o pasaporte del pasajero
     * @return Recurso todos los equipajes con sus reservas de un pasajero
     */
    function consultarEquipajeDePasajero($cedulaOPasaporte){
        $resultado = false;
        $query = "SELECT e.descripcion descripcion, e.tipo tipo, e.peso peso, r.id idReserva, r.estado estado,
                         r.solicitud solicitud, p.id idPasajero, p.nombre nombre, p.apellido apellido, p.cedula cedula,
                         p.pasaporte pasaporte, p.nacionalidad nacionalidad, p.TIPO_PASAJERO_id idTipoPasajero, v.id idVuelo,
                         v.fecha fecha, v.hora hora, ru.sitioSalida sitioSalida, ru.sitioLlegada sitioLlegada,
                         ru.abreviaturaSalida abreviaturaSalida, ru.abreviaturaLlegada abreviaturaLlegada,
                         CONCAT(ru.abreviaturaSalida, ' - ',ru.abreviaturaLlegada) ruta
                  FROM EQUIPAJE e, RESERVA r, PASAJERO p, VUELO_RESERVA vr, VUELO v, RUTA ru
                  WHERE e.RESERVA_id = r.id
                        AND r.PASAJERO_id = p.id
                        AND vr.RESERVA_id = r.id
                        AND vr.VUELO_id = v.id
                        AND v.RUTA_sitioSalida = ru.sitioSalida
                        AND v.RUTA_sitioLlegada = ru.sitioLlegada
                        AND (p.cedula LIKE '" . $cedulaOPasaporte . "%'
                             OR p.pasaporte LIKE '" . $cedulaOPasaporte . "%')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Funcion para consultar el equipaje de un vuelo
     * @param int $idVuelo el identificador del vuelo
     * @return Recurso todos los equipajes con sus reservas de un pasajero
     */
    function consultarEquipajePorVuelo($idVuelo){
        $resultado = false;
        $query = "SELECT e.descripcion descripcion, e.tipo tipo, e.peso peso, r.id idReserva, r.estado estado,
                         r.solicitud solicitud, p.id idPasajero, p.nombre nombre, p.apellido apellido, p.cedula cedula,
                         p.pasaporte pasaporte, p.nacionalidad nacionalidad, p.TIPO_PASAJERO_id idTipoPasajero, v.id idVuelo,
                         v.fecha fecha, v.hora hora, ru.sitioSalida sitioSalida, ru.sitioLlegada sitioLlegada,
                         ru.abreviaturaSalida abreviaturaSalida, ru.abreviaturaLlegada abreviaturaLlegada,
                         CONCAT(ru.abreviaturaSalida, ' - ',ru.abreviaturaLlegada) ruta
                  FROM EQUIPAJE e, RESERVA r, PASAJERO p, VUELO_RESERVA vr, VUELO v, RUTA ru
                  WHERE e.RESERVA_id = r.id
                        AND r.PASAJERO_id = p.id
                        AND vr.RESERVA_id = r.id
                        AND vr.VUELO_id = v.id
                        AND v.RUTA_sitioSalida = ru.sitioSalida
                        AND v.RUTA_sitioLlegada = ru.sitioLlegada
                        AND v.id = " . $idVuelo;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar el equipaje de un reserva determinada
 * @param <Integer> $idReserva Identificador de la reserva
 * @return <recurso> descripcion del equipaje
 */
    function consultarEquipajePorPasajeroReserva($idReserva){
        $resultado = false;
        $query = "SELECT e.descripcion descripcion, e.tipo tipo, e.peso peso
                  FROM EQUIPAJE e, RESERVA r
                  WHERE r.id = e.RESERVA_id
                  AND e.RESERVA_id = " . $idReserva."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

}
?>
