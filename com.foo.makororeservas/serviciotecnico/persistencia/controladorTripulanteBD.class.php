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

}
?>