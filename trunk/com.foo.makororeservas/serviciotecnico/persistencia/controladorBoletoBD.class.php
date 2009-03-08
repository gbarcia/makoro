<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';

/**
 * Description of controladorBoletoBDclass
 * Clase para el manejo de los boletos en la base de datos
 * @author Diana Uribe
 */
class controladorBoletoBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agegar un boleto en la base de datos
 * @param <BOLETO> $boleto
 * @return <boolean> resultado de la operacion 
 */
    function agregarBoleto($boleto) {
        $resultado = false;
        $query = "INSERT INTO BOLETO (PAGO_id,PASAJERO_id) VALUES ('".$boleto->getPagoId()."',
                                                                   '".$boleto->getPasajeroId()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar todos los boletos
 * @return <Coleccion> boletos
 */
    function consultarBoletos(){
        $resultado = false;
        $query = "SELECT r.solicitud,CONCAT(e.nombre,' ',e.apellido) Agente,v.fecha,v.hora,ru.abreviaturaSalida Salida,ru.abreviaturaLlegada Llegada,
                 CONCAT(p.nombre,' ',p.apellido) Pasajero, vr.tipo Servicio,p.TIPO_PASAJERO_id Tipo

                 FROM BOLETO b, PASAJERO p, RESERVA r, PAGO pa, TIPO_SERVICIO t, VUELO_RESERVA vr, VUELO v, RUTA ru, ENCARGADO e
                 WHERE r.PAGO_id = pa.id
                 AND pa.id = b.PAGO_id
                 AND p.id = b.PASAJERO_id
                 AND r.TIPO_SERVICIO_id = t.id
                 AND r.PASAJERO_id = p.id
                 AND vr.RESERVA_id = r.id
                 AND v.id = vr.VUELO_id
                 AND v.RUTA_sitioSalida = ru.sitioSalida
                 AND v.RUTA_sitioLlegada = ru.sitioLlegada
                 AND r.ENCARGADO_cedula = e.cedula";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar un boleto en especifico segun la fecha de
 * reserva y solicitud
 * @param <Date> $fecha
 * @param <String> $solicitud
 * @return <recurso>
 */
    function consultarBoletoEspecifico($solicitud) {
        $resultado = false;
        $query = "SELECT r.CLIENTE_AGENCIA_rif rifAgencia, r.CLIENTE_PARTICULAR_cedula particularCedula, pa.id idPago,r.solicitud,t.abreviatura abreviatura,
                         t.nombre nombreServicio,CONCAT(e.nombre,' ',e.apellido) agente,
                         IF(r.CLIENTE_AGENCIA_rif is not null,CA.nombre,CONCAT(CP.nombre,' ',CP.apellido)) as clienteNombre,
                         CA.porcentajeComision porcentajeComision
                  FROM RESERVA r, PAGO pa, TIPO_SERVICIO t, ENCARGADO e, CLIENTE_PARTICULAR CP, CLIENTE_AGENCIA CA
                  WHERE r.solicitud = '".$solicitud."'
                  AND r.PAGO_id = pa.id
                  AND r.TIPO_SERVICIO_id = t.id
                  AND r.ENCARGADO_cedula = e.cedula
                  AND (r.CLIENTE_PARTICULAR_cedula = CP.cedula
                       OR r.CLIENTE_AGENCIA_rif = CA.rif)
                  GROUP BY(rifAgencia)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar la informacion de los pasajeros
 * @param <Integer> $pagoId
 * @return <Coleccion> coleccion de pasajeros
 */
    function consultarPasajeros($solicitud){
        $resultado = false;
        $query = "SELECT p.id idPasajero,p.nombre nombre,p.apellido apellido,
                        p.TIPO_PASAJERO_id tipoPasajeroId,p.sexo sexo,p.cedula cedula,p.pasaporte pasaporte,p.nacionalidad nacionalidad
                  FROM RESERVA r, PASAJERO p
                  WHERE r.solicitud = '".$solicitud."'
                  AND r.PASAJERO_id = p.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar la cantidad de adultos y niños que iran en el viaje
 * @param <Integer> $pagoId
 * @param <String> $tipoPasajero
 * @return <recurso> recurso con la cantidad de adultos o niños
 */
    function cantidadAdultosNinos($solicitud, $tipoPasajero, $tipoVuelo){
        $resultado = false;
        $query = "SELECT COUNT(TIPO_PASAJERO_id) cantidad, t.porcentajeDescuento descuento
                  FROM RESERVA r, PASAJERO p, TIPO_PASAJERO t, VUELO_RESERVA vr
                  WHERE r.solicitud = '" . $solicitud . "'
                  AND r.PASAJERO_id = p.id
                  AND p.TIPO_PASAJERO_id = '".$tipoPasajero."'
                  AND p.TIPO_PASAJERO_id = t.id
                  AND vr.tipo = '".$tipoVuelo."'
                  AND vr.RESERVA_id = r.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar el vuelo dependiendo del numero de la solicitud y
 * el tipo de vuelo, ya sea de ida o vuelta
 * @param <String> $solicitud
 * @param <String> $tipoVuelo
 * @return <recurso> recurso con detalles del vuelo
 */
    function consultarRutaFechaHoraVuelo($solicitud,$tipoVuelo) {
        $resultado = false;
        $query = "SELECT r.solicitud,v.fecha,v.hora,ru.abreviaturaSalida sitioSalida,
                         ru.abreviaturaLlegada sitioLlegada, ru.costo costoRuta, ru.generaIva generaIva
                  FROM RESERVA r, VUELO_RESERVA vr, VUELO v, RUTA ru
                  WHERE r.solicitud = '".$solicitud."'
                  AND vr.RESERVA_id = r.id
                  AND v.id = vr.VUELO_id
                  AND v.RUTA_sitioSalida = ru.sitioSalida
                  AND v.RUTA_sitioLlegada = ru.sitioLlegada
                  AND vr.tipo = '".$tipoVuelo."'
                  GROUP BY r.solicitud,v.fecha,v.hora,ru.abreviaturaSalida,ru.abreviaturaLlegada";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>