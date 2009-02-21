<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteAgencia.class.php';
/**
 * Description of controladorClienteAgenciaBDclass
 * Clase para el manejo de la base de datos ClienteAgencia
 * @author Diana Uribe
 */
class controladorClienteAgenciaBDclass {
    private $transaccion;

    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar un nuevo cliente agencia
     * @param <CLIENTE_AGENCIA> $clienteAgencia el cliente agencia a insertar
     * @return <boolean> resultado de la operacion
     */
    function agregarClienteAgencia($clienteAgencia){
        $resultado = false;
        $query = "INSERT INTO CLIENTE_AGENCIA (rif,nombre,telefono,direccion,estado,ciudad,porcentajeComision)
                  VALUES('".$clienteAgencia->getRif()."',
                          '".$clienteAgencia->getNombre()."',
                          '".$clienteAgencia->getTelefono()."',
                          '".$clienteAgencia->getDireccion()."',
                          '".$clienteAgencia->getEstado()."',
                          '".$clienteAgencia->getCiudad()."',
                          '".$clienteAgencia->getPorcentajeComision()."')";
        echo $query;
        $resultado = $this->transaccion->realizarTransaccion($query);
//        echo $resultado;
        return $resultado;
    }

    /**
     * Metodo para editar un cliente agencia de la base de datos
     * @param <CLIENTE_AGENCIA> $clienteAgencia el cliente agencia a editar
     * @return <boolean> resultado de la operacion
     */
    function editarClienteAgencia($clienteAgencia){
        $resultado = false;
        $query = "UPDATE CLIENTE_AGENCIA ca SET ca.nombre = '".$clienteAgencia->getNombre()."',
                                                   ca.telefono = '".$clienteAgencia->getTelefono()."',
                                                   ca.direccion = '".$clienteAgencia->getDireccion()."',
                                                   ca.estado = '".$clienteAgencia->getEstado()."',
                                                   ca.ciudad = '".$clienteAgencia->getCiudad()."',
                                                   ca.porcentajeComision = '".$clienteAgencia->getPorcentajeComision()."'

                  WHERE ca.rif = '".$clienteAgencia->getRif()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo que consulta los clientes agencia por su rif, nombre
     * @param <string> $busqueda la busqueda que se desea realizar
     * @return <recurso>
     */
    function consultarClienteAgenciaRifNombre ($busqueda) {
        $resultado = false;
        $query = "SELECT CONCAT(ca.rif,' ',ca.nombre), ca.rif,ca.nombre
                  FROM CLIENTE_AGENCIA ca
                  WHERE (ca.nombre LIKE '".$busqueda."%'
                  OR ca.rif LIKE '".$busqueda."%') LIMIT 0,5";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar el cliente agencia con mas vuelos
     * @return <coleccion>
     */
    function consultarClienteAgenciaConMasVuelos(){
       $resultado = false;
       $query = "SELECT ca.rif,ca.nombre,ca.telefono,ca.estado,ca.ciudad,ca.direccion,
                        ca.porcentajeComision,COUNT(r.CLIENTE_AGENCIA_rif) as cnt
                 FROM CLIENTE_AGENCIA ca, VUELO v, VUELO_RESERVA vr, RESERVA r
                 WHERE v.id=vr.VUELO_id
                 AND r.id=vr.RESERVA_id
                 AND r.CLIENTE_AGENCIA_rif = ca.rif
                 AND r.estado = 'PA'
                 GROUP BY r.CLIENTE_AGENCIA_rif
                 HAVING cnt = (SELECT MAX(a.cnt)
                               FROM (SELECT COUNT(r.CLIENTE_AGENCIA_rif) as cnt
                                     FROM CLIENTE_AGENCIA ca, VUELO v, VUELO_RESERVA vr, RESERVA r
                                     WHERE v.id=vr.VUELO_id
                                     AND r.id=vr.RESERVA_id
                                     AND r.CLIENTE_AGENCIA_rif = ca.rif
                                     AND r.estado = 'PA'
                                     GROUP BY r.CLIENTE_AGENCIA_rif)
                               as a)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar clientes agencias que hayan realizado
     * mas vuelos, en orden descendente
     * @return <coleccion>
     */
    function consultarClientesAgenciasVuelosDescendente(){
        $resultado = false;
        $query = "SELECT ca.rif,ca.nombre,ca.telefono,ca.estado,ca.ciudad,ca.direccion,
                         ca.porcentajeComision,COUNT(r.CLIENTE_AGENCIA_rif) as cnt
                  FROM CLIENTE_AGENCIA ca, VUELO v, VUELO_RESERVA vr, RESERVA r, PASAJERO p
                  WHERE v.id=vr.VUELO_id
                  AND r.id=vr.RESERVA_id
                  AND r.PASAJERO_id = p.id
                  AND r.CLIENTE_AGENCIA_rif = ca.rif
                  AND r.estado = 'PA'
                  GROUP BY r.CLIENTE_AGENCIA_rif
                  ORDER BY cnt desc";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para consultar clientes agencias que no faltan por pagar
 * @return <coleccion> clientes agencias sin pagar
 */
    function consultarClientesAgenciasPorPagar($fechaInicio, $fechaFin){
        $resultado = false;
        $query = "SELECT ca.rif,ca.nombre,ca.telefono,ca.estado,ca.ciudad,
                         ca.direccion,ca.porcentajeComision,r.fecha
                  FROM CLIENTE_AGENCIA ca, RESERVA r
                  WHERE r.CLIENTE_AGENCIA_rif = ca.rif
                  AND   r.estado = 'PA'
                  AND   r.fecha BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
