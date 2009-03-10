<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';
session_start();

function salirDelSistema() {
$objResponse = new xajaxResponse();
$objResponse->addConfirmCommands(3, "Confirma que desea salir del sistema?");
$_SESSION = array();
session_destroy();
$objResponse->addRedirect($sURL);
}
?>
