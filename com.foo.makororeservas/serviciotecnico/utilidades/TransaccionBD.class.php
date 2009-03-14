<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/com.foo.makororeservas/serviciotecnico/utilidades/Conexion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/Bitacora.class.php';
/**
 * Description of TransaccionBDclass
 * Clase para el manejo de las transacciones con la base de datos
 * @author gerardobarcia
 */
class TransaccionBDclass {

    /*Variable para el manejo de la conexion*/
    private $conexion;

    /*Variable para el manejo de la bitacora*/
    private $bitacora;

/**
 * Constructor que inicia el objeto de conexion con la bd y la bitacora
 */
    function __construct() {
        $this->conexion = new Conexionclass();
        $this->bitacora = Bitacoraclass::getInstance();
    }

/**
 * Metodo para realizar una transaccion con la bd
 * @param <String> $query query a enviar
 * @return <Recurso> resultado del query
 */
    function realizarTransaccion($query) {
        $link = $this->conexion->conectarBaseDatos();
        $result = mysql_query($query,$link);
        if (!$result) {
            $mensaje = $query. '  '.mysql_error();
            $this->bitacora->escribirMensajeBD($mensaje,1);
        }
        $this->conexion->cerrarConexion();
        return $result;
    }

 /**
 * Metodo para realizar una transaccion con la bd que retorna el id autogenerado
 * @param <String> $query query a enviar
 * @return <Integer> el id ingresado en la bd
 */
    function realizarTransaccionInsertId($query) {
        $id = -1;
        $link = $this->conexion->conectarBaseDatos();
        $result = mysql_query($query,$link);
        if (!$result) {
            $mensaje = $query. '  '.mysql_error();
            $this->bitacora->escribirMensajeBD($mensaje,1);
        }
        else if ($result) {
            $id = mysql_insert_id($this->conexion->getConexion());
        }
        $this->conexion->cerrarConexion();
        return $id;
    }
/**
 * Metodo para realizar transacciones de bitacora
 * @param <String> $query query a ejecutar
 * @return <boolean> resultado de la operacion
 */
    function realizarTransaccionBitacora($query) {
        $link = $this->conexion->conectarBaseDatos();
        $result = mysql_query($query,$link);
        $this->conexion->cerrarConexion();
        return $result;
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function setConexion($conexion) {
        $this->conexion = $conexion;
    }

}
?>
