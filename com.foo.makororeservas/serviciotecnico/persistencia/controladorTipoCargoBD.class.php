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
     * @param <TIPO_CARGO> $tipoCargo Coleccion con los datos del cargo
     * @return <boolean> resultado de la operacion true o false
     */
    function agregarTipoCargo($tipoCargo){
        $resultado = false;
        $query = "INSERT INTO `TIPO_CARGO` (`cargo`, `descripcion`, `sueldo`)".
                 "VALUES ('" . $tipoCargo->getCargo() . "',
                          '" . $tipoCargo->getDescripcion() . "',
                          '" . $tipoCargo->getSueldo() . "')";
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
        $operacion = mysql_fetch_array($sueldo);
        return $operacion[sueldo];
    }

    /**
     * Metodo para actualizar el sueldo de un cargo
     * @param <Integer> $idCargo el id del cargo a modificar
     * @param <Float> $nuevoSueldo el nuevo sueldo del cargo
     * @return <Boolean> resultado de la operacion
     */
    function actualizarSueldoTipoCargo ($idCargo , $nuevoSueldo) {
        $resultado;
        $query = "UPDATE TIPO_CARGO SET sueldo = $nuevoSueldo WHERE id = $idCargo";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
    /**
     * Metodo para obtener todos los tipos de cargo de la base de datos
     * @return <recurso> Recurso con todos los tipos de cargo
     */
    function obtenerTodosLosTiposCargo () {
        $resultado;
        $query = "SELECT * FROM TIPO_CARGO";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para obtener un cargo por identificador
     * @param <int> $idCargo El identificador del cargo a consultar
     * @return <recurso> El cargo segun el identificador
     */
    function obtenerCargoID($idCargo){
        $query = "SELECT * FROM TIPO_CARGO tp
                  WHERE tp.id = ".$idCargo;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
