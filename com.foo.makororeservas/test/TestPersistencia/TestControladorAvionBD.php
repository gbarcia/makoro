<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Avion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorAvionBD.class.php';

$avion = new Avionclass();
$avion->setMatricula('YV 333T');
$avion->getAsientos(50);
$avion->setHabilitado(1);

$controlPrueba = new controladorAvionBDclass();
$resultado = $controlPrueba->agregarAvion($avion);
echo $resultado;


?>
