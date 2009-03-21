<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorEquipajeBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Equipaje.class.php';
/**
 * Description of ControlEquipajeLogicaclass
 * Clase para manejar la logica de los equipajes
 * @author Diana Uribe
 */
class ControlEquipajeLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorEquipajeBDclass();
    }

/**
 * Metodo para agregar un nuevo equipaje a la reserva a la cual pertenece
 * @param <String> $descripcion
 * @param <String> $tipo
 * @param <Integer> $peso
 * @param <Integer> $reservaId
 * @return <boolean> resultado de la operación
 */
    function nuevoEquipajePasajero($descripcion, $tipo, $peso, $reservaId) {
        $equipaje = new Equipajeclass();
        $equipaje->setDescripcion($descripcion);
        $equipaje->setTipo($tipo);
        $equipaje->setPeso($peso);
        $equipaje->setReservaId($reservaId);
        $resultado = $this->controlBD->agregarEquipaje($equipaje);
        return ($resultado);
    }

/**
 * Metodo para actualizar los datos del equipaje
 * @param <String> $descripcion Descripcion del equipaje
 * @param <String> $tipo Tipo del equipaje
 * @param <double> $peso Peso del equipaje
 * @param <Integer> $idReserva Identificador de la reserva a la que pertenece el equipaje
 * @return <boolean> resultado de la operacion
 */
    function actualizarEquipaje($id, $descripcion, $tipo, $peso, $idReserva) {
        $equipaje = new Equipajeclass();
        $equipaje->setId($id);
        $equipaje->setDescripcion($descripcion);
        $equipaje->setTipo($tipo);
        $equipaje->setPeso($peso);
        $equipaje->setReservaId($idReserva);
        $resultado = $this->controlBD->editarEquipaje($equipaje);
        return ($resultado);
    }

/**
 * Metodo para consultar todos los equipajes existentes en el sistema
 * @return <recurso> recurso con todos los equipajes
 */
    function consultarTodosLosEquipajes() {
        $resultado = $this->controlBD->consultarEquipaje();
        return $resultado;
    }
/**
 * Metodo para consultar el equipaje del pasajero según la reserva
 * @param <Integer> $idReserva Identificador de la reserva
 * @return <recurso> recurso descripcion de la reserva
 */
    function buscarEquipajePasajeroPorReserva($idReserva) {
        $resultado = $this->controlBD->consultarEquipajePorPasajeroReserva($idReserva);
        return $resultado;
    }

/**
 * Metodo para consultar el equipaje por un vuelo determinado
 * @param <Integer> $idVuelo Identificador del vuelo
 * @return <recurso> recurso detalles de los equipajes por vuelo
 */
    function equipajePorVuelo($idVuelo) {
        $resultado = $this->controlBD->consultarEquipajePorVuelo($idVuelo);
        return $resultado;
    }

/**
 * Metodo para consultar el equipaje del pasajero
 * @return <recurso> recurso equipaje por pasajero y vuelo
 */
    function equipajeReservaPasajeroVuelo() {
        $resultado = $this->controlBD->consultarEquipajeReservaPasajeroVuelo();
        return $resultado;
    }

/**
 * Metodo para consultar el equipaje de un pasajero por medio de la cedula o pasaporte
 * @param <String, Integer> $cedulaOPasaporte Cedula o pasaporte del pasajero
 * @return <recurso> recurso con el equipaje
 */
    function equipajeDePasajero($cedulaOPasaporte) {
        $resultado = $this->controlBD->consultarEquipajeDePasajero($cedulaOPasaporte);
        return $resultado;
    }
}
?>

