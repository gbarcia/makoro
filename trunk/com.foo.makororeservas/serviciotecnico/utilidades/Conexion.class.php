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
 *Metodo para conctar con la base de datos
 * @return <Conexion> la conexion con la base de datos
 */
    function conectarBaseDatos () {
        $this->conexion = mysql_connect ($this->configuracion->getDatabaseURL(),
            $this->configuracion->getDatabaseUserName(),
            $this->configuracion->getDatabasePWord());
        $result = mysql_select_db ($this->configuracion->getDatabaseName());
        if (!$result) {
            die ("<script>location.href='ErrorBD.php'</script>");
        }
        return $this->conexion;
    }
/**
 * Metodo para cerrar la conexion con la base de datos
 */
    function cerrarConexion () {
        mysql_close($this->conexion);
    }

    public function getConexion() {
        return $this->conexion;
    }
}
?>
