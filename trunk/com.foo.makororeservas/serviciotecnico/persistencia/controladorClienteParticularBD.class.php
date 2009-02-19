<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteParticular.class.php';
/**
 * Description of controladorClienteParticularBDclass
 * Clase para el manejo de la base de datos ClienteParticular
 * @author maya
 */
class controladorClienteParticularBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar un nuevo cliente particular
     * @param <CLIENTE_PARTICULAR> $clienteParticular el cliente particular a insertar
     * @return <boolean> resultado de la operacion
     */
    function agregarClienteParticular($clienteParticular){
        $resultado = false;
        $query = "INSERT INTO CLIENTE_PARTICULAR (cedula,nombre,apellido,sexo,fechaNacimiento,
                                                  telefono,estado,ciudad,direccion)
                  VALUES ('".$clienteParticular->getCedula()."',
                          '".$clienteParticular->getNombre()."',
                          '".$clienteParticular->getApellido()."',
                          '".$clienteParticular->getSexo()."',
                          '".$clienteParticular->getFechanacimiento()."',
                          '".$clienteParticular->getTelefono()."',
                          '".$clienteParticular->getEstado()."',
                          '".$clienteParticular->getCiudad()."',
                          '".$clienteParticular->getDireccion()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar un cliente particular de la base de datos
     * @param <CLIENTE_PARTICULAR> $clienteParticular el cliente particular a editar
     * @return <boolean> resultado de la operacion
     */
    function editarClienteParticular($clienteParticular){
        $resultado = false;
        $query = "UPDATE CLIENTE_PARTICULAR cp SET cp.nombre = '".$clienteParticular->getNombre()."',
                                                   cp.apellido = '".$clienteParticular->getApellido()."',
                                                   cp.telefono = '".$clienteParticular->getTelefono()."',
                                                   cp.estado = '".$clienteParticular->getEstado()."',
                                                   cp.ciudad = '".$clienteParticular->getCiudad()."',
                                                   cp.direccion = '".$clienteParticular->getDireccion()."'
                  WHERE cp.cedula = '".$clienteParticular->getCedula()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function consultarClienteParticularCedulaNombreApellido ($busqueda) {
        $resultado = false;
        $query = "SELECT CONCAT(cp.cedula,' ',cp.nombre,' ',cp.apellido)
                  FROM CLIENTE_PARTICULAR cp
                  WHERE (cp.nombre LIKE '".$busqueda."%'
                  OR cp.apellido LIKE '".$busqueda."%'
                  OR cp.cedula LIKE '".$busqueda."%') LIMIT 0,5";
        echo $query;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
    
}
?>
