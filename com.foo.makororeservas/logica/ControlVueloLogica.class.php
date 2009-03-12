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
    function actualizarVuelo($id,$fecha,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada,$cantidadInfantes) {
        $vuelo = new Vueloclass();
        $vuelo->setId($id);
        $vuelo->setFecha($fecha);
        $vuelo->setHora($hora);
        $vuelo->setAvionMatricula($avionMatricula);
        $vuelo->setRutaSitioSalida($rutaSitioSalida);
        $vuelo->setRutaSitioLlegada($rutaSitioLlegada);
        $vuelo->setCantidadinfantes($cantidadInfantes);
        $resultado = $this->controlBD->editarVuelo($vuelo);
        return ($resultado);
    }

    function actualizarCantidadInfantesVuelo($idVuelo, $cantidadInfantes) {
        $vuelo = new Vueloclass();
        $vuelo->setId($idVuelo);
        $vuelo->setCantidadinfantes($cantidadInfantes);
        $resultado = $this->controlBD->actualizarCantidadInfantesVuelo($vuelo);
        return ($resultado);
    }

    /**
     * Metodo para consultar los asientos disponibles
     * @param <Integer> $id
     * @return <recurso> recurso con la cantidad disponible
     */
    function calculoAsientosDisponibles($id) {
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
    function vueloEspecificoConFiltro($fechaInicio,$fechaFin,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada,$cantidadAdultosNinos,$cantidadInfantes,$cedulaPasaporte,$nombrePasajero,$apellidoPasajero,$cedulaPart,$nombrePart,$apellidoPart,$rifAgencia,$nombreAgencia,$solicitud,$estado) {
        $coleccionResultado = new ArrayObject();
        $recurso = $this->controlBD->consultarVueloConFiltros($fechaInicio,$fechaFin,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada,$cantidadAdultosNinos,$cantidadInfantes,$cedulaPasaporte,$nombrePasajero,$apellidoPasajero,$cedulaPart,$nombrePart,$apellidoPart,$rifAgencia,$nombreAgencia,$solicitud,$estado);

        while ($operacion = mysql_fetch_array($recurso)) {
            $idVuelo = $operacion[idVuelo];
            $cantidadDisponible = $operacion[quedan];
            $disponibilidadAdulto = $operacion[disponibilidadAdulto];
            $disponibilidadInfante = $operacion[disponibilidadInfante];
            $cantInfantes = $operacion[infantes];
            $controlVueloPersonal = new controladorVueloPersonalBDclass();
            $vueloTripulacionPiloto = $controlVueloPersonal->consultarVueloPersonalPiloto($idVuelo);
            $vueloTripulacionCopiloto = $controlVueloPersonal->consultarVueloPersonalCopiloto($idVuelo);
            $rowVueloPiloto = mysql_fetch_array($vueloTripulacionPiloto);
            $rowVueloCopiloto = mysql_fetch_array($vueloTripulacionCopiloto);
            $piloto = $rowVueloPiloto[tripulante];
            $copiloto = $rowVueloCopiloto[tripulante];

            if($piloto == ''||$copiloto == ''){
                $piloto = "No hay piloto registrado";
                $copiloto = "No hay copiloto registrado";
            }

            $vuelo = new Vueloclass();
            $vuelo->setId($operacion[idVuelo]);
            $vuelo->setFecha($operacion[fecha]);
            $vuelo->setHora($operacion[hora]);
            $vuelo->setRutaSitioSalida($operacion[abreviaturaSalida]);
            $vuelo->setRutaSitioLlegada($operacion[abreviaturaLlegada]);
            $vuelo->setAvionMatricula($operacion[avionMatricula]);
            $Objeto = new AsientosDisponiblesVueloTripulacionclass($vuelo,$cantidadDisponible,$piloto,$copiloto,$disponibilidadAdulto,$disponibilidadInfante,$idVuelo,$cantInfantes);
            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }

    /**
     * Metodo para consultar informacion  de los vuelos en un intervalo de fecha
     * @param <type> $fechaInicio La fecha de inicio a consultar
     * @param <type> $fechaFin La fecha de fin a consultar
     * @return <type> Los vuelos en un intervalo
     */
    function vueloEspecificoSinFiltro($fechaInicio,$fechaFin) {
        $coleccionResultado = new ArrayObject();
        $recurso = $this->controlBD->consultarVueloSinFiltros($fechaInicio,$fechaFin);

        while ($operacion = mysql_fetch_array($recurso)) {
            $cantidadDisponible = $operacion[quedan];
            $disponibilidad = $operacion[disponibilidad];
            $idVuelo = $operacion[idVuelo];
            $controlVueloPersonal = new controladorVueloPersonalBDclass();
            $vueloTripulacionPiloto = $controlVueloPersonal->consultarVueloPersonalPiloto($idVuelo);
            $vueloTripulacionCopiloto = $controlVueloPersonal->consultarVueloPersonalCopiloto($idVuelo);
            $rowVueloPiloto = mysql_fetch_array($vueloTripulacionPiloto);
            $rowVueloCopiloto = mysql_fetch_array($vueloTripulacionCopiloto);
            $piloto = $rowVueloPiloto[tripulante];
            $copiloto = $rowVueloCopiloto[tripulante];

            if($piloto == ''||$copiloto == ''){
                $piloto = "No hay piloto registrado";
                $copiloto = "No hay copiloto registrado";
            }

            $vuelo = new Vueloclass();
            $vuelo->setId($operacion[id]);
            $vuelo->setFecha($operacion[fecha]);
            $vuelo->setHora($operacion[hora]);
            $vuelo->setRutaSitioSalida($operacion[abreviaturaSalida]);
            $vuelo->setRutaSitioLlegada($operacion[abreviaturaLlegada]);
            $vuelo->setAvionMatricula($operacion[avionMatricula]);
            $Objeto = new AsientosDisponiblesVueloTripulacionclass($vuelo,$cantidadDisponible,$piloto,$copiloto,$disponibilidad,$idVuelo);
            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }

    /**
     * Metodo para consultar los vuelos realizados comparando con la fecha actual
     * @return <$coleccion> coleccion de vuelos pasados
     */
    function buscarVuelosRealizados() {
        $resultado = new ArrayObject();
        $recurso = $this->controlBD->consultarVuelosRealizados();
        while ($row = mysql_fetch_array($recurso)) {
            $vuelo = new Vueloclass();
            $vuelo->setId($row[id]);
            $vuelo->setFecha($row[fecha]);
            $vuelo->setHora($row[hora]);
            $vuelo->setRutaSitioSalida($row[abreviaturaSalida]);
            $vuelo->setRutaSitioLLegada($row[abreviaturaLlegada]);
            $vuelo->setAvionMatricula($row[avionMatricula]);
            $vuelo->setAsientos($row[asientos]);

            $resultado->append($vuelo);
        }
        return $resultado;
    }

    /**
     * Metodo para consultar los vuelos realizados con los piloto, copilotos y
     * asientos que fueron reservados
     * @return <Coleccion> coleccion vuelo
     */
    function vuelosRealizados() {
        $recurso = $this->buscarVuelosRealizados();
        $coleccionResultado = new ArrayObject();

        foreach ($recurso as $variable) {
            $idVuelo = $variable->getId();
            $recursoInfo = $this->controlBD->consultarVueloCantidadReserva($idVuelo);
            $row = mysql_fetch_array($recursoInfo);
            $cantidadReservada = $row[cantidadReservada];

            $controlVueloPersonal = new controladorVueloPersonalBDclass();
            $vueloTripulacionPiloto = $controlVueloPersonal->consultarVueloPersonalPiloto($idVuelo);
            $vueloTripulacionCopiloto = $controlVueloPersonal->consultarVueloPersonalCopiloto($idVuelo);
            $rowVueloPiloto = mysql_fetch_array($vueloTripulacionPiloto);
            $rowVueloCopiloto = mysql_fetch_array($vueloTripulacionCopiloto);
            $piloto = $rowVueloPiloto[tripulante];
            $copiloto = $rowVueloCopiloto[tripulante];

            $vuelo = new Vueloclass();
            $vuelo->setId($variable->getId());
            $vuelo->setFecha($variable->getFecha());
            $vuelo->setHora($variable->getHora());
            $vuelo->setRutaSitioSalida($variable->getRutaSitioSalida());
            $vuelo->setRutaSitioLlegada($variable->getRutaSitioLLegada());
            $vuelo->setAvionMatricula($variable->getAvionMatricula());
            $Objeto = new AsientosDisponiblesVueloTripulacionclass($vuelo,$cantidadReservada,$piloto,$copiloto);

            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }

    /**
     * Metodo para consultar todos los vuelos para las fechas siguientes
     * @return <Coleccion> coleccion de vuelo
     */
    function consultarLosVuelos(){
        $resultado = new ArrayObject();
        $recurso = $this->controlBD->consultarTodosVuelos();
        while ($row = mysql_fetch_array($recurso)) {
            $vuelo = new Vueloclass();
            $vuelo->setId($row[id]);
            $vuelo->setFecha($row[fecha]);
            $vuelo->setHora($row[hora]);
            $vuelo->setRutaSitioSalida($row[abreviaturaSalida]);
            $vuelo->setRutaSitioLLegada($row[abreviaturaLlegada]);
            $vuelo->setAvionMatricula($row[avionMatricula]);
            $vuelo->setAsientos($row[asientos]);

            $resultado->append($vuelo);
        }
        return $resultado;
    }

    /**
     * Metodo para consultar la cantidad de asientos disponibles para las siguientes
     * fechas con el piloto, copiloto y la cantidad de asientos disponibles
     * @return <Coleccion> coleccion de objeto vuelo
     */
    function vuelosCantidadAsientosDisponibles() {
        $recurso = $this->consultarLosVuelos();
        $coleccionResultado = new ArrayObject();

        foreach ($recurso as $variable) {

            $idVuelo = $variable->getId();
            $cantidadDisponible = $this->calculoAsientosDisponibles($idVuelo);
            if ($cantidadDisponible == 0){
                $cantidadDisponible = $variable->getAsientos();
            }
            $controlVueloPersonal = new controladorVueloPersonalBDclass();
            $vueloTripulacionPiloto = $controlVueloPersonal->consultarVueloPersonalPiloto($idVuelo);
            $vueloTripulacionCopiloto = $controlVueloPersonal->consultarVueloPersonalCopiloto($idVuelo);
            $rowVueloPiloto = mysql_fetch_array($vueloTripulacionPiloto);
            $rowVueloCopiloto = mysql_fetch_array($vueloTripulacionCopiloto);
            $piloto = $rowVueloPiloto[tripulante];
            $copiloto = $rowVueloCopiloto[tripulante];

            if($piloto == ''||$copiloto == ''){
                $piloto = "No hay piloto registrado";
                $copiloto = "No hay copiloto registrado";
            }

            $vuelo = new Vueloclass();
            $vuelo->setId($variable->getId());
            $vuelo->setFecha($variable->getFecha());
            $vuelo->setHora($variable->getHora());
            $vuelo->setRutaSitioSalida($variable->getRutaSitioSalida());
            $vuelo->setRutaSitioLlegada($variable->getRutaSitioLLegada());
            $vuelo->setAvionMatricula($variable->getAvionMatricula());
            $Objeto = new AsientosDisponiblesVueloTripulacionclass($vuelo,$cantidadDisponible,$piloto,$copiloto);

            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }

    /**
     * Metodo para consultar los detalles de un vuelo especifico
     * @param <type> $idVuelo Identificador del vuelo a consultar
     * @param <type> $idSucursal Identificador de la sucursal a consultar
     * @return <type> Los detalles del vuelo especificado
     */
    function consultarVuelosDetalles($idVuelo){
        $recurso = $this->controlBD->consultarDetallesVuelo($idVuelo);
        return $recurso;
    }

    /**
     * Metodo para consultar los clientes con mas vuelos
     * @param <type> $idSucursal El id de la sucursal a consultar
     * @param <type> $fechaInicio La fecha de inicio a consultar
     * @param <type> $fechaFin La fecha de fin a consultar
     * @return <type> Los clientes con mas vuelos pagados
     */
    function consultarClientesMasVuelos($idSucursal,$fechaInicio,$fechaFin){
        $recurso = $this->controlBD->consultarClienteConMasVuelos($idSucursal, $fechaInicio, $fechaFin);
        return $recurso;
    }

    /**
     * Metodo para consultar los vuelos por busqueda y fecha
     * @param <String> $busqueda Parametro con la busqueda determinada
     * @return <recurso> recurso con el vuelo especificado
     */
    function buscarVuelosPorFechaRutas($busqueda) {
        $recurso = $this->controlBD->consultarTodosVuelosPorFechaRutas($busqueda);
        return $recurso;
    }

/**
 * Metodo para consultar la cantidad de infantes en un vuelo
 * @param <Integer> $idVuelo Identificador del vuelo
 * @return <recurso> recurso con la cantidad de infantes en el vuelo
 */
    function consultarCantidadInfantesVuelo($idVuelo) {
        $recurso = $this->controlBD->consultarCantidadInfantesVuelo($idVuelo);
        return $recurso;
    }

/**
 * Metodo para saber la cantidad de horas de vuelo
 */
    function sumaHorasDeVuelos() {
        $recurso = $this->controlBD->consultarHorasDeVuelo();
        $row = mysql_fetch_array($recurso);
        $horas = $row[horasVuelo];
        $separar = explode('.', $horas);
        $hora = $separar[0];
        $minutos = substr($separar[1],0,2);
        if ($minutos > 60) {
            $minutos = $minutos - 60;
            $hora = $hora + 1;
        }
        $total = (round($horas,2)).' '.'='.' '.$hora.' horas y'.' '.$minutos.' minutos';
        return $total;
    }
}
?>
