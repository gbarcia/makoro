<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Moneda.class.php';
/**
 * Description of controladorMonedaBDclass
 * Clase para el manejo de la base de datos de la moneda
 * @author Diana Uribe
 */
class controladorMonedaBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agregar una nueva moneda en la base de datos
 * @param <MONEDA> $moneda
 * @return <boolean> resultado de la operacion
 */
    function agregarMoneda($moneda) {
        $resultado = false;
        $query = "INSERT INTO MONEDA (tipo) VALUES ('".$moneda->getTipo()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para actulizar los datos de la moneda
 * @param <MONEDA> $moneda
 * @return <boolean> resultado de la operacion
 */
    function editarMoneda($moneda) {
        $resultado = false;
        $query = "UPDATE MONEDA m SET m.tipo = '".$moneda->getTipo()."'
                  WHERE m.id = '".$moneda->getId()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar todos los tipos de monedas de la base de datos
 * @return <recurso> todos los tipos de moneda
 */
    function consultarMonedas() {
        $resultado = false;
        $query = "SELECT * FROM MONEDA ORDER BY id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
