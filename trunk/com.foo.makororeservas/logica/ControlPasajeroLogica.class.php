<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPasajeroBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';

/**
 * Description of ControlPasajeroLogicaclass
 * Clase para manejar la logica de la gestion de la base de datos
 * @author Diana Uribe
 */
class ControlPasajeroLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorPasajeroBDclass();
    }

/**
 * Metodo para agregar un nuevo pasajero
 * @param <String> $nombre
 * @param <String> $apellido
 * @param <String> $sexo
 * @param <Integer> $cedula
 * @param <String> $pasaporte
 * @param <String> $nacionalidad
 * @param <String> $tipoPasajeroId
 * @return <boolean> resultado de la operacion
 */
    function nuevoPasajero($nombre,$apellido,$sexo,$cedula,$pasaporte,$nacionalidad,$tipoPasajeroId) {
        $pasajero = new Pasajeroclass();
        $pasajero->setNombre($nombre);
        $pasajero->setApellido($apellido);
        $pasajero->setSexo($sexo);
        $pasajero->setCedula($cedula);
        $pasajero->setPasaporte($pasaporte);
        $pasajero->setNacionalidad($nacionalidad);
        $pasajero->setTipoPasajeroId($tipoPasajeroId);
        $resultado = $this->controlBD->agregarPasajero($pasajero);

        return ($resultado);
    }

/**
 * Metodo para actualizar los datos del pasajero
 * @param <String> $nombre
 * @param <String> $apellido
 * @param <Integer> $cedula
 * @param <String> $pasaporte
 * @param <String> $nacionalidad
 * @param <String> $tipoPasajeroId
 * @return <boolean> resultado de la operacion
 */
    function actualizarPasajero($id,$nombre,$apellido,$cedula,$pasaporte,$nacionalidad,$tipoPasajeroId) {
        $pasajero = new Pasajeroclass();
        $pasajero->setId($id);
        $pasajero->setNombre($nombre);
        $pasajero->setApellido($apellido);
        $pasajero->setCedula($cedula);
        $pasajero->setPasaporte($pasaporte);
        $pasajero->setNacionalidad($nacionalidad);
        $pasajero->setTipoPasajeroId($tipoPasajeroId);
        $resultado = $this->controlBD->editarPasajero($pasajero);
        return $resultado;
    }

/**
 * Metodo para consultar los pasajeros de la base de datos
 * @return <recurso> recurso con todos los pasajeros
 */
    function busquedaPasajeros() {
        $recurso = false;
        $recurso = $this->controlBD->consultarPasajeros();
        return $recurso;
    }

/**
 * Metodo para consultar a un pasajero segun la busqueda
 * @param <String, Integer> $busqueda
 * @return <recurso> recurso de un objeto cliente agencia
 */
    function busquedaPasajeroNombreApellidoCedulaPasaporte($busqueda){
        $recurso = false;
        $recurso = $this->controlBD->consultarPasajeroNombreApellidoCedulaPasaporte($busqueda);
        return $recurso;
    }

/**
 * Metodo para consultar los pasajeros que han realizado viajes
 * en un lapso de tiempo determinado
 * @param <Date> $fechaInicio
 * @param <Date> $fechaFin
 * @return <Coleccion> coleccion de los pasajeros
 */
    function busquedaPasajerosConViajesRealizados($fechaini, $fechafin){
        $resultado = false;
        $resultado = $this->controlBD->consultarPasajerosConViajesRealizados($fechaini, $fechafin);
        return $resultado;
    }
}
?>
