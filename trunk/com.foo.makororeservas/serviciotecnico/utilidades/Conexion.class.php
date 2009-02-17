<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/com.foo.makororeservas/configuracion/ConfiguracionBD.class.php");
/**
 * Description of Conexionclass
 *
 * @author gerardobarcia
 */
class Conexionclass {

    private $configuracion;

    private $conexion;

    function __construct() {
        $this->configuracion = new ConfiguracionBDclass();
    }
/**
 *
 * @return <Conexion> la conexion con la base de datos
 */
    function conectarBaseDatos () {
        $this->conexion = mysql_connect ($this->configuracion->getDatabaseURL(),
                                   $this->configuracion->getDatabaseUserName(),
                                   $this->configuracion->getDatabasePWord());
        mysql_select_db ($this->configuracion->getDatabaseName());
        return $this->conexion;
    }

    function cerrarConexion () {
        mysql_close($this->conexion);
    }

}
?>
