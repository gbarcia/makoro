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
        $query = "UPDATE EQUIPAJE SET descripcion = '" . $equipaje->getDescripcion() . "',
                                      tipo = '" . $equipaje->getTipo() . "' ,
                                      peso = " . $equipaje->getPeso() . ",
                                      RESERVA_id = " . $equipaje->getReservaID() . "
                  WHERE id = " . $equipaje->getId();
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Funcion para consultar el equipaje
     * @return Recurso todos los equipajes
     */
    function consultarEquipaje(){
        $resultado = false;
        $query = "SELECT * FROM EQUIPAJE";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Funcion para consultar el equpaje por reservas y sus pasajeros
     * @return Recurso todos los equipajes con sus reservas y pasajeros
     */
    function consultarEquipajeReservaPasajeroVuelo(){
        $resultado = false;
        $query = "SELECT e.descripcion, e.tipo, e.peso, r.id, r.estado,
                         r.solicitud, p.id, p.nombre, p.apellido, p.cedula,
                         p.pasaporte, p.nacionalidad, p.TIPO_PASAJERO_id, v.id,
                         v.fecha, v.hora, ru.sitioSalida, ru.sitioLlegada,
                         ru.abreviaturaSalida, ru.abreviaturaLlegada,
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
        $query = "SELECT e.descripcion, e.tipo, e.peso, r.id, r.estado,
                         r.solicitud, p.id, p.nombre, p.apellido, p.cedula,
                         p.pasaporte, p.nacionalidad, p.TIPO_PASAJERO_id, v.id,
                         v.fecha, v.hora, ru.sitioSalida, ru.sitioLlegada,
                         ru.abreviaturaSalida, ru.abreviaturaLlegada,
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
        $query = "SELECT e.descripcion, e.tipo, e.peso, r.id, r.estado,
                         r.solicitud, p.id, p.nombre, p.apellido, p.cedula,
                         p.pasaporte, p.nacionalidad, p.TIPO_PASAJERO_id, v.id,
                         v.fecha, v.hora, ru.sitioSalida, ru.sitioLlegada,
                         ru.abreviaturaSalida, ru.abreviaturaLlegada,
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
 * @param <Integer> $idReserva
 * @return <recurso> descripcion del equipaje
 */
    function consultarEquipajePorPasajeroReserva($idReserva){
        $resultado = false;
        $query = "SELECT e.descripcion descripcion
                  FROM EQUIPAJE e, RESERVA r
                  WHERE r.id = e.RESERVA_id
                  AND r.id = " . $idReserva;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

}
?>
