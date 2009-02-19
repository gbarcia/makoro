<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTripulanteBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoCargo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloPersonal.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoCargoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/PagoNominaTripulacion.class.php';
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
 * @param <Integer> $cargo
 * @return <boolean> resultado de la operacion
 */
    function nuevoTripulante($cedula, $nombre, $apellido, $sexo, $telefono, $estado, $ciudad, $direccion,$cargo){
        $tripulante = new Tripulanteclass();
        $tripulante->setCedula($cedula);
        $tripulante->setNombre($nombre);
        $tripulante->setApellido($apellido);
        $tripulante->setSexo($sexo);
        $tripulante->setTelefono($telefono);
        $tripulante->setEstado($estado);
        $tripulante->setCiudad($ciudad);
        $tripulante->setCargo($cargo);
        $tripulante->setDireccion($direccion);
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
    function actualizarTripulante($cedula, $nombre, $apellido, $sexo, $telefono, $estado, $ciudad, $direccion, $habilitado, $cargo){
        $tripulante = new Tripulanteclass();
        $tripulante->setCedula($cedula);
        $tripulante->setNombre($nombre);
        $tripulante->setApellido($apellido);
        $tripulante->setSexo($sexo);
        $tripulante->setTelefono($telefono);
        $tripulante->setEstado($estado);
        $tripulante->setCiudad($ciudad);
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
            $tripulante->setCiudad($row[ciudad]);
            $tripulante->setDireccion($row[direccion]);
            $tripulante->setHabilitado($row[habilitado]);
            $tripulante->setCargo($row[cargo]);
            $tripulante->setSueldo($row[sueldo]);

            $resultado->append($tripulante);
        }
        return $resultado;
    }
/**
 * Metodo para consultar el detalle del pago de los tripulantes
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @param <Integer> $cedula
 * @return <recurso> recurso de objeto tripulante con el detalle del pago
 */
    function consultarDetallePago($fechaini, $fechafin, $cedula){
        $recurso = false;
        $recurso = $this->controlBD->consultarDetallesPagoPersonal($fechaini, $fechafin, $cedula);
        return $recurso;
    }
/**
 * Metodo para consultar a un tripulante segun busqueda
 * @param <String, Integer> $busqueda
 * @return <recurso> recurso de objeto tripulante
 */
    function consultarTripulanteCedulaNombreApellido($busqueda){
        $recurso = false;
        $recurso = $this->controlBD->consultarPersonaCedulaNombreApellido($busqueda);
        return $recurso;
    }
/**
 * Metodo para consultar el pago total del tripulante
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @param <Integer> $cedula
 * @return <total> suma total del pago tripulante
 */
    function consultarMontoTotal($fechaini, $fechafin, $cedula){
        $controlTipoCargo = new controladorTipoCargoBDclass();
        $tarifaPiloto = $controlTipoCargo->obtenerSueldoTipoCargo(1);
        $tarifaCopiloto = $controlTipoCargo->obtenerSueldoTipoCargo(2);
        $SumaPiloto = $this->controlBD->consultarTotalPagoPersonal($fechaini, $fechafin, $cedula, 1, $tarifaPiloto);
        $SumaCopiloto = $this->controlBD->consultarTotalPagoPersonal($fechaini, $fechafin, $cedula, 2, $tarifaCopiloto);
        $total = $SumaPiloto + $SumaCopiloto;
        return (round($total, 2));
    }

/**
 * Metodo para consultar todos los tripulantes con el pago total, segun sus rutas
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @return <Coleccion> coleccion de tripulantes con los detalles y pago
 */
    function consultarSueldoNominaTripulantesDetalles ($fechaini, $fechafin){
        $coleccionPersonal = $this->consultarTodoPersonal();
        $coleccionResultado = new ArrayObject();
        foreach ($coleccionPersonal as $var) {
            $recurso = $this->consultarDetallePago($fechaini, $fechafin, $var->getCedula());
            $total   = $this->consultarMontoTotal($fechaini, $fechafin, $var->getCedula());
            $recursoInfo = $this->controlBD->consultarPersonalCedula($var->getCedula());
            $operacionInfo = mysql_fetch_array($recursoInfo);
            $tripulante = new Tripulanteclass ();
            if ($total != 0) {
                $tripulante->setCedula ($operacionInfo[cedula]);
                $tripulante->setNombre($operacionInfo[nombre]);
                $tripulante->setApellido($operacionInfo[apellido]);
                $tripulante->setCargo ($operacionInfo[cargo]);
                $tripulante->setSueldo($operacionInfo[sueldo]);
                $Objeto = new PagoNominaTripulacionclass($recurso,$total, $tripulante);
                $coleccionResultado ->append($Objeto);
            }
        }

        return $coleccionResultado;
    }
}
?>
