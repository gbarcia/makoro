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
       
    }

    /**
     * Metodo para editar una configuracion
     * @param <boolean> $configuracion
     */
    function editarConfiguracion($configuracion){
        
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
