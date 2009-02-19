<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Avion.class.php';

/**
 * Description of controladorAvionBDclass
 * Clase para manejo de la base de datos avion
 * @author Diana Uribe
 */
class controladorAvionBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }
/**
 * Metodo para agregar un avion en la Base de Datos
 * @param <AVION> $avion
 * @return <boolean> existe o no la operacion
 */
    function agregarAvion($avion){
        $resultado = false;
        $query = "INSERT INTO AVION (matricula,asientos,habilitado) VALUES ('".$avion->getMatricula()."',
                                                                            '".$avion->getAsientos()."',
                                                                            true)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;

    }
}
?>

