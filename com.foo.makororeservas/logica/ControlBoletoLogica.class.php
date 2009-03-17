<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorBoletoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/DetallesEmitirBoleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/InformacionGeneralBoletoRecibo.class.php';
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
     * Metodo para consultar la cantidad de adultos y niños de la reserva
     * @param <Integer> $idPago
     * @param <String> $tipoPasajero
     * @return <recurso> recurso con la cantidad de adultos o niños
     */
    function consultarCantidadAdultosNinos($solicitud, $tipoPasajero, $tipoVuelo) {
        $resultado = new ArrayObject();
        $resultado = $this->controlBD->cantidadAdultosNinos($solicitud, $tipoPasajero, $tipoVuelo);
        return $resultado;
    }

    /**
     * Metodo para consultar los pasajeros de un boleto especifico
     * @param <Integer> $idPago
     * @return <Coleccion> coleccion de pasajeros
     */
    function buscarPasajerosBoletoEspecifico($solicitud) {
        $resultado = new ArrayObject();
        $recurso = $this->controlBD->consultarPasajeros($solicitud);
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
     * Metodo para consultar la informacion acerca de los pasajeros, servicio, cliente,
     * agente, vuelo. Esta información puede ser utilizada tanto para los recibos de pagos
     * como para los boletos a generar
     * @param <String> $solicitud
     * @return <Coleccion> coleccion con toda loa información necesaria según el
     * identificador de la solicitud
     */
    function informacionGeneralReciboBoleto($solicitud) {
        $coleccionResultado = null;
        $recurso = $this->busquedaBoletoEspecifico($solicitud);
        $cant = mysql_num_rows($recurso);
        $rowRecurso = mysql_fetch_array($recurso);

        $agente = $rowRecurso[agente];
        $numSolicitud = $rowRecurso[solicitud];
        $fechaEmision = date ("Y") ."-".date ("m"). "-".date ("d");
        $servicio = $rowRecurso[nombreServicio];
        $cliente = $rowRecurso[clienteNombre];
        $rifAgencia = $rowRecurso[rifAgencia];
        $particularCedula = $rowRecurso[particularCedula];

        $vueloIdaInfo = $this->controlBD->consultarRutaFechaHoraVuelo($solicitud, "IDA");
        $rowVueloIdaInfo = mysql_fetch_array($vueloIdaInfo);
        $fechaIda = $rowVueloIdaInfo[fecha];
        $horaIda = $rowVueloIdaInfo[hora];
        $salida = $rowVueloIdaInfo[sitioSalida].'-'.$rowVueloIdaInfo[sitioLlegada];

        $vueloVueltaInfo = $this->controlBD->consultarRutaFechaHoraVuelo($solicitud, "VUELTA");
        $rowVueloVueltaInfo = mysql_fetch_array($vueloVueltaInfo);
        $fechaVuelta = $rowVueloVueltaInfo[fecha];
        $horaVuelta = $rowVueloVueltaInfo[hora];
        $retorno = $rowVueloVueltaInfo[sitioSalida].'-'.$rowVueloVueltaInfo[sitioLlegada];

        if($fechaVuelta == ''||$horaVuelta == ''|$retorno==''){
            $fechaVuelta = "XXXX-XX-XX";
            $horaVuelta = "XX:XX";
            $retorno = "No reservado";
        }
        if($rifAgencia == null){
            $identificadorCliente = $particularCedula;
        }
        if($particularCedula == null){
            $identificadorCliente = $rifAgencia;
        }
        $pasajeroInfo = $this->buscarPasajerosBoletoEspecifico($solicitud);
        if ($cant > 0)
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
            $Objeto = new InformacionGeneralBoletoReciboclass($agente, $numSolicitud, $fechaEmision, $fechaIda, $horaIda, $fechaVuelta,
                $horaVuelta, $salida, $retorno, $pasajero, $servicio, $cliente, $identificadorCliente);
            $coleccionResultado ->append($Objeto);
        }
        return $coleccionResultado;
    }

    /**
     * Metodo para consultar los detalles de los boletos como la cantidad de adultos,
     * niños e infantes que hay en la reserva del cliente
     * @param <String> $solicitud
     * @return <Coleccion> coleccion de detalles de la emisión del boleto
     */
    function detallesEmitirBoleto($solicitud) {
        $recursoAdultos = $this->consultarCantidadAdultosNinos($solicitud, "ADL", "IDA");
        $rowCantidadAdultos = mysql_fetch_array($recursoAdultos);
        $cantidadAdultos = $rowCantidadAdultos[cantidad];

        $recursoNinos = $this->consultarCantidadAdultosNinos($solicitud, "CHD", "IDA");
        $rowCantidadNinos = mysql_fetch_array($recursoNinos);
        $cantidadNinos = $rowCantidadNinos[cantidad];

        $recursoInfantes = $this->consultarCantidadAdultosNinos($solicitud, "INF", "IDA");
        $rowCantidadInfantes = mysql_fetch_array($recursoInfantes);
        $cantidadInfantes = $rowCantidadInfantes[cantidad];

        $coleccionResultado = new ArrayObject();
        $Objeto = new DetallesEmitirBoletoclass($cantidadAdultos, $cantidadNinos, $cantidadInfantes);

        $coleccionResultado ->append($Objeto);
        return $coleccionResultado;
    }
}
?>