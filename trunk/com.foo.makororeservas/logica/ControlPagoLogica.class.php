<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPagoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorBoletoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlBoletoLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';
/**
 * Description of ControlPagoLogicaclass
 * Clase para manejar la logica de la gestion de la base de datos
 * @author Diana Uribe
 */
class ControlPagoLogicaclass {
    private $controlPagoBD;

    function __construct() {
        $this->controlPagoBD = new controladorPagoBDclass();
        $this->controlBoletoBD = new controladorBoletoBDclass();
        $this->controlBoletoLogica = new ControlBoletoLogicaclass();
        $this->controlReservaBD = new controladorReservaBDclass();
    }

    /**
     * Metodo para agregar un nuevo pago
     * @param <String> $tipo Tipo de pago insertar
     * @param <double> $monto El monto total del pago
     * @param <String> $nombreBanco El nombre del banco
     * @param <Integer> $numeroTransaccion El numero de la transaccion
     * @param <Integer> $monedaId El identificador de la moneda
     * @return <boolean> Resultado de la operacion
     */
    function nuevoPago($tipo,$monto,$nombreBanco,$numeroTransaccion,$monedaId) {
        $pago = new Pagoclass();
        $pago->setTipo($tipo);
        $pago->setMonto($monto);
        $pago->setNombreBanco($nombreBanco);
        $pago->setNumeroTransaccion($numeroTransaccion);
        $pago->setMonedaId($monedaId);
        $resultado = $this->controlPagoBD->agregarPago($pago);

        return ($resultado);
    }

    /**
     * Metodo para actulizar los datos del pago
     * @param <Integer> $id El identificador del pago a editar
     * @param <String> $tipo El tipo de pago que se desea modificar
     * @param <double> $monto El monto del pago que se desea modificar
     * @param <String> $nombreBanco El nombre del banco que se desea modificar 
     * @param <Integer> $numeroTransaccion El numero de transaccion que se desea modificar
     * @param <Integer> $monedaId El id de la moneda que se desea modificar
     * @return <boolean> El resultado de la operacion 
     */
    function actualizarPago($id,$tipo,$monto,$nombreBanco,$numeroTransaccion,$monedaId) {
        $pago = new Pagoclass();
        $pago->setId($id);
        $pago->setTipo($tipo);
        $pago->setMonto($monto);
        $pago->setNombreBanco($nombreBanco);
        $pago->setNumeroTransaccion($numeroTransaccion);
        $pago->setMonedaId($monedaId);
        $resultado = $this->controlPagoBD->editarPago($pago);
        return $resultado;
    }

    /**
     * Metodo para consultar todos los pagos
     * @return <recurso>
     */
    function buscarPagos() {
        $recurso = false;
        $recurso = $this->controlPagoBD->consultarPagos();
        return $recurso;
    }

    /**
     * Metodo para consultar la cantidad de adultos y niños que van a viajar
     * @param <String> $solicitud El numero de solicitud a consultar
     * @param <String> $tipoPasajero El tipo de pasajero a consultar
     * @param <String> $tipoVuelo El tipo de vuelo a consultar 
     * @return <recurso> La cantidad de adultos y niños que van a viajar 
     */
    function consultarCantidadAdultosNinosPorSolicitud($solicitud, $tipoPasajero, $tipoVuelo) {
        $resultado = new ArrayObject();
        $resultado = $this->controlPagoBD->cantidadAdultosNinosPorSolicitud($solicitud, $tipoPasajero, $tipoVuelo);
        return $resultado;
    }

    /**
     * Metodo para calcular el subtotal del pasaje de salida de los adultos
     * @param <Integer> $cantidadAdultos La cantidad de adultos a calcular
     * @param <double> $costoSalida El costo del pasaje salida de los adultos
     * @return <recurso> Subtotal del pasaje de salida de los adultos 
     */
    function calculoSubtotalPasajeAdultosSalida($cantidadAdultos, $costoSalida) {
        $subtotalAdultosSalida = false;
        $subtotalAdultosSalida = $cantidadAdultos*$costoSalida;
        return $subtotalAdultosSalida;
    }

    /**
     * Metodo para calcular el subtotal del pasaje de retorno de los adultos
     * @param <Integer> $cantidadAdultos La cantidad de adultos a calcular
     * @param <double> $costoLlegada El costo del pasaje llegada de los adultos
     * @return <recurso> Subtotal del pasaje de retorno de los adultos
     */
    function calculoSubtotalPasajeAdultosLlegada($cantidadAdultos, $costoLlegada) {
        $subtotalAdultosLlegada = false;
        $subtotalAdultosLlegada = $cantidadAdultos*$costoLlegada;
        return $subtotalAdultosLlegada;
    }

    /**
     * Metodo para calcular el subtotal del pasaje de salida de los niños con el descuento
     * @param <Integer> $cantidadNinos La cantidad de ninos a calcular
     * @param <double> $costoSalida El costo del pasaje llegada de los ninos
     * @param <double> $descuentoNinos El descuento para ninos
     * @return <recurso> Subtotal del pasaje de salida de los niños
     */
    function calculoSubtotalPasajeNinosSalida($cantidadNinos, $costoSalida, $descuentoNinos) {
        $subtotalNinosSalida = false;
        $descuentoPasajeNino = $descuentoNinos*$costoSalida;
        $costoPasajeNino = $costoSalida - $descuentoPasajeNino;
        $subtotalNinosSalida = $cantidadNinos*$costoPasajeNino;
        return $subtotalNinosSalida;
    }

    /**
     * Metodo para calcular el costo del pasaje de salida de los niños con el descuento
     * @param <double> $costoSalida El costo del pasaje salida de los ninos
     * @param <double> $descuentoNinos El descuento para ninos
     * @return <recurso> Costo del pasaje de salida de los niños
     */
    function calculoCostoPasajeNinosSalida($costoSalida, $descuentoNinos) {
        $costoPasajeNinoSalida = false;
        $descuentoPasajeNino = $descuentoNinos*$costoSalida;
        $costoPasajeNinoSalida = $costoSalida - $descuentoPasajeNino;
        return $costoPasajeNinoSalida;
    }

    /**
     * Metodo para calcular el subtotal del pasaje de retorno de los niños con el descuento
     * @param <Integer> $cantidadNinos La cantidad de ninos a calcular
     * @param <double> $costoLlegada El costo del pasaje llegada de los ninos
     * @param <double> $descuentoNinos El descuento para ninos
     * @return <recurso> Subtotal del pasaje de retorno de los niños
     */
    function calculoSubtotalPasajeNinosLlegada($cantidadNinos, $costoLlegada, $descuentoNinos) {
        $subtotalNinosLlegada = false;
        $descuentoPasajeNino = $descuentoNinos*$costoLlegada;
        $costoPasajeNino = $costoLlegada - $descuentoPasajeNino;
        $subtotalNinosLlegada = $cantidadNinos*$costoPasajeNino;
        return $subtotalNinosLlegada;
    }

    /**
     * Metodo para calcular el costo del pasaje de retorno de los niños con el descuento
     * @param <double> $costoLlegada El costo del pasaje llegada de los ninos
     * @param <double> $descuentoNinos El descuento para ninos
     * @return <recurso> Costo del pasaje de retorno de los niños 
     */
    function calculoCostoPasajeNinosLlegada($costoLlegada, $descuentoNinos) {
        $costoPasajeNinoLlegada = false;
        $descuentoPasajeNino = $descuentoNinos*$costoLlegada;
        $costoPasajeNinoLlegada = $costoLlegada - $descuentoPasajeNino;
        return $costoPasajeNinoLlegada;
    }

    /**
     * Metodo para consultar si la agencia tiene comisión, es decir algún tipo de descuento 
     * @param <double> $porcentajeComision El porcentaje comision de la agencia 
     * @param <double> $totalApagar El total a pagar
     * @return <recurso> La comision de la agencia
     */
    function buscarComisionAgencia($porcentajeComision, $totalApagar) {
        $comisionTotal = $totalApagar*$porcentajeComision;
        return $comisionTotal;
    }


    /**
     * Metodo para consultar los detalles del recibo de pago. Informacion acerca de:
     * costo del pasaje de ida y vuelta, si el vuelo genera iva de ida o de vuelta,
     * cantidad de adultos, niños e infantes que van a viajar, subtotales, descuentos
     * y total a pagar. 
     * @param <String> $solicitud El numero de solicitud
     * @return <Coleccion> Coleccion con los detalles del recibo de pago
     */
    function detallesReciboDePago($solicitud) {
        $recurso = $this->controlBoletoLogica->busquedaBoletoEspecifico($solicitud);
        $rowRecurso = mysql_fetch_array($recurso);

        $rifAgencia = $rowRecurso[rifAgencia];
        $particularCedula = $rowRecurso[particularCedula];
        $vueloIdaInfo = $this->controlBoletoBD->consultarRutaFechaHoraVuelo($solicitud, "IDA");
        $rowVueloIdaInfo = mysql_fetch_array($vueloIdaInfo);
        $costoSalida = $rowVueloIdaInfo[costoRuta];
        $generaIvaSalida = $rowVueloIdaInfo[generaIva];

        $vueloVueltaInfo = $this->controlBoletoBD->consultarRutaFechaHoraVuelo($solicitud, "VUELTA");
        $rowVueloVueltaInfo = mysql_fetch_array($vueloVueltaInfo);
        $costoLlegada = $rowVueloVueltaInfo[costoRuta];
        if ($costoSalida == ''){
            $costoSalida = 0;
        }
         if ($costoLlegada == ''){
            $costoLlegada = 0;
        }
        $generaIvaLlegada = $rowVueloVueltaInfo[generaIva];

        $adultosSalida = $this->controlPagoBD->cantidadAdultosNinosPorSolicitud($solicitud, "ADL", "IDA");
        $rowCantidadAdultosSalida = mysql_fetch_array($adultosSalida);
        $cantidadAdultosSalida = $rowCantidadAdultosSalida[cantidad];
        $subtotalAdultosSalida = $this->calculoSubtotalPasajeAdultosSalida($cantidadAdultosSalida, $costoSalida);

        $adultosLlegada = $this->controlPagoBD->cantidadAdultosNinosPorSolicitud($solicitud, "ADL", "VUELTA");
        $rowCantidadAdultosLlegada = mysql_fetch_array($adultosLlegada);
        $cantidadAdultosLlegada = $rowCantidadAdultosLlegada[cantidad];
        $subtotalAdultosLlegada = $this->calculoSubtotalPasajeAdultosLlegada($cantidadAdultosLlegada, $costoLlegada);
        $subtotalAdultos = $subtotalAdultosSalida + $subtotalAdultosLlegada;

        $infantes = $this->controlBoletoBD->cantidadAdultosNinos($solicitud, "INF", "IDA");
        $rowCantidadInfantes = mysql_fetch_array($infantes);
        $cantidadInfantes = $rowCantidadInfantes[cantidad];

        $ninosSalida = $this->controlPagoBD->cantidadAdultosNinosPorSolicitud($solicitud, "CHD", "IDA");
        $rowCantidadNinosSalida = mysql_fetch_array($ninosSalida);
        $cantidadNinosSalida = $rowCantidadNinosSalida[cantidad];
        $descuentoNinos = $rowCantidadNinosSalida[descuento];
        $costoPasajeNinosSalida = 0;
        $subtotalNinosSalida = $this->calculoSubtotalPasajeNinosSalida($cantidadNinosSalida, $costoSalida, $descuentoNinos);

        $ninosLlegada = $this->controlPagoBD->cantidadAdultosNinosPorSolicitud($solicitud, "CHD", "VUELTA");
        $rowCantidadNinosLlegada = mysql_fetch_array($ninosLlegada);
        $cantidadNinosLlegada = $rowCantidadNinosLlegada[cantidad];
        $costoPasajeNinosLlegada = 0;
        $subtotalNinosLlegada = $this->calculoSubtotalPasajeNinosLlegada($cantidadNinosLlegada, $costoLlegada, $descuentoNinos);

        if($cantidadNinosSalida>0){
            $costoPasajeNinosSalida = $this->calculoCostoPasajeNinosSalida($costoSalida, $descuentoNinos);
        }
        if($cantidadNinosLlegada>0){
            $costoPasajeNinosLlegada = $this->calculoCostoPasajeNinosLlegada($costoLlegada, $descuentoNinos);
        }

        $subtotalNinos = $subtotalNinosSalida + $subtotalNinosLlegada;
        $subtotalAdultosNinos = $subtotalAdultos + $subtotalNinos;

        if ($generaIvaSalida == 1){
            $porcentajeIvaSalida = 0.08*$subtotalAdultosNinos;
        }else{
            if ($generaIvaSalida == 0){
                $porcentajeIvaSalida = 0;
            }
        }
        
        if ($generaIvaLlegada == 1){
            $porcentajeIvaLlegada = 0.08*$subtotalAdultosNinos;
        }else{
            if ($generaIvaLlegada == 0){
                $porcentajeIvaLlegada = 0;
            }
        }
        $comisionAgencia = 0;
        $totalApagar = $subtotalAdultosNinos + $porcentajeIvaSalida + $porcentajeIvaLlegada;

        $porcentajeComisionAgencia = 0;
        if($rifAgencia == null){
            $identificadorCliente = $particularCedula;
        }else{
            $porcentajeComisionAgencia = $rowRecurso[porcentajeComision];
            $comisionAgencia = $this->buscarComisionAgencia($porcentajeComisionAgencia,$totalApagar);
            $totalApagar = $totalApagar - $comisionAgencia;
        }
        if($particularCedula == null){
            $identificadorCliente = $rifAgencia;
        }
        $coleccionResultado = new ArrayObject();
        $Objeto = new DetallesReciboDePagoclass($cantidadAdultosSalida, $cantidadAdultosLlegada,
                                                $cantidadNinosSalida, $cantidadNinosLlegada, $cantidadInfantes,
                                                $costoSalida, $costoPasajeNinosSalida, $costoLlegada,
                                                $costoPasajeNinosLlegada, $subtotalAdultosSalida, $subtotalAdultosLlegada,
                                                $subtotalNinosSalida, $subtotalNinosLlegada, $subtotalAdultosNinos, $porcentajeIvaSalida,
                                                $porcentajeIvaLlegada, $comisionAgencia, $totalApagar);
        $coleccionResultado ->append($Objeto);
        return $coleccionResultado;
    }
}
?>