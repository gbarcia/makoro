<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorRutaBD.class.php';

$ruta = new Rutaclass();
$ruta->setId(6);
$ruta->setSitioSalida('MARACAIBO');
$ruta->setSitioLlegada('BOGOTA');
$ruta->setAbreviaturaSalida('MCB');
$ruta->setAbreviaturaLlegada('BOG');
$ruta->setTiempo(0.50);
$ruta->setGeneraIVA(0);

$controlPrueba = new controladorRutaBDclass();
//$result = $controlPrueba->agregarRuta($ruta);
$result = $controlPrueba->editarRuta($ruta);
echo $result;

?>
