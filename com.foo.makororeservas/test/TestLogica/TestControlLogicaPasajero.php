<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlPasajeroLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';

$controlBD = new ControlPasajeroLogicaclass();
$pasajeroprueba = new Pasajeroclass();

///* AGREGAR UN NUEVO PASAJERO */
//$resultado = $controlBD->nuevoPasajero("Andres", "Lopez", "M", 83456765, "D-1987654","Colombiano", "ADL");
//echo $resultado;
///*---------------------------*/


///* ACTUALIZAR PASAJERO */
//$resultado = $controlBD->actualizarPasajero(16,"Andy", "Lopez", 83456765, "D-1987654","Colombiano", "ADL");
//echo $resultado;
///*---------------------------*/


///* CONSULTAR TODOS LOS PASAJEROS */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Nombre</th>';
//echo '<th>Apellido</th>';
//echo '<th>Sexo</th>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '<th>Nacionalidad</th>';
//echo '<th>Tipo Pasajero</th>';
//echo '</tr>';
//$result = $controlBD->busquedaPasajeros();
//while ($row = mysql_fetch_array($result)) {
//    echo '<tr>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[apellido]. '</td>';
//    echo '<td>' . $row[sexo]. '</td>';
//    echo '<td>' . $row[cedula] . '</td>';
//    echo '<td>' . $row[pasaporte]. '</td>';
//    echo '<td>' . $row[nacionalidad]. '</td>';
//    echo '<td>' . $row[TIPO_PASAJERO_id]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/


///* BUSCAR PASAJERO POR NOMBRE, APELLIDO, CEDULA, PASAPORTE */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Nombre</th>';
//echo '<th>Apellido</th>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '</tr>';
//$resultado = $controlBD->busquedaPasajeroNombreApellidoCedulaPasaporte('A');
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[apellido]. '</td>';
//    echo '<td>' . $row[cedula]. '</td>';
//    echo '<td>' . $row[pasaporte]. '</td>';
//    echo '</tr>';
//}
//
//echo '</table>';
///*---------------------------------------------------------*/

//
///* BUSCAR PASAJERO CON VIAJES REALIZADOS */
//$fechaini = '2009-02-01';
//$fechafin = '2009-02-10';
//
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '<th>Nombre</th>';
//echo '<th>Apellido</th>';
//echo '<th>Tipo Viaje</th>';
//echo '<th>Fecha Viaje</th>';
//echo '<th>Hora Viaje</th>';
//echo '<th>Sitio Salida</th>';
//echo '<th>Sitio Llegada</th>';
//echo '</tr>';
//$resultado = $controlBD->busquedaPasajerosConViajesRealizados($fechaini, $fechafin);
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[cedula] . '</td>';
//    echo '<td>' . $row[pasaporte] . '</td>';
//    echo '<td>' . $row[nombre] . '</td>';
//    echo '<td>' . $row[apellido] . '</td>';
//    echo '<td>' . $row[tipo] . '</td>';
//    echo '<td>' . $row[fecha] . '</td>';
//    echo '<td>' . $row[hora] . '</td>';
//    echo '<td>' . $row[RUTA_sitioSalida] . '</td>';
//    echo '<td>' . $row[RUTA_sitioLlegada] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*---------------------------------------*/
?>
