<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTripulanteBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoCargo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloPersonal.class.php';
/**
 * Description of ControlTripulanteLogicaclass
 *  Manejo de la logica de la gestion de la tripulacion
 * @author Diana Uribe
 */
class ControlTripulanteLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorTripulanteBDclass();
    }

/**
 * Metodo para agregar un nuevo tripulante al sistema
 * @param <Integer> $cedula
 * @param <String> $nombre
 * @param <String> $apellido
 * @param <String> $sexo
 * @param <String> $telefono
 * @param <String> $estado
 * @param <String> $ciudad
 * @param <String> $direccion
 * @param <boolean> $habilitado
 * @param <Integer> $cargo
 * @return <boolean> resultado de la operacion
 */
    function nuevoTripulante($cedula, $nombre, $apellido, $sexo, $telefono, $estado, $ciudad, $direccion, $habilitado, $cargo){
        $tripulante = new Tripulanteclass();
        $tripulante->setCedula($cedula);
        $tripulante->setNombre($nombre);
        $tripulante->setApellido($apellido);
        $tripulante->setSexo($sexo);
        $tripulante->setTelefono($telefono);
        $tripulante->setEstado($estado);
        $tripulante->setCargo($cargo);
        $tripulante->setDireccion($direccion);
        $tripulante->setHabilitado($habilitado);
        $tripulante->setCargo($cargo);
        $resultado = $this->controlBD->agregarPersonal($tripulante);

        return ($resultado);
    }
/**
 * Metodo para actualizar los datos del tripulante
 * @param <String> $nombre
 * @param <String> $apellido
 * @param <String> $sexo
 * @param <String> $telefono
 * @param <String> $estado
 * @param <String> $ciudad
 * @param <String> $direccion
 * @param <boolean> $habilitado
 * @param <Integer> $cargo
 * @return <boolean> resultado de la operacion
 */
    function actualizarTripulante($nombre, $apellido, $sexo, $telefono, $estado, $ciudad, $direccion, $habilitado, $cargo){
        $tripulante = new Tripulanteclass();
        $tripulante->setNombre($nombre);
        $tripulante->setApellido($apellido);
        $tripulante->setSexo($sexo);
        $tripulante->setTelefono($telefono);
        $tripulante->setEstado($estado);
        $tripulante->setCargo($cargo);
        $tripulante->setDireccion($direccion);
        $tripulante->setHabilitado($habilitado);
        $tripulante->setCargo($cargo);
        $resultado = $this->controlBD->editarPersonal($tripulante);

        return ($resultado);
    }
/**
 * Metodo para consultar todos los tripulantes del sistema
 * @return <Coleccion> coleccion de objeto tripulante
 */
    function consultarTodoPersonal(){
        $resultado = new ArrayObject();
        $recurso = $this->controlBD->consultarPersonal();
        while ($row = mysql_fetch_array($recurso)) {
            $tripulante = new Tripulanteclass();
            $tripulante->setCedula($row['cedula']);
            $tripulante->setNombre($row[nombre]);
            $tripulante->setApellido($row[apellido]);
            $tripulante->setSexo($row[sexo]);
            $tripulante->setTelefono($row[telefono]);
            $tripulante->setEstado($row[estado]);
            $tripulante->setCargo($row[cargo]);
            $tripulante->setDireccion($row[direccion]);
            $tripulante->setHabilitado($row[habilitado]);
            $tripulante->setCargo($row[cargo]);

            $resultado->append($tripulante);
        }
        return $resultado;
    }

}
?>
