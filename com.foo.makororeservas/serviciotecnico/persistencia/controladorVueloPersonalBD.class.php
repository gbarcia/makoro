<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloPersonal.class.php';
/**
 * Description of controladorVueloPersonalBDclass
 *
 * @author Diana Uribe
 */
class controladorVueloPersonalBDclass {
    public $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agregar el personal al vuelo
 * @param <VUELO_PERSONAL> $vueloPersonal
 * @return <boolean>
 */
    function agregarVueloPersonal($vueloPersonal) {
        $resultado = false;
        $query = "INSERT INTO VUELO_PERSONAL (VUELO_id, PERSONAL_cedula, cargo)".
                 "VALUES ('" . $vueloPersonal->getVueloId() . "',
                          '" . $vueloPersonal->getPersonalCedula(). "',
                          '" . $vueloPersonal->getCargo() . "')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para actualizar el personal del vuelo o cambiarlos de vuelo
 * @param <type> $vueloPersonal
 * @return <type>
 */
    function editarVueloPersonal($vueloPersonal) {
        $resultado = false;
        $query = "UPDATE VUELO_PERSONAL vp SET vp.VUELO_id = ".$vueloPersonal->getVueloId().",
                                               vp.PERSONAL_cedula = ".$vueloPersonal->getPersonalCedula().",
                                               vp.cargo = ".$vueloPersonal->getCargo()."
                  WHERE vp.VUELO_id = ".$vueloPersonal->getVueloId()."
                  AND vp.PERSONAL_CEDULA = ".$vueloPersonal->getPersonalCedula()."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar el piloto del vuelo
 * @param <Integer> $id
 * @return <recurso> vuelo con el piloto
 */
    function consultarVueloPersonalPiloto($id) {
        $resultado;
        $query = "SELECT vp.VUELO_id idVuelo, CONCAT(p.nombre,' ',p.apellido) tripulante, tp.cargo,p.cedula
                  FROM VUELO_PERSONAL vp, VUELO v, PERSONAL p, TIPO_CARGO tp
                  WHERE v.id = vp.VUELO_id
                  AND v.id = ".$id."
                  AND vp.PERSONAL_cedula = p.cedula
                  AND vp.cargo = tp.id
                  AND tp.id = 1";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar el copiloto del vuelo
 * @param <Integer> $id
 * @return <recurso> vuelo con el copiloto
 */
    function consultarVueloPersonalCopiloto($id) {
        $resultado;
        $query = "SELECT vp.VUELO_id idVuelo, CONCAT(p.nombre,' ',p.apellido) tripulante, tp.cargo,p.cedula
                  FROM VUELO_PERSONAL vp, VUELO v, PERSONAL p, TIPO_CARGO tp
                  WHERE v.id = vp.VUELO_id
                  AND v.id = ".$id."
                  AND vp.PERSONAL_cedula = p.cedula
                  AND vp.cargo = tp.id
                  AND tp.id = 2";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
