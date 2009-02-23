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
 * Metodo para agregar un avion en la base de datos
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
/**
 * Metodo para modificar los datos del avion en la base de datos
 * @param <AVION> $avion
 * @return <boolean> resultado de la operacion
 */
    function editarAvion($avion){
        $resultado = false;
        $query = "UPDATE AVION a SET a.asientos = '".$avion->getAsientos()."',
                                 a.habilitado = '".$avion->getHabilitado()."'
              WHERE a.matricula = '".$avion->getMatricula()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para consultar todos los aviones de la base de datos
 * @return <Coleccion> todos los aviones
 */
    function consultarAviones(){
        $resultado = false;
        $query = "SELECT * FROM AVION";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>

