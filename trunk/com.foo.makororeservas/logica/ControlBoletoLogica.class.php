<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorBoletoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/EmitirBoleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';

/**
 * Description of ControlBoletoLogicaclass
 * Clase para el manejo de la logica de los boletos
 * @author Diana Uribe
 */
class ControlBoletoLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorBoletoBDclass();
    }

/**
 * Metodo para agregar un nuevo boleto
 * @param <Integer> $pagoId
 * @param <Integer> $pasajeroId
 * @return <boolean> resultado de la operacion
 */
    function nuevoBoleto($pagoId, $pasajeroId) {
        $boleto = new Boletoclass();
        $boleto->setPagoId($pagoId);
        $boleto->setPasajeroId($pasajeroId);
        $resultado = $this->controlBD->agregarBoleto($boleto);
        return ($resultado);
    }

/**
 * Metodo para consultar todos los boletos de la base de datos
 * @return <Coleccion> coleccion de boletos de los pasajeros
 */
    function buscarBoletos() {
        $recurso = false;
        $recurso = $this->controlBD->consultarBoletos();
        return $recurso;
    }

/**
 * Metodo para consultar el pago de un boleto especifico de una reserva
 * @param <String> $solicitud
 * @return <recurso> boleto de una reserva en especifico
 */
    function busquedaBoletoEspecifico($solicitud) {
        $resultado = new ArrayObject();
        $resultado = $this->controlBD->consultarBoletoEspecifico($solicitud);
        return $resultado;
    }

/**
 * Metodo para consultar los pasajeros de un boleto especifico
 * @param <Integer> $idPago
 * @return <Coleccion> coleccion de pasajeros
 */
    function buscarPasajerosBoletoEspecifico($idPago) {
        $resultado = new ArrayObject();
        $recurso = $this->controlBD->consultarPasajeros($idPago);
        while ($row = mysql_fetch_array($recurso)) {
            $pasajero = new Pasajeroclass();
            $pasajero->setId($row[idPasajero]);
            $pasajero->setNombre($row[nombre]);
            $pasajero->setApellido($row[apellido]);
            $pasajero->setSexo($row[sexo]);
            $pasajero->setCedula($row[cedula]);
            $pasajero->setPasaporte($row[pasaporte]);
            $pasajero->setNacionalidad($row[nacionalidad]);
            $pasajero->setTipoPasajeroId($row[tipoPasajeroId]);

            $resultado->append($pasajero);
        }
        return $resultado;
    }

/**
 * Metodo para emitir el boleto
 * @param <String> $solicitud
 * @return <Coleccion> informacion de los pasajeros, solicitud, vuelos
 */
    function emitirBoleto($solicitud) {
        $recurso = $this->busquedaBoletoEspecifico($solicitud);
        $rowRecurso = mysql_fetch_array($recurso);

        $idPago = $rowRecurso[idPago];
        $numSolicitud = $rowRecurso[solicitud];
        $agente = $rowRecurso[agente];
        $servicio = $rowRecurso[nombreServicio];
        $cliente = $rowRecurso[clienteNombre];
        $rifAgencia = $rowRecurso[rifAgencia];
        $particularCedula = $rowRecurso[particularCedula];

        if($rifAgencia == null){
        $identificadorCliente = $particularCedula;
        }
        if($particularCedula == null){
        $identificadorCliente = $rifAgencia;
        }
        
        $vueloIdaInfo = $this->controlBD->consultarRutaFechaHoraVuelo($solicitud, "IDA");
        $rowVueloIdaInfo = mysql_fetch_array($vueloIdaInfo);
        $fechaIda = $rowVueloIdaInfo[fecha];
        $horaIda = $rowVueloIdaInfo[hora];
        $lugarSalida = $rowVueloIdaInfo[sitioSalida].'-'.$rowVueloIdaInfo[sitioLlegada];

        $vueloVueltaInfo = $this->controlBD->consultarRutaFechaHoraVuelo($solicitud, "VUELTA");
        $rowVueloVueltaInfo = mysql_fetch_array($vueloVueltaInfo);
        $fechaVuelta = $rowVueloVueltaInfo[fecha];
        $horaVuelta = $rowVueloVueltaInfo[hora];
        $lugarLlegada = $rowVueloVueltaInfo[sitioSalida].'-'.$rowVueloVueltaInfo[sitioLlegada];
        if($fechaVuelta == ''||$horaVuelta == ''|$lugarLlegada==''){
            $fechaVuelta = "No hay fecha de retorno";
            $horaVuelta = "No hay hora de retorno";
            $lugarLlegada = "No hay retorno";
        }
        $fechaEmision = date ("Y") ."-".date ("m"). "-".date ("d");
        $pasajeroInfo = $this->buscarPasajerosBoletoEspecifico($idPago);
        $coleccionResultado = new ArrayObject();
        foreach ($pasajeroInfo as $var) {
            $pasajero = new Pasajeroclass();
            $pasajero->setId($var->getId());
            $pasajero->setNombre($var->getNombre());
            $pasajero->setApellido($var->getApellido());
            $pasajero->setCedula($var->getCedula());
            $pasajero->setPasaporte($var->getPasaporte());
            $pasajero->setNacionalidad($var->getNacionalidad());
            $pasajero->setTipoPasajeroId($var->getTipoPasajeroId());
            $Objeto = new EmitirBoletoclass($agente, $numSolicitud, $fechaEmision, $fechaIda, $horaIda, $fechaVuelta, $horaVuelta, $lugarSalida, $lugarLlegada, $pasajero, $servicio, $cliente, $identificadorCliente);

            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }
}
?>