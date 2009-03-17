<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorClienteAgenciaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteAgencia.class.php';
/**
 * Description of ControlClienteAgenciaLogicaclass
 * Manejo de la logica de la gestion de los clientes agencias
 * @author Diana Uribe
 */
class ControlClienteAgenciaLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorClienteAgenciaBDclass();
    }

    /**
     * Metodo para agregar un nuevo cliente agencia
     * @param <String> $rif
     * @param <String> $nombre
     * @param <String> $telefono
     * @param <String> $direccion
     * @param <String> $estado
     * @param <String> $ciudad
     * @param <double> $porcentajeComision
     * @return <boolean> resultado de la operacion
     */
    function nuevoClienteAgencia($rif, $nombre, $telefono, $direccion, $estado, $ciudad, $porcentajeComision){
        $clienteAgencia = new ClienteAgenciaclass();
        $clienteAgencia->setRif($rif);
        $clienteAgencia->setNombre($nombre);
        $clienteAgencia->setTelefono($telefono);
        $clienteAgencia->setDireccion($direccion);
        $clienteAgencia->setEstado($estado);
        $clienteAgencia->setCiudad($ciudad);
        $clienteAgencia->setPorcentajeComision($porcentajeComision);
        $resultado = $this->controlBD->agregarClienteAgencia($clienteAgencia);

        return ($resultado);
    }

    /**
     * Metodo para actualizar los datos del cliente agencia
     * @param <String> $rif
     * @param <String> $nombre
     * @param <String> $telefono
     * @param <String> $direccion
     * @param <String> $estado
     * @param <String> $ciudad
     * @param <String> $porcentajeComision
     * @return <boolean> resultado de la operacion
     */
    function actualizarClienteAgencia($rif, $nombre, $telefono, $direccion, $estado, $ciudad, $porcentajeComision){
        $clienteAgencia = new ClienteAgenciaclass();
        $clienteAgencia->setRif($rif);
        $clienteAgencia->setNombre($nombre);
        $clienteAgencia->setTelefono($telefono);
        $clienteAgencia->setDireccion($direccion);
        $clienteAgencia->setEstado($estado);
        $clienteAgencia->setCiudad($ciudad);
        $clienteAgencia->setPorcentajeComision($porcentajeComision);
        $resultado = $this->controlBD->editarClienteAgencia($clienteAgencia);
        return ($resultado);
    }

    /**
     * Metodo para consultar a un cliente agencia segun la busqueda
     * @param <String, Integer> $busqueda
     * @return <recurso> recurso de un objeto cliente agencia
     */
    function busquedaClienteAgenciaRifNombre($busqueda){
        $recurso = false;
        $recurso = $this->controlBD->consultarClienteAgenciaRifNombre($busqueda);
        return $recurso;
    }

    /**
     * Metodo para consultar el cliente agencia con mas vuelos
     * @return <recurso> objeto cliente agencia
     */
    function busquedaClienteAgenciaConMasVuelos(){
        $recurso = false;
        $recurso = $this->controlBD->consultarClienteAgenciaConMasVuelos();
        return $recurso;
    }

    /**
     * Metodo para consultar por orden descendente los clientes agencias segun la
     * cantidad de vuelos pagados
     * @return <Coleccion> Coleccion de clientes agencias 
     */
    function busquedaClientesAgenciasVuelosDescendente(){
        $resultado = false;
        $resultado = $this->controlBD->consultarClientesAgenciasVuelosDescendente();
        return $resultado;
    }

    /**
     * Metodo para consultar los clientes agencias que faltan por pagar en
     * un lapso de tiempo determinado
     * @param <Date> $fechaInicio La fecha de inicio a consultar
     * @param <Date> $fechaFin La fecha de fin a consultar
     * @return <Coleccion> Coleccion de los clientes agencias
     */
    function busquedaClientesAgenciasPorPagar($fechaInicio, $fechaFin){
        $resultado = false;
        $resultado = $this->controlBD->consultarClientesAgenciasPorPagar($fechaInicio, $fechaFin);
        return $resultado;
    }
}
?>