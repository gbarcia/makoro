<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPagoBD.class.php';

$pago = new Pagoclass();
$controlPrueba = new controladorPagoBDclass();

///* AGREGAR PAGO */
//$pago->setTipo("T");
//$pago->setMonto(3.3);
//$pago->setNombreBanco("Federal");
//$pago->setNumeroTransaccion(4686435);
//$resultado = $controlPrueba->agregarMoneda($pago);
///*----------------*/


///* EDITAR PAGO */
//$pago->setId(9);
//$pago->setTipo("T");
//$pago->setMonto(5.8);
//$pago->setNombreBanco("Federal");
//$pago->setNumeroTransaccion(4686437);
//$resultado = $controlPrueba->editarPago($pago);
///*---------------*/


?>
