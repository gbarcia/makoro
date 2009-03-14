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
     * @param <AVION> $avion Coleccion de datos sobre el avion
     * @return <boolean> existe o no la operacion
     */
    function agregarAvion($avion){
        $resultado = false;
        $query = "INSERT INTO AVION (matricula,asientos,habilitado)
                              VALUES ('".$avion->getMatricula()."',
                                      '".$avion->getAsientos()."',
                                        true)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;

    }

    /**
     * Metodo para modificar los datos del avion en la base de datos
     * @param <AVION> $avion Coleccion de datos sobre el avion
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
 * Metodo para actualizar la cantidad de asientos en el avion
 * @param <String> $matricula Metricula del avion
 * @param <Integer> $asientos Capacidad de asientos que tiene el avion
 * @return <recurso> resultado de la operacion true o false
 */
    function actualizarAsientos($matricula, $asientos){
        $resultado = false;
        $query = "UPDATE AVION a SET a.asientos = '".$asientos."'
                  WHERE a.matricula = '".$matricula."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar todos los aviones de la base de datos
     * @return <Coleccion> todos los aviones
     */
    function consultarAviones(){
        $resultado = false;
        $query = "SELECT a.matricula,a.asientos,COUNT(v.AVION_matricula) numero
                  FROM AVION a LEFT JOIN VUELO v ON a.matricula = v.AVION_matricula
                  GROUP BY a.matricula";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar aviones, segun si estan habilitados o no
     * @param <boolean> $habilitado Habilitado o no
     * @return <Coleccion> Los aviones que estan o no habilitados, de acuerdo a
     * la consulta
     */
    function consultarAvionesHab($habilitado){
        $query = "SELECT * FROM AVION a ";
                  if($habilitado)
                     $query .= "WHERE a.habilitado = 1";
                  else
                     $query .= "WHERE a.habilitado = 0";
                     $query .= " ORDER BY a.matricula";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar aviones por matricula
     * @param <String> $matricula La matricula a consultar
     * @return <recurso> El avion con la matricula consultada
     */
    function consultarAvionesPorMatricula($matricula){
        $resultado = false;
        $query = "SELECT *
                  FROM AVION
                  WHERE matricula = '".$matricula."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar aviones por su matricula
     * @param <String> $busqueda La matricula a consultar
     * @return <Coleccion> Aviones segun la matricula
     */
    function consultarAvionesMat($busqueda){
        $resultado = false;
        $query = "SELECT *
                  FROM AVION
                  WHERE matricula LIKE '".$matricula."%'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>