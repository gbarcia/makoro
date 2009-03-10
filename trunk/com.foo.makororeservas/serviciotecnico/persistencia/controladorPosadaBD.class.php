<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Posada.class.php';
/**
 * Description of controladorPosadaclass
 * Controlador para el manejo de la base de datos de posadas
 * @author jonathan
 */
class controladorPosadaBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    /**
     * Metodo para agregar una posada a la base de datos
     * @param Posada $posada la posada a agregar
     * @return boolean resultado de la operacion
     */
    function agregarPosada($posada){
        $resultado = false;
        $query = "INSERT INTO POSADA(nombrePosada, nombreEncargado, apellidoEncargado, telefono)".
                 "VALUES ('". $posada->getNombrePosada() . "','" .
        $posada->getNombreEncargado() . "','" .
        $posada->getApellidoEncargado() . "','" .
        $posada->getTelefono() . "')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para editar una posada
     * @param Posada $posada la posada a editar
     * @return boolean resultado de la operacion
     */
    function editarPosada($posada){
        $resultado = false;
        $query = "UPDATE POSADA SET nombrePosada = '" . $posada->getNombrePosada() . "'," .
                                   "nombreEncargado = '" . $posada->getNombreEncargado() . "'," .
                                   "apellidoEncargado = '" . $posada->getApellidoEncargado()."',".
                                   "telefono = '" . $posada->getTelefono()."' ".
                 "WHERE id = " . $posada->getId();
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    /**
     * Metodo para consultar todas las posadas de la base de datos
     * @return Recurso todas las posadas de la base de datos
     */
    function consultarPosadas(){
        $resultado = false;
        $query = "SELECT * FROM POSADA";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

     function consultarPosadaID($id){
        $resultado = false;
        $query = "SELECT * FROM POSADA WHERE id = $id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

}
?>
