<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPagoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorBoletoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';
/**
 * Description of ControlPagoLogicaclass
 * Clase para manejar la logica de la gestion de la base de datos
 * @author Diana Uribe
 */
class ControlPagoLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlPagoBD = new controladorPagoBDclass();
        $this->controlBoletoBD = new controladorBoletoBDclass();
        $this->controlReservaBD = new controladorReservaBDclass();
    }

/**
 * Metodo para agregar un nuevo pago
 * @param <String> $tipo
 * @param <double> $monto
 * @param <String> $nombreBanco
 * @param <Integer> $numeroTransaccion
 * @param <Integer> $monedaId
 * @return <boolean> resultado de la operacion 
 */
    function nuevoPago($tipo,$monto,$nombreBanco,$numeroTransaccion,$monedaId) {
        $pago = new Pagoclass();
        $pago->setTipo($tipo);
        $pago->setMonto($monto);
        $pago->setNombreBanco($nombreBanco);
        $pago->setNumeroTransaccion($numeroTransaccion);
        $pago->setMonedaId($monedaId);
        $resultado = $this->controlBD->agregarPago($pago);

        return ($resultado);
    }

/**
 * Metodo para actulizar los datos del pago
 * @param <Integer> $id
 * @param <String> $tipo
 * @param <double> $monto
 * @param <String> $nombreBanco
 * @param <Integer> $numeroTransaccion
 * @param <Integer> $monedaId
 * @return <boolean> resultado de la operacion
 */
    function actualizarPago($id,$tipo,$monto,$nombreBanco,$numeroTransaccion,$monedaId) {
        $pago = new Pagoclass();
        $pago->setId($id);
        $pago->setTipo($tipo);
        $pago->setMonto($monto);
        $pago->setNombreBanco($nombreBanco);
        $pago->setNumeroTransaccion($numeroTransaccion);
        $pago->setMonedaId($monedaId);
        $resultado = $this->controlBD->editarPago($pago);
        return $resultado;
    }

/**
 * Metodo para consultar todos los pagos
 * @return <recurso>
 */
    function buscarPagos() {
        $recurso = false;
        $recurso = $this->controlBD->consultarPagos();
        return $recurso;
    }

/**
 *
 * @param <type> $cedula
 * @param <type> $fechaini
 * @param <type> $fechafin
 */
    function buscarCancelacionPagoClienteParticular($cedula, $fechaini, $fechafin) {
        

    }

    function reciboDePago($solicitud) {
        
        $vueloIdaInfo = $this->controlBoletoBD->consultarRutaFechaHoraVuelo($solicitud, "IDA");
        $rowVueloIdaInfo = mysql_fetch_array($vueloIdaInfo);
        $fechaIda = $rowVueloIdaInfo[fecha];
        $horaIda = $rowVueloIdaInfo[hora];
        $lugarSalida = $rowVueloIdaInfo[sitioSalida].'-'.$rowVueloIdaInfo[sitioLlegada];

        $vueloVueltaInfo = $this->controlBoletoBD->consultarRutaFechaHoraVuelo($solicitud, "VUELTA");
        $rowVueloVueltaInfo = mysql_fetch_array($vueloVueltaInfo);
        $fechaVuelta = $rowVueloVueltaInfo[fecha];
        $horaVuelta = $rowVueloVueltaInfo[hora];
        $lugarLlegada = $rowVueloVueltaInfo[sitioSalida].'-'.$rowVueloVueltaInfo[sitioLlegada];
        if($fechaVuelta == ''||$horaVuelta == ''|$lugarLlegada==''){
            $fechaVuelta = "XXXX/XX/XX";
            $horaVuelta = "XX:XX";
            $lugarLlegada = "No hay retorno";
        }
    }
}
?>
