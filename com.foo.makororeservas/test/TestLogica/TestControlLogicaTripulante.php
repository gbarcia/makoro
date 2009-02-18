<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';

$controlBD = new ControlTripulanteLogicaclass();

$resultado = $controlBD->consultarMontoTotal("2009-02-01", "2009-03-31", 81212334);

print $resultado;
?>
