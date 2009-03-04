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

    /**
     * Constructor de la clase
     */
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

    /**
     * Metodo que consulta los clientes particulares por su cedula, nombre o apellido
     * @param <string> $busqueda la busqueda que se desea realizar
     * @return <recurso>
     */
    function consultarClienteParticularCedulaNombreApellido ($busqueda) {
        $query = "SELECT CONCAT(cp.cedula,' ',cp.nombre,' ',cp.apellido), 
                                cp.cedula,cp.nombre,cp.apellido,cp.sexo,
                                cp.fechaNacimiento,cp.telefono,cp.estado,
                                cp.ciudad,cp.direccion
                  FROM CLIENTE_PARTICULAR cp
                  WHERE (cp.nombre LIKE '".$busqueda."%'
                  OR cp.apellido LIKE '".$busqueda."%'
                  OR cp.cedula LIKE '".$busqueda."%') LIMIT 0,5";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar el cliente particular con mas vuelos
     * @return <coleccion>
     */
    function consultarClienteParticularConMasVuelos(){
       $query = "SELECT cp.cedula,cp.nombre,cp.apellido,cp.sexo,cp.fechaNacimiento,
                        cp.telefono,cp.estado,cp.ciudad,cp.direccion,
                        COUNT(r.CLIENTE_PARTICULAR_cedula) as cnt
                 FROM CLIENTE_PARTICULAR cp, VUELO v, VUELO_RESERVA vr,
                      RESERVA r, PASAJERO p
                 WHERE v.id=vr.VUELO_id
                 AND r.id=vr.RESERVA_id
                 AND r.PASAJERO_id = p.id
                 AND r.CLIENTE_PARTICULAR_cedula = cp.cedula
                 AND r.estado = 'PA'
                 GROUP BY r.CLIENTE_PARTICULAR_cedula
                 HAVING cnt = (SELECT MAX(a.cnt)
                               FROM (SELECT COUNT(r.CLIENTE_PARTICULAR_cedula) as cnt
                                     FROM CLIENTE_PARTICULAR cp, VUELO v, VUELO_RESERVA vr, RESERVA r, PASAJERO p
                                     WHERE v.id=vr.VUELO_id
                                     AND r.id=vr.RESERVA_id
                                     AND r.PASAJERO_id = p.id
                                     AND r.CLIENTE_PARTICULAR_cedula = cp.cedula
                                     AND r.estado = 'PA'
                                     GROUP BY r.CLIENTE_PARTICULAR_cedula)
                               as a)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar clientes particulares que hayan realizado
     * mas vuelos, en orden descendente
     * @return <coleccion>
     */
    function consultarClientesParticularesVuelosDescendente(){
        $query = "SELECT cp.cedula,cp.nombre,cp.apellido,cp.sexo,cp.fechaNacimiento,
                         cp.telefono,cp.estado,cp.ciudad,cp.direccion,
                         COUNT(r.CLIENTE_PARTICULAR_cedula) as cnt
                  FROM CLIENTE_PARTICULAR cp, VUELO v, VUELO_RESERVA vr, RESERVA r,
                       PASAJERO p
                  WHERE v.id=vr.VUELO_id
                  AND r.id=vr.RESERVA_id
                  AND r.PASAJERO_id = p.id
                  AND r.CLIENTE_PARTICULAR_cedula = cp.cedula
                  AND r.estado = 'PA'
                  GROUP BY r.CLIENTE_PARTICULAR_cedula
                  ORDER BY cnt desc";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function consultarClientesParticularesPorPagar($fechaInicio,$fechaFin){
       $query = "SELECT cp.cedula,cp.nombre,cp.apellido,cp.sexo,cp.fechaNacimiento,
                        cp.telefono,cp.estado,cp.ciudad,cp.direccion,r.fecha
                  FROM CLIENTE_PARTICULAR cp, RESERVA r
                  WHERE r.CLIENTE_PARTICULAR_cedula = cp.cedula
                  AND   r.estado = 'PP'
                  AND   r.fecha BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function consultarTodoLosClientesPersonales () {
        $query = "SELECT * FROM CLIENTE_PARTICULAR";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function consultarClienteParticular ($cedula) {
        $query = "SELECT * FROM CLIENTE_PARTICULAR WHERE cedula = $cedula";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
