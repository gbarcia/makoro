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
        "ciudad,direccion,habilitado,TIPO_CARGO_id) VALUES ('".$tripulante->getCedula()."',
                                                            '".$tripulante->getNombre()."',
                                                            '".$tripulante->getApellido()."',
                                                            '".$tripulante->getSexo()."',
                                                            '".$tripulante->getTelefono()."',
                                                            '".$tripulante->getEstado()."',
                                                            '".$tripulante->getCiudad()."',
                                                            '".$tripulante->getDireccion()."',
                                                            '".$tripulante->getHabilitado()."',
                                                            '".$tripulante->getCargo()."')";
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
        $query = "UPDATE PERSONAL p SET p.nombre = '".$tripulante->getNombre()."',
                                        p.apellido = '".$tripulante->getApellido()."',
                                        p.sexo = '".$tripulante->getSexo()."',
                                        p.telefono = '".$tripulante->getTelefono()."',
                                        p.estado = '".$tripulante->getEstado()."',
                                        p.ciudad = '".$tripulante->getCiudad()."',
                                        p.direccion = '".$tripulante->getDireccion()."',
                                        p.habilitado = '".$tripulante->getHabilitado()."',
                                        p.TIPO_CARGO_id = '".$tripulante->getCargo()."'
                   WHERE p.cedula = '".$tripulante->getCedula()."'";
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
                  AND p.cedula = '".$cedula."'
                  AND v.id = vp.VUELO_id
                  AND r.id = v.RUTA_id
                  AND tc.id = vp.cargo
                  AND vp.cargo =$cargo
                  AND v.fecha BETWEEN '" . $fechaini . "' AND '" . $fechafin . "'";
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

    function consultarDetallesPagoPersonal($fechaini, $fechafin, $cedula, $cargo){
        $resultado = false;
        $query = "SELECT p.cedula, p.nombre, p.apellido, r.sitioSalida, r.sitioLlegada,
                         r.tiempo, v.AVION_matricula, tc.cargo
                  FROM PERSONAL p, VUELO_PERSONAL vp, VUELO v, RUTA r, TIPO_CARGO tc
                  WHERE p.cedula = vp.PERSONAL_cedula
                  AND p.cedula = '".$cedula."'
                  AND v.id = vp.VUELO_id
                  AND r.id = v.RUTA_id
                  AND tc.id = vp.cargo
                  AND vp.cargo =$cargo
                  AND v.fecha BETWEEN '" . $fechaini . "' AND '" . $fechafin . "'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para consultar todo el personal registrado en la base de datos
 * @return <type>
 */
    function consultarPersonal() {
        $resultado = false;
        $query = "SELECT p.cedula,p.nombre,p.apellido,p.sexo,p.telefono,p.estado,p.ciudad,p.direccion,p.habilitado, tp.cargo
                  FROM PERSONAL p,TIPO_CARGO tp
                  WHERE p.TIPO_CARGO_id = tp.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
