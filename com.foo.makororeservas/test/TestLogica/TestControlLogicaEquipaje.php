<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlEquipajeLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Equipaje.class.php';

$controlBD = new ControlEquipajeLogicaclass();
$equipajePrueba = new Equipajeclass();

///* NUEVO EQUIPAJE */
//$descripcion = "TABLA SURF";
//$tipo = "DE MANO";
//$peso = 100.0;
//$reservaId = 2;
//$resultado = $controlBD->nuevoEquipajePasajero($descripcion, $tipo, $peso, $reservaId);
//echo $resultado;
///*-----------------------*/

/* EQUIPAJE RELACIONADO CON UNA RESERVA */
$resultado = $controlBD->buscarEquipajePasajeroPorReserva(2);
echo $resultado;
/*--------------------------------------*/
?>
