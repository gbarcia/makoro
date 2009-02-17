<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/Bitacora.class.php';

/**
 * Prueba de la bitacora
 */

$bitacora = Bitacoraclass::getInstance();
$re = $bitacora->escribirMensaje("Prueba de la bitacora");
print "resultado : --> " . $re;

?>
