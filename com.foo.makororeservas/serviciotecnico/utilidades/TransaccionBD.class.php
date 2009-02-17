<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/com.foo.makororeservas/serviciotecnico/utilidades/Conexion.class.php';
/**
 * Description of TransaccionBDclass
 *
 * @author gerardobarcia
 */
class TransaccionBDclass {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexionclass();
    }

/**
 *
 * @param <String> $query query a enviar
 * @return <Recurso> resultado del query
 */
    function realizarTransaccion($query) {
       $link = $this->conexion->conectarBaseDatos();
       $result = mysql_query($query,$link);
       $this->conexion->cerrarConexion();
       return $result;
    }
}
?>
