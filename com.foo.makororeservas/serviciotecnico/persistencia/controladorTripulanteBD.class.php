<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';
/**
 * Description of controladorTripulanteBDclass
 * Clase para manejo de la base de datos tripulacion
 * @author gerardobarcia
 */
class controladorTripulanteBDclass {

    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }
/**
 * Metodo para agregar un personal en la Base de Datos
 * @param <TRIPULANTE> $tripulante objeto tripulante agregar
 * @return <boolean> exito o no en la operacion
 */
    function agregarPersonal($tripulante){
        $resultado = false;
        $query = "INSERT INTO PERSONAL (cedula,nombre,apellido,sexo,telefono,estado," .
        "ciudad,direccion,habilitado,TIPO_CARGO_id) VALUES ('".mysql_real_escape_string($tripulante->getCedula())."',
                                                            '".mysql_real_escape_string($tripulante->getNombre())."',
                                                            '".mysql_real_escape_string($tripulante->getApellido())."',
                                                            '".mysql_real_escape_string($tripulante->getSexo())."',
                                                            '".mysql_real_escape_string($tripulante->getTelefono())."',
                                                            '".mysql_real_escape_string($tripulante->getEstado())."',
                                                            '".mysql_real_escape_string($tripulante->getCiudad())."',
                                                            '".mysql_real_escape_string($tripulante->getDireccion())."',
                                                            '".mysql_real_escape_string($tripulante->getHabilitado())."',
                                                            '".mysql_real_escape_string($tripulante->getCargo())."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
* Metodo para editar un personal en la Base de Datos
* @param <TRIPULANTE> $tripulante objeto tripulante a editar
* @return <boolean> existe o no en la operacion
*/

    function editarPersonal($tripulante){
        $resultado = false;
        $query = "UPDATE PERSONAL p SET p.nombre = '".mysql_real_escape_string($tripulante->getNombre())."',
                                        p.apellido = '".mysql_real_escape_string($tripulante->getApellido())."',
                                        p.sexo = '".mysql_real_escape_string($tripulante->getSexo())."',
                                        p.telefono = '".mysql_real_escape_string($tripulante->getTelefono())."',
                                        p.estado = '".mysql_real_escape_string($tripulante->getEstado())."',
                                        p.ciudad = '".mysql_real_escape_string($tripulante->getCiudad())."',
                                        p.direccion = '".mysql_real_escape_string($tripulante->getDireccion())."',
                                        p.habilitado = '".mysql_real_escape_string($tripulante->getHabilitado())."',
                                        p.TIPO_CARGO_id = '".mysql_real_escape_string($tripulante->getCargo())."'
                   WHERE p.cedula = '".mysql_real_escape_string($tripulante->getCedula())."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para consultar el pago del personal dependiendo de su fecha inicio,
 * fecha fin, cedula, cargo y tarifa en un rango de tiempo
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @param <Integer> $cedula
 * @param <String> $cargo
 * @param <double> $tarifa
 * @return <recurso> registros de la consulta
 */
    function consultarTotalPagoPersonal($fechaini, $fechafin, $cedula, $cargo, $tarifa){
        $resultado = false;
        $query = "SELECT p.cedula cedula , p.nombre nombre, p.apellido apellido, SUM(r.tiempo*$tarifa)monto, tc.cargo
                  FROM PERSONAL p, VUELO_PERSONAL vp, VUELO v, RUTA r, TIPO_CARGO tc
                  WHERE p.cedula = vp.PERSONAL_cedula
                  AND p.cedula = '".mysql_real_escape_string($cedula)."'
                  AND v.id = vp.VUELO_id
                  AND r.id = v.RUTA_id
                  AND tc.id = vp.cargo
                  AND vp.cargo =$cargo
                  AND v.fecha BETWEEN '" . mysql_real_escape_string($fechaini) . "' AND '" . mysql_real_escape_string($fechafin) . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para consultar en detalle el pago del personal en un rango de tiempo
 * fecha fin, cedula, cargo y tarifa
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @param <Integer> $cedula
 * @param <Integer> $cargo
 * @return <recurso> registros de la consulta
 */

    function consultarDetallesPagoPersonal($fechaini, $fechafin, $cedula){
        $resultado = false;
        $query = "SELECT p.cedula, p.nombre, p.apellido, r.sitioSalida, r.sitioLlegada,
                         r.tiempo, v.AVION_matricula, tc.cargo
                  FROM PERSONAL p, VUELO_PERSONAL vp, VUELO v, RUTA r, TIPO_CARGO tc
                  WHERE p.cedula = vp.PERSONAL_cedula
                  AND p.cedula = '".mysql_real_escape_string($cedula)."'
                  AND v.id = vp.VUELO_id
                  AND r.id = v.RUTA_id
                  AND tc.id = vp.cargo
                  AND v.fecha BETWEEN '" . mysql_real_escape_string($fechaini) . "' AND '" . mysql_real_escape_string($fechafin) . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para consultar todo el personal registrado en la base de datos
 * @return <recurso> registro de todo el personal en la base de datos
 */
    function consultarPersonal() {
        $resultado = false;
        $query = "SELECT p.cedula,p.nombre,p.apellido,p.sexo,p.telefono,p.estado,p.ciudad,p.direccion,p.habilitado, tp.cargo
                  FROM PERSONAL p,TIPO_CARGO tp
                  WHERE p.TIPO_CARGO_id = tp.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar un persona por cedula o completacion de datos(nombre, apellido)
 * @param <String> $busqueda
 * @return <recurso> recurso con todos los registros si existen de la busqueda
 */
    function consultarPersonaCedulaNombreApellido ($busqueda) {
        $resultado = false;
        $query = "SELECT p.cedula,p.nombre,p.apellido,p.sexo,p.telefono,p.estado,p.ciudad,p.direccion,p.habilitado, tp.cargo
                  FROM PERSONAL p,TIPO_CARGO tp
                  WHERE (p.nombre LIKE '%".mysql_real_escape_string($busqueda)."%'
                  OR p.apellido LIKE '%".mysql_real_escape_string($busqueda)."%'
                  OR p.cedula = '".mysql_real_escape_string($busqueda)."')
                  AND p.TIPO_CARGO_id = tp.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
