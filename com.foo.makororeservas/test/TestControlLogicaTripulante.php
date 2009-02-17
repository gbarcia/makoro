<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';

$controlBD = new ControlTripulanteLogicaclass();

$tabla = $controlBD->consultarTodoPersonal();

foreach ($tabla as $variable) {

    print $variable->getCedula();
}
?>
