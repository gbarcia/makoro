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
     * @param <DATE> $fecha Fecha del nuevo vuelo
     * @param <TIME> $hora Hora del nuevo vuelo
     * @param <STRING> $avionMatricula La matricula del avion que realizara el vuelo
     * @param <STRING> $rutaSitioSalida El sitio de salida del nuevo vuelo
     * @param <STRING> $rutaSitioLlegada El sitio de llegada del nuevo vuelo
     * @return <BOOLEAN> El resultado de la operacion
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
     * @param <INTEGER> $id El id del vuelo a actualizar
     * @param <DATE> $fecha La nueva fecha del vuelo
     * @param <TIME> $hora La neuva hora del vuelo
     * @param <STRING> $avionMatricula La nueva matricula del avion que realizara el vuelo
     * @param <STRING> $rutaSitioSalida El sitio de salida del vuelo
     * @param <STRING> $rutaSitioLlegada El sitio de llegada del vuelo
     * @param <INTEGER> $cantidadInfantes La cantidad de infantes del vuelo
     * @return <BOOLEAN> El resultado de la operacion 
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

    /**
     * Metodo para actualizar la cantidad de infantes en un vuelo 
     * @param <INTEGER> $idVuelo El id del vuelo que se desea actualizar
     * @param <INTEGER> $cantidadInfantes La nueva cantidad de infantes
     * @return <BOOLEAN> El resultado de la operacion
     */
    function actualizarCantidadInfantesVuelo($idVuelo, $cantidadInfantes) {
//        $vuelo = new Vueloclass();
//        $vuelo->setId($idVuelo);
//        $vuelo->setCantidadinfantes($cantidadInfantes);
        $resultado = $this->controlBD->actualizarCantidadInfantesVuelo($idVuelo, $cantidadInfantes);
        return ($resultado);
    }

    /**
     * Metodo para consultar los asientos disponibles
     * @param <INTEGER> $id
     * @return <RECURSO> recurso con la cantidad disponible
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
     * Metodo para consultar la informacion en forma detallada de los vuelos 
     * @param <DATE> $fechaInicio Fecha inicio en la que se quiere realizar la consulta
     * @param <DATE> $fechaFin Fecha fin en la que se quiere realizar la consulta
     * @param <TIME> $hora Hora que se desea consultar
     * @param <STRING> $avionMatricula La matricula del avion que se desea consultar
     * @param <STRING> $rutaSitioSalida La ruta de la que sale el vuelo
     * @param <STRING> $rutaSitioLlegada La ruta a la que llega el vuelo
     * @param <INTEGER> $cantidadAdultosNinos Cantidad de pasajeros adultos y ninos
     * @param <INTEGER> $cantidadInfantes Cantidad de pasajeros infantes
     * @param <STRING> $cedulaPasaporte La cedula o pasaporte del pasajero
     * @param <STRING> $nombrePasajero El nombre del pasajero que se encuentra en el(los) vuelo(s)
     * @param <STRING> $apellidoPasajero El apellido del pasajero que se encuentra en el(los) vuelo(s)
     * @param <INTEGER> $cedulaPart La cedula del cliente particular que compro el(los) vuelo(s)
     * @param <STRING> $nombrePart El nombre del cliente particular que compro el(los) vuelo(s)
     * @param <STRING> $apellidoPart El apellido del cliente particular que compro el(los) vuelo(s)
     * @param <STRING> $rifAgencia El rif del cliente agencia que compro el(los) vuelo(s)
     * @param <STRING> $nombreAgencia El nombre del cliente agencia que compro el(los) vuelo(s)
     * @param <STRING> $solicitud El codigo de solicitud de la(s) reserva(s)
     * @param <STRING> $estado El estado de la reserva
     * @return <COLECCION> Los vuelos que cumplan con los filtros seleccionados
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
            $cantInfantesQuedan = $operacion[infantesQuedan];
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
            $Objeto = new AsientosDisponiblesVueloTripulacionclass($vuelo,$cantidadDisponible,$piloto,$copiloto,$disponibilidadAdulto,$disponibilidadInfante,$idVuelo,$cantInfantes,$cantInfantesQuedan);
            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }

    /**
     * Metodo para consultar informacion  de los vuelos en un intervalo de fecha
     * @param <DATE> $fechaInicio La fecha de inicio a consultar
     * @param <DATE> $fechaFin La fecha de fin a consultar
     * @return <COLECCION> Los vuelos en un intervalo
     */
    function vueloEspecificoSinFiltro($fechaInicio,$fechaFin) {
        $coleccionResultado = new ArrayObject();
        $recurso = $this->controlBD->consultarVueloSinFiltros($fechaInicio,$fechaFin);

        while ($operacion = mysql_fetch_array($recurso)) {
            $cantidadDisponible = $operacion[quedan];
            $disponibilidadAdulto = $operacion[disponibilidadAdulto];
            $disponibilidadInfante = $operacion[disponibilidadInfante];
            $idVuelo = $operacion[idVuelo];
            $cantInfantes = $operacion[infantes];
            $cantInfantesQuedan = $operacion[infantesQuedan];
            $controlVueloPersonal = new controladorVueloPersonalBDclass();
            $vueloTripulacionPiloto = $controlVueloPersonal->consultarVueloPersonalPiloto($idVuelo);
            $vueloTripulacionCopiloto = $controlVueloPersonal->consultarVueloPersonalCopiloto($idVuelo);
            $rowVueloPiloto = mysql_fetch_array($vueloTripulacionPiloto);
            $rowVueloCopiloto = mysql_fetch_array($vueloTripulacionCopiloto);
            $piloto = $rowVueloPiloto[tripulante];
            $copiloto = $rowVueloCopiloto[tripulante];

            if($piloto == ''||$copiloto == ''){
                $piloto = "No asignado";
                $copiloto = "No asignado";
            }

            $vuelo = new Vueloclass();
            $vuelo->setId($operacion[id]);
            $vuelo->setFecha($operacion[fecha]);
            $vuelo->setHora($operacion[hora]);
            $vuelo->setRutaSitioSalida($operacion[abreviaturaSalida]);
            $vuelo->setRutaSitioLlegada($operacion[abreviaturaLlegada]);
            $vuelo->setAvionMatricula($operacion[avionMatricula]);
            $Objeto = new AsientosDisponiblesVueloTripulacionclass($vuelo,$cantidadDisponible,$piloto,$copiloto,$disponibilidadAdulto,$disponibilidadInfante,$idVuelo,$cantInfantes,$cantInfantesQuedan);
            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }

    /**
     * Metodo para consultar los vuelos realizados comparando con la fecha actual
     * @return <COLECCION> coleccion de vuelos pasados
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
     * @return <COLECCION> coleccion vuelo
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
     * @return <COLECCION> coleccion de vuelo
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
     * @return <COLECCION> coleccion de objeto vuelo
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
     * @param <INTEGER> $idVuelo Identificador del vuelo a consultar
     * @param <INTEGER> $idSucursal Identificador de la sucursal a consultar
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
     * Metodo para sumar la hora de vuelos entre dos fechas
     * @param <type> $fechaIni La fecha de inicio a calcular
     * @param <type> $fechaFin La fecha de Fin a calcular
     * @return <type> La cantidad de horas entre estas fechas 
     */
    function sumaHorasDeVuelos($fechaIni,$fechaFin) {
        $recurso = $this->controlBD->consultarHorasDeVuelo($fechaIni,$fechaFin);
        $row = mysql_fetch_array($recurso);
        $horas = $row[horasVuelo];
        $separar = explode('.', $horas);
        $hora = $separar[0];
        $minutos = substr($separar[1],0,2);
        if ($minutos > 60) {
            $minutos = $minutos - 60;
            $hora = $hora + 1;
        }
        $total =' '.$hora.' horas y'.' '.$minutos.' minutos';
        return $total;
    }
}
?>