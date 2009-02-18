<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Configuracion.class.php';
/**
 * Description of controladorConfiguracionBDclass
 * Clase para el manejo de la base de datos configuracion
 * @author jonathan
 */
class controladorConfiguracionBDclass {

    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar una configuracion
     * @param <CONFIGURACION> $configuracion
     * @return <boolean>
     */
    function agregarConfiguracion($configuracion){
        $resultado = false;
        $query = "INSERT INTO CONFIGURACION(sueldoPiloto, sueldoCopiloto, sobrecargo)
                  VALUES (".$configuracion->getSueldoPiloto().",
                          ".$configuracion->getSueldoCopiloto().",
                          ".$configuracion->getSobrecargo().")";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar una configuracion
     * @param <boolean> $configuracion
     */
    function editarConfiguracion($configuracion){
        $resultado = false;
        $query = "UPDATE CONFIGURACION c SET c.sueldoPiloto = ".$configuracion->getSueldoPiloto().",
                                        c.sueldoCopiloto = ".$configuracion->getSueldoCopiloto().",
                                        c.sobrecargo = ".$configuracion->getSobrecargo()."
                   WHERE c.id = ".$configuracion->getId();
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para obtener los datos de la configuracion del sistema
     * @return <recurso>
     */
    function consultarConfiguracion(){
        $query = "SELECT * FROM CONFIGURACION";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

}
?>
