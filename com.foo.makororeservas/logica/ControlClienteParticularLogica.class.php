<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteParticular.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorClienteParticularBD.class.php';
/**
 * Description of ControlClienteParticularLogicaclass
 * Manejo de la logica Cliente Particular
 * @author maya
 */
class ControlClienteParticularLogicaclass {
    private $controlBD;

    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->controlBD = new controladorClienteParticularBDclass();
    }

    /**
     * Metodo para agregar un nuevo cliente particular en el sistema
     * @param <int> $cedula La cedula del cliente particular
     * @param <String> $nombre El nombre del cliente particular
     * @param <Strin> $apellido El apellido del cliente particular
     * @param <String> $sexo El sexo del cliente particular
     * @param <Date> $fechaNacimiento La fecha de nacimiento del cliente particular
     * @param <String> $telefono El telefono actual del cliente particular
     * @param <String> $estado El estado donde habita actualmente el cliente particular
     * @param <String> $ciudad La ciudad donde habita actualmente el cliente particular
     * @param <String> $direccion La direccion actual del cliente particular
     * @return <boolean> Resultado de la operacion
     */
    function nuevoClienteParticular($cedula,$nombre,$apellido,$sexo,$fechaNacimiento,$telefono,$estado,$ciudad,$direccion){
        $clienteParticular = new ClienteParticularclass();
        $clienteParticular->setCedula($cedula);
        $clienteParticular->setNombre($nombre);
        $clienteParticular->setApellido($apellido);
        $clienteParticular->setSexo($sexo);
        $clienteParticular->setFechanacimiento($fechaNacimiento);
        $clienteParticular->setTelefono($telefono);
        $clienteParticular->setEstado($estado);
        $clienteParticular->setCiudad($ciudad);
        $clienteParticular->setDireccion($direccion);
        $resultado = $this->controlBD->agregarClienteParticular($clienteParticular);

        return $resultado;
    }

    /**
     * Metodo para editar un cliente particular del sistema
     * @param <int> $cedula La cedula del cliente particular
     * @param <String> $nombre El nombre del cliente particular
     * @param <String> $apellido El apellido del cliente particular
     * @param <String> $telefono El telefono del cliente particular
     * @param <String> $estado El estado donde habita actualmente el cliente particular
     * @param <String> $ciudad La ciudad donde habita actualmente el cliente particular
     * @param <String> $direccion La direccion actual del cliente particular
     * @return <boolean> El resultado de la operacion
     */
    function actualizarClienteParticular($cedula,$nombre,$apellido,$telefono,$estado,$ciudad,$direccion){
        $clienteParticular = new ClienteParticularclass();
        $clienteParticular->setCedula($cedula);
        $clienteParticular->setNombre($nombre);
        $clienteParticular->setApellido($apellido);
        $clienteParticular->setTelefono($telefono);
        $clienteParticular->setEstado($estado);
        $clienteParticular->setCiudad($ciudad);
        $clienteParticular->setDireccion($direccion);
        $resultado = $this->controlBD->editarClienteParticular($clienteParticular);

        return $resultado;
    }

    /**
     * Metodo para consultar Cliente particular por cedula, nombre y apellido
     * @param <String> $busqueda La busqueda que se desea realizar
     * @return <Coleccion> Una coleccion con el cliente particular segun
     * la busqueda que se realizo
     */
    function consultarClientesParticularesCedulaNombreApellido($busqueda) {
        $recurso = $this->controlBD->consultarClienteParticularCedulaNombreApellido($busqueda);
        return $recurso;
    }

    /**
     * Metodo para consultar cliente particular con mas vuelos realizados
     * @return <recurso> El cliente particular que han realizado mas vuelos
     */
    function consultarClienteParticularConMasVuelos(){
        $recurso = $this->controlBD->consultarClienteParticularConMasVuelos();
        return $recurso;
    }

    /**
     * Metodo para consultar los clientes particulares, que hayan realizado mas
     * vuelos en orden descendente
     * @return <recurso> Los clientes que han realizado mas vuelos en orden
     * descendente
     */
    function consultarClienteParticularConMasVuelosDescendente(){
        $recurso = $this->controlBD->consultarClientesParticularesVuelosDescendente();
        return $recurso;
    }

    /**
     * Metodo para consultar clientes particulares que no han realizado el pago
     * @param <Date> $fechaInicio
     * @param <Date> $fechaFin
     * @return <recurso> Los clientes que no han realizado realizado el pago
     */
    function consultarClientesParticularesPorPagar($fechaInicio,$fechaFin){
       $recurso = $this->controlBD->consultarClientesParticularesPorPagar($fechaInicio, $fechaFin);
       return $recurso;
    }
    
}
?>
