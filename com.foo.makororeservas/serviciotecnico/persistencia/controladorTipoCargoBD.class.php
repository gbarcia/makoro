<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoCargo.class.php';
/**
 * Description of controladorTipoCargoBDclass
 * Clase para el manejo de la base de datos TipoCargo
 * @author maya
 */
class controladorTipoCargoBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para insertar un nuevo cargo
     * @param <TIPO_CARGO> $tipoCargo
     * @return <resultado>
     */
    function agregarTipoCargo($tipoCargo){
        $resultado = false;
        $query = "INSERT INTO `TIPO_CARGO` (`cargo`, `descripcion`, `sueldo`)".
                 "VALUES ('" . mysql_real_escape_string($tipoCargo->getCargo()) . "',
                          '" . mysql_real_escape_string($tipoCargo->getDescripcion()) . "'
                          '" . mysql_real_escape_string($tipoCargo->getSueldo()) . "')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metod para obtener un sueldo a partir de un tip de cargo
     * @param <Integer> $idCargo el id del cargo a consultar el sueldo
     * @return <Float> el sueldo del cargo a consultar
     */
    function obtenerSueldoTipoCargo ($idCargo) {
        $sueldo;
        $query = "SELECT sueldo FROM TIPO_CARGO WHERE id = $idCargo";
        $sueldo = $this->transaccion->realizarTransaccion($query);
        return $sueldo[sueldo];
    }

    function actualizarSueldoTipoCargo ($idCargo , $sueldo) {
        $resultado;
        $query = "UPDATE TIPO_CARGO SET sueldo = $sueldo WHERE id = $idCargo";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
