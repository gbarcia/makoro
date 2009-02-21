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
           $mensaje = "Transaccion: " . $query . "  " . mysql_error();
           $this->bitacora->escribirMensaje($mensaje);
       }
       else if ($result) {
           $mensaje = "Transaccion: " . $query . "  Realizada con exito";
           $this->bitacora->escribirMensaje($mensaje);
       }
       $this->conexion->cerrarConexion();
       return $result;
    }
}
?>
