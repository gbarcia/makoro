<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoCargo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoCargoBD.class.php';

$tipoCargo = new TipoCargoclass();
$tipoCargo->setCargo('AZAFATO');
$tipoCargo->setDescripcion('Tipo que indica instrucciones durante el vuelo');

$controlPrueba = new controladorTipoCargoBDclass();
$resultado = $controlPrueba->agregarTipoCargo($tipoCargo);

?>
