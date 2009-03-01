<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloPersonalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/AsientosDisponiblesVueloTripulacion.class.php';
/**
 * Description of ControlVueloLogicaclass
 * Clase para manejar la logica de los vuelos
 * @author Diana Uribe
 */
class ControlVueloLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorVueloBDclass();
    }

/**
 * Metodo para agregar un nuevo vuelo
 * @param <Date> $fecha
 * @param <Date> $hora
 * @param <String> $avionMatricula
 * @param <String> $rutaSitioSalida
 * @param <String> $rutaSitioLlegada
 * @return <boolean>
 */
    function nuevoVuelo($fecha,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada) {
        $vuelo = new Vueloclass();
        $vuelo->setFecha($fecha);
        $vuelo->setHora($hora);
        $vuelo->setAvionMatricula($avionMatricula);
        $vuelo->setRutaSitioSalida($rutaSitioSalida);
        $vuelo->setRutaSitioLlegada($rutaSitioLlegada);
        $resultado = $this->controlBD->agregarNuevoVuelo($vuelo);
        return ($resultado);
    }

/**
 * Metodo para actualizar los datos de un vuelo
 * @param <Date> $fecha
 * @param <Date> $hora
 * @param <String> $avionMatricula
 * @return <boolean>
 */
    function actualizarVuelo($id,$fecha,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada) {
        $vuelo = new Vueloclass();
        $vuelo->setId($id);
        $vuelo->setFecha($fecha);
        $vuelo->setHora($hora);
        $vuelo->setAvionMatricula($avionMatricula);
        $vuelo->setRutaSitioSalida($rutaSitioSalida);
        $vuelo->setRutaSitioLlegada($rutaSitioLlegada);
        $resultado = $this->controlBD->editarVuelo($vuelo);
        return ($resultado);
    }

/**
 * Metodo para consultar los asientos disponibles
 * @param <Integer> $id
 * @return <recurso> recurso con la cantidad disponible
 */
    function calculoAsientosDisponibles($id) {
        $resultado = false;
        $recurso = $this->controlBD->consultarVueloCantidadReserva($id);
        $row = mysql_fetch_array($recurso);
        $cantidadAvion = $row[asientos];
        $cantidadReservada = $row[cantidadReservada];
        $cantidadDisponible = $cantidadAvion - $cantidadReservada;
        return $cantidadDisponible;
    }

/**
 * Metodo para consultar los asientos disponibles, el piloto y el copiloto
 * del vuelo consultado
 * @param <Date> $hora
 * @param <Date> $fecha
 * @param <String> $rutaSitioSalida
 * @param <String> $rutaSitioLlegada
 * @param <String> $avionMatricula
 * @return <Coleccion> coleccion de vuelo con los asientos y la tripulacion
 */
    function vueloEspecificoAsientosReservados($fecha,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada) {
        $coleccionResultado = new ArrayObject();
        $recurso = $this->controlBD->consultarVuelo($fecha,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada);
        $operacion = mysql_fetch_array($recurso);
        $idVuelo = $operacion[id];
        $cantidadDisponible = $this->calculoAsientosDisponibles($idVuelo);

        $controlVueloPersonal = new controladorVueloPersonalBDclass();
        $vueloTripulacionPiloto = $controlVueloPersonal->consultarVueloPersonalPiloto($idVuelo);
        $vueloTripulacionCopiloto = $controlVueloPersonal->consultarVueloPersonalCopiloto($idVuelo);
        $rowVueloPiloto = mysql_fetch_array($vueloTripulacionPiloto);
        $rowVueloCopiloto = mysql_fetch_array($vueloTripulacionCopiloto);
        $piloto = $rowVueloPiloto[tripulante];
        $copiloto = $rowVueloCopiloto[tripulante];

        $vuelo = new Vueloclass();
        $vuelo->setId($operacion[id]);
        $vuelo->setFecha($operacion[fecha]);
        $vuelo->setHora($operacion[hora]);
        $vuelo->setRutaSitioSalida($operacion[rutaSitioSalida]);
        $vuelo->setRutaSitioLlegada($operacion[rutaSitioLlegada]);
        $vuelo->setAvionMatricula($operacion[avionMatricula]);
        $Objeto = new AsientosDisponiblesVueloTripulacionclass($vuelo,$cantidadDisponible,$piloto,$copiloto);
        $coleccionResultado ->append($Objeto);
        return $coleccionResultado;
    }


    function vuelosRealizados() {
        $coleccion = $this->controlBD->consultarVuelosRealizados();
        $resultado = new ArrayObject();
        foreach ($coleccion as $var) {
            
            $piloto = $this->controlBD->consultarTripulantesVuelosRealizados($var[id],1);
            $copiloto = $this->controlBD->consultarTripulantesVuelosRealizados($var[id],1);

            $operacionInfo = mysql_fetch_array($recursoInfo);
            $tripulante = new Tripulanteclass ();
            if ($total != 0) {
                $tripulante->setCedula ($operacionInfo[cedula]);
                $tripulante->setNombre($operacionInfo[nombre]);
                $tripulante->setApellido($operacionInfo[apellido]);
                $tripulante->setCargo ($operacionInfo[cargo]);
                $tripulante->setSueldo($operacionInfo[sueldo]);
                $Objeto = new PagoNominaTripulacionclass($recurso,$total,$tripulante);
                $resultado ->append($Objeto);
            }
        }
         return $coleccionResultado;
    }
}
?>
