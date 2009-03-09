<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloReserva.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloReservaBD.class.php';

$vueloReserva = new VueloReservaclass();
$controlPrueba = new controladorVueloReservaBDclass();

$vueloReserva->setVueloid(4);
$vueloReserva->setReservaid(29);
$vueloReserva->setTipo("IDA");
$resultado = $controlPrueba->agregarVueloReserva($vueloReserva);
echo $resultado;

?>
