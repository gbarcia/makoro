<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlEquipajeLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Equipaje.class.php';

$controlBD = new ControlEquipajeLogicaclass();
$equipajePrueba = new Equipajeclass();

///* NUEVO EQUIPAJE */
//$descripcion = "MALETIN";
//$tipo = "M";
//$peso = 5.5;
//$reservaId = 4;
//$resultado = $controlBD->nuevoEquipajePasajero($descripcion, $tipo, $peso, $reservaId);
//echo $resultado;
///////*-----------------------*/

///* ACTUALIZAR EQUIPAJE */
//$id = 2;
//$descripcion = "PERRO";
//$tipo = "A";
//$peso = 7.3;
//$idReserva = 3;
//$resultado = $controlBD->actualizarEquipaje($id, $descripcion, $tipo, $peso, $idReserva);
//echo $resultado;
///////*-----------------------*/

///* EQUIPAJE RELACIONADO CON UNA RESERVA */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Descripcion</th>';
//echo '<th>Tipo</th>';
//echo '<th>Peso</th>';
//echo '</tr>';
//$resultado = $controlBD->buscarEquipajePasajeroPorReserva(3);
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[descripcion]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '<td>' . $row[peso]. '</td>';
//}
//echo '</table>';
///*--------------------------------------*/

/* CONSULTAR TODOS LOS EQUIPAJES */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Descripcion</th>';
//echo '<th>Tipo</th>';
//echo '<th>Peso</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarTodosLosEquipajes();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[descripcion]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '<td>' . $row[peso]. '</td>';
//}
//echo '</table>';
///*-----------------------------------------*/

///* CONSULTAR TODOS LOS EQUIPAJES POR VUELO */
//$idVuelo = 1;
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Descripcion</th>';
//echo '<th>Tipo</th>';
//echo '<th>Peso</th>';
//echo '<th>Reserva</th>';
//echo '<th>Estado</th>';
//echo '<th>Solicitud</th>';
//echo '<th>idPasajero</th>';
//echo '<th>Nombre</th>';
//echo '<th>Apellido</th>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '<th>Nacionalidad</th>';
//echo '<th>idTipoPasajero</th>';
//echo '<th>fecha</th>';
//echo '<th>hora</th>';
//echo '<th>sitioSalida</th>';
//echo '<th>sitioLlegada</th>';
//echo '<th>abreviaturaSalida</th>';
//echo '<th>abreviaturaLlegada</th>';
//echo '<th>Ruta</th>';
//echo '</tr>';
//$resultado = $controlBD->equipajePorVuelo($idVuelo);
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[descripcion]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '<td>' . $row[peso]. '</td>';
//    echo '<td>' . $row[idReserva]. '</td>';
//    echo '<td>' . $row[estado]. '</td>';
//    echo '<td>' . $row[solicitud]. '</td>';
//    echo '<td>' . $row[idPasajero]. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[apellido]. '</td>';
//    echo '<td>' . $row[cedula]. '</td>';
//    echo '<td>' . $row[pasaporte]. '</td>';
//    echo '<td>' . $row[nacionalidad]. '</td>';
//    echo '<td>' . $row[idTipoPasajero]. '</td>';
//    echo '<td>' . $row[fecha]. '</td>';
//    echo '<td>' . $row[hora]. '</td>';
//    echo '<td>' . $row[sitioSalida]. '</td>';
//    echo '<td>' . $row[sitioLlegada]. '</td>';
//    echo '<td>' . $row[abreviaturaSalida]. '</td>';
//    echo '<td>' . $row[abreviaturaLlegada]. '</td>';
//    echo '<td>' . $row[ruta]. '</td>';
//}
//echo '</table>';
///*-----------------------------------------*/


/////* CONSULTAR TODOS LOS EQUIPAJES PASAJERO VUELO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Descripcion</th>';
//echo '<th>Tipo</th>';
//echo '<th>Peso</th>';
//echo '<th>Reserva</th>';
//echo '<th>Estado</th>';
//echo '<th>Solicitud</th>';
//echo '<th>idPasajero</th>';
//echo '<th>Nombre</th>';
//echo '<th>Apellido</th>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '<th>Nacionalidad</th>';
//echo '<th>idTipoPasajero</th>';
//echo '<th>fecha</th>';
//echo '<th>hora</th>';
//echo '<th>sitioSalida</th>';
//echo '<th>sitioLlegada</th>';
//echo '<th>abreviaturaSalida</th>';
//echo '<th>abreviaturaLlegada</th>';
//echo '<th>Ruta</th>';
//echo '</tr>';
//$resultado = $controlBD->equipajeReservaPasajeroVuelo();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[descripcion]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '<td>' . $row[peso]. '</td>';
//    echo '<td>' . $row[idReserva]. '</td>';
//    echo '<td>' . $row[estado]. '</td>';
//    echo '<td>' . $row[solicitud]. '</td>';
//    echo '<td>' . $row[idPasajero]. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[apellido]. '</td>';
//    echo '<td>' . $row[cedula]. '</td>';
//    echo '<td>' . $row[pasaporte]. '</td>';
//    echo '<td>' . $row[nacionalidad]. '</td>';
//    echo '<td>' . $row[idTipoPasajero]. '</td>';
//    echo '<td>' . $row[fecha]. '</td>';
//    echo '<td>' . $row[hora]. '</td>';
//    echo '<td>' . $row[sitioSalida]. '</td>';
//    echo '<td>' . $row[sitioLlegada]. '</td>';
//    echo '<td>' . $row[abreviaturaSalida]. '</td>';
//    echo '<td>' . $row[abreviaturaLlegada]. '</td>';
//    echo '<td>' . $row[ruta]. '</td>';
//}
//echo '</table>';
/////*-----------------------------------------*/


///* CONSULTAR TODOS LOS EQUIPAJES PASAJERO VUELO */
//$cedulaOPasaporte = "D-3647657";
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Descripcion</th>';
//echo '<th>Tipo</th>';
//echo '<th>Peso</th>';
//echo '<th>Reserva</th>';
//echo '<th>Estado</th>';
//echo '<th>Solicitud</th>';
//echo '<th>idPasajero</th>';
//echo '<th>Nombre</th>';
//echo '<th>Apellido</th>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '<th>Nacionalidad</th>';
//echo '<th>idTipoPasajero</th>';
//echo '<th>fecha</th>';
//echo '<th>hora</th>';
//echo '<th>sitioSalida</th>';
//echo '<th>sitioLlegada</th>';
//echo '<th>abreviaturaSalida</th>';
//echo '<th>abreviaturaLlegada</th>';
//echo '<th>Ruta</th>';
//echo '</tr>';
//$resultado = $controlBD->equipajeDePasajero($cedulaOPasaporte);
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[descripcion]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '<td>' . $row[peso]. '</td>';
//    echo '<td>' . $row[idReserva]. '</td>';
//    echo '<td>' . $row[estado]. '</td>';
//    echo '<td>' . $row[solicitud]. '</td>';
//    echo '<td>' . $row[idPasajero]. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[apellido]. '</td>';
//    echo '<td>' . $row[cedula]. '</td>';
//    echo '<td>' . $row[pasaporte]. '</td>';
//    echo '<td>' . $row[nacionalidad]. '</td>';
//    echo '<td>' . $row[idTipoPasajero]. '</td>';
//    echo '<td>' . $row[fecha]. '</td>';
//    echo '<td>' . $row[hora]. '</td>';
//    echo '<td>' . $row[sitioSalida]. '</td>';
//    echo '<td>' . $row[sitioLlegada]. '</td>';
//    echo '<td>' . $row[abreviaturaSalida]. '</td>';
//    echo '<td>' . $row[abreviaturaLlegada]. '</td>';
//    echo '<td>' . $row[ruta]. '</td>';
//}
//echo '</table>';
//*-----------------------------------------*/



?>
