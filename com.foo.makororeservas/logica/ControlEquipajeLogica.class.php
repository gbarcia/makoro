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
    function actualizarEquipaje($descripcion, $tipo, $peso, $idReserva) {
        $equipaje = new Equipajeclass();
        $equipaje->setDescripcion($descripcion);
        $equipaje->setTipo($tipo);
        $equipaje->setPeso($peso);
        $equipaje->setReservaId($reservaId);
        $resultado = $this->controlBD->editarEquipaje($equipaje);
        return ($resultado);
    }

/**
 * Metodo para consultar el equipaje del pasajero según la reserva
 * @param <Integer> $idReserva Identificador de la reserva
 * @return <recurso> recurso descripcion de la reserva
 */
    function buscarEquipajePasajeroPorReserva($idReserva) {
        $resultado = new ArrayObject();
        $recurso = $this->controlBD->consultarEquipajePorPasajeroReserva($idReserva);
        $row = mysql_fetch_array($recurso);
        $descripcionEquipaje = $row[descripcion];
        return $descripcionEquipaje;
    }


}
?>
