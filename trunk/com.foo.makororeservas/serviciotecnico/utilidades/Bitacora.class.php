<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
/**
 * Description of Bitacoraclass
 * Clase manejadora de la bitacora
 * @author gerardobarcia
 */
define ('ARCHIVONAME',$_SERVER['DOCUMENT_ROOT'] . "/com.foo.makororeservas/serviciotecnico/utilidades/loger.txt");
class Bitacoraclass {
    // variable que contiene el nombre del archivo
    private static $nombreArchivo = ARCHIVONAME;
    // variable para la feca
    private $fecha;
    // variable para la hora
    private $hora;
    // variable que contiene la instacia de la clase
    static $_instance;
    // variable para realizar transacciones con la base de datos
    private $transaccion;

/**
 * Constructor privado para uso de Singletons
 */
    private function __construct() {
    }

/**
 * Metodo para obtener una instancia de la clase (Singleton)
 * @return <instancia> la instancia de la clase
 */
    public static function getInstance() {
        if( ! (self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

/**
 * Metodo para escribir un mensaje en la bitacora
 * @param <String> $mensaje el mensaje a escribir
 * @return <boolean> resultado de la operacion
 */
    public function escribirMensajeTxt($mensaje) {
        $resultado = false;
        $archivo = fopen(self::$nombreArchivo,'a+');
        if (!$archivo) return $resultado;
        else {
            $this->setFecha();
            $this->setHora();
            $mensaje .= " fecha: " . $this->fecha . " hora:" . $this->hora;
            $resultadoA = fwrite ($archivo,$mensaje);
            if (!$resultadoA) $resultado = false;
            else $resultado = true;
            fclose($archivo);
        }
        return $resultado;
    }
    /**
     * Metodo para escribir el log en la base de datos
     * @param <String> $mensaje el mensaje a escribir
     * @param <boolean> $error booleano que indica si fue error o no
     */
    public function escribirMensajeBD($mensaje, $error) {
        $this->transaccion = new TransaccionBDclass();
        $resultado = false;
        $mensaje = mysql_real_escape_string($mensaje);
        $this->setFecha();
        $this->setHora();
        $query = "INSERT INTO BITACORA VALUES (NULL,'".$this->fecha."','".$this->hora."',$error,'$mensaje')";
        $resultado = $this->transaccion->realizarTransaccionBitacora($query);
        return $resultado;
    }

/**
 * Metodo para establecer la fecha actual del sistema
 */
    public function setFecha() {
        $this->fecha = date("Y-m-d");
    }

/**
 * Metodo para establecer la hora actual del sistema
 */
    public function setHora() {
        $this->hora = date("G:H:s");
    }
}
?>
