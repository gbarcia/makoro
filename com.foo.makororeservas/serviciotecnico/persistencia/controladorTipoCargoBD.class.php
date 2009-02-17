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
        $query = "INSERT INTO `TIPO_CARGO` (`cargo`, `descripcion`)".
                 "VALUES ('" . mysql_real_escape_string($tipoCargo->getCargo()) . "',
                          '" . mysql_real_escape_string($tipoCargo->getDescripcion()) . "')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
