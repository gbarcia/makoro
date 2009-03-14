<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';
/**
 * Description of controladorSucursalBDclass
 * Clase para manejo de la base de datos sucursal
 * @author maya
 */
class controladorSucursalBDclass {
    /**
     * @var <transaccion> Variable del objeto para realizar las transacciones
     */
    private $transaccion;

    /**
     * Constructor que inicia un objeto para la trasanccion con la base de datos
     */
    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar una sucursal en la base de datos
     * @param <SUCURSAL> $sucursal La sucursal a ingresar
     * @return <boolean> El resultado de la operacion
     */
    function agregarSucursal($sucursal){
        $resultado = false;
        $query = "INSERT INTO SUCURSAL(nombre,estado,ciudad,direccion,
                                       telefono,habilitado)
                                VALUES('". $sucursal->getNombre() ."',
                                       '". $sucursal->getEstado()."',
                                       '". $sucursal->getCiudad()."',
                                       '". $sucursal->getDireccion()."',
                                       '". $sucursal->getTelefono()."',
                                       '". $sucursal->getHabilitado()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar una sucursal
     * @param <SUCURSAL> $sucursal La sucursal a editar
     * @return <boolean> El resultado de la operacion
     */
    function editarSucursal($sucursal){
        $resultado = false;
        $query = "UPDATE SUCURSAL s SET s.nombre = '".$sucursal->getNombre()."',
                                        s.estado = '".$sucursal->getEstado()."',
                                        s.ciudad = '".$sucursal->getCiudad()."',
                                        s.direccion = '".$sucursal->getDireccion()."',
                                        s.telefono = '".$sucursal->getTelefono()."',
                                        s.habilitado = ".$sucursal->getHabilitado()."
                  WHERE s.id = '".$sucursal->getId()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar todas las sucursales de la base de datos
     * @return <Coleccion> Todas las sucursales de la base de datos
     */
    function consultarSucursales($habilitado){
        $query = "SELECT * FROM SUCURSAL s WHERE s.habilitado=$habilitado";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar sucursal por id, nombre, estado o ciudad
     * @param <String> $busqueda La busqueda a realizar
     * @return <Coleccion> La(s) sucursales de acuerdo a la consulta
     */
    function consultarSucursalIdNombreEstadoCiudad($busqueda){
        $query = "SELECT CONCAT(s.id,' ',s.nombre,' ',s.estado,' ',s.ciudad),
                                s.id, s.nombre, s.estado, s.ciudad, s.direccion,
                                s.telefono, s.habilitado
                  FROM SUCURSAL s
                  WHERE (s.id LIKE '".$busqueda."%'
                  OR s.nombre LIKE '".$busqueda."%'
                  OR s.estado LIKE '".$busqueda."%'
                  OR s.ciudad LIKE '".$busqueda."%') LIMIT 0,5";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar los encargados de una sucursal
     * @param <SUCURSAL> $sucursal La sucursal que se desea consultar
     * @return <coleccion> Los encargados que trabajan en la sucursal consultada
     */
    function consultarEncargadosSucursal($idSucursal){
        $query = "SELECT e.cedula,e.nombre,e.apellido,e.sexo,e.fechaNacimiento,
                         e.tipo,e.estado,e.ciudad,e.direccion,e.telefono,e.habilitado
                  FROM ENCARGADO e, SUCURSAL s
                  WHERE e.SUCURSAL_id = s.id
                  AND s.id = '".$idSucursal."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar las ventas de una sucursal
     * @param <int> $idSucursal El id de la sucursal a consultar
     * @param <Date> $fechaInicio La fecha de inicio a consultar
     * @param <Date> $fechaFin La fecha de fin a consultar
     * @return <Coleccion> Las ventas realizadas por la sucursal
     * consultada en el rango de fecha indicado
     */
    function consultarVentasSucursal($idSucursal,$fechaInicio,$fechaFin){
        $query = "SELECT s.id as sucursal,s.nombre as nombre,r.fecha as fecha,
                         p.monto as monto
                  FROM SUCURSAL s, RESERVA r, PAGO p
                  WHERE s.id = r.SUCURSAL_id
                  AND r.estado = 'PA'
                  AND p.id = r.PAGO_id
                  AND r.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'
                  AND s.id = '".$idSucursal."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar la sucursal que ha vendido mas en la base de datos
     * @param <Date> $fechaInicio La fecha de inicio a consultar
     * @param <Date> $fechaFin La fecha de fin a consultar
     * @return <Coleccion> La sucursal que ha vendido mas
     */
    function consultarSucursalMasVentas($fechaInicio,$fechaFin){
        $query = "SELECT s.id as sucursal,s.nombre as nombre, m.tipo as tipo, SUM(p.monto) as monto
                  FROM SUCURSAL s, RESERVA r, PAGO p, MONEDA m
                  WHERE s.id = r.SUCURSAL_id
                  AND r.estado = 'PA'
                  AND p.id = r.PAGO_id
                  AND r.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'
                  AND m.id = p.MONEDA_id
                  GROUP BY(s.id)
                  ORDER BY p.monto desc";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar el ejecutivo que ha vendido mas en una sucursal, en la base de datos
     * @param <int> $idSucursal La sucursal a consultar
     * @param <Date> $fechaInicio La fecha de inicio a consultar
     * @param <Date> $fechaFin La fecha de fin a consultar
     * @return <coleccion> El ejecutivo que ha vendido mas en una sucursal
     */
    function consultarEncargadoMasVenta($fechaInicio,$fechaFin){
        $query = "SELECT s.id as idSucursal,s.nombre as nombreSucursal, m.tipo as moneda, e.cedula cedula, e.nombre encargadoNombre,e.apellido, SUM(p.monto) as monto
                  FROM SUCURSAL s, RESERVA r, PAGO p, MONEDA m, ENCARGADO e
                  WHERE s.id = r.SUCURSAL_id
                  AND r.estado = 'PA'
                  AND p.id = r.PAGO_id
                  AND m.id = p.MONEDA_id
                  AND e.cedula = r.ENCARGADO_cedula
                  AND e.habilitado = 1
                  AND r.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'
                  GROUP BY moneda,cedula
                  ORDER BY p.monto desc";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar el encargado con mas reservas realizadas
     * @param <type> $idSucursal El id de la sucursal a la que pertenece el encargado
     * @param <type> $fechaInicio La fecha de inicio a consultar
     * @param <type> $fechaFin La fecha de fin a consultar
     * @return <type> Encargado con mas reservas realizadas
     */
    function consultarEncargadoConMasReservas($fechaInicio,$fechaFin){
        $query = "SELECT s.id as idSucursal,s.nombre as nombreSucursal, e.cedula cedula,
                         e.nombre encargadoNombre,e.apellido, COUNT(r.ENCARGADO_cedula) as cantidad
                  FROM SUCURSAL s, RESERVA r, ENCARGADO e
                  WHERE s.id = r.SUCURSAL_id
                  AND e.cedula = r.ENCARGADO_cedula
                  AND e.habilitado = 1
                  AND r.fecha BETWEEN '".$fechaInicio."' AND '".$fechaFin."'
                  GROUP BY cedula
                  ORDER BY cantidad desc";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para habilitar o deshabilitar una sucursal
 * @param <Integer> $valor Valor 1 para habilitar o 0 para deshabilitar
 * @param <Integer> $id Identificador de la sucursal
 * @return <boolean> resultado de la operacion
 */
    function eliminarRegenerarSucursal ($valor,$id) {
        $query = "UPDATE SUCURSAL SET habilitado=$valor WHERE id = $id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar una sucursal determinada
 * @param <Integer> $id Identificador de la sucursal
 * @return <boolean> resultado de la operacion true o false
 */
    function consultarSucursal ($id) {
        $query = "SELECT * FROM SUCURSAL WHERE id=$id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>