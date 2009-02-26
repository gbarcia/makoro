<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTipoServicioLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoServicio.class.php';

$controlBD = new ControlTipoServicioLogicaclass();
$servicioPrueba = new TipoServicioclass();

///* AGREGAR UN SERVICIO */
//$resultado = $controlBD->nuevoTipoServicio("ER");
//echo $resultado;
///*---------------------------*/

///* ACTUALIZAR SERVICIO */
//$resultado = $controlBD->actualizarTipoServicio(7, "MM");
//echo $resultado;
///*---------------------------*/

///* CONSULTAR SERVICIO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Tipo</th>';
//echo '</tr>';
//$result = $controlBD->consultarServicios();
//while ($row = mysql_fetch_array($result)) {
//    echo '<tr>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/

///* CONSULTAR INFORMACION SERVICIO SELECCIONADO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Id</th>';
//echo '<th>Tipo</th>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarInformacionServicio("IV");
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[id]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '</tr>';
//}
//
//echo '</table>';
///*---------------------------------------------------------*/

///* CONSULTAR SERVICIO MAS SOLICITADO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Id</th>';
//echo '<th>Tipo</th>';
//echo '<th>Cantidad</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarServicioMasSolicitado();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[id]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '<td>' . $row[cantidad]. '</td>';
//    echo '</tr>';
//}
//
//echo '</table>';
///*---------------------------------------------------------*/


///* CONSULTAR SERVICIOS MAS SOLICITADOS DESCENDENTEMENTE*/
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Id</th>';
//echo '<th>Tipo</th>';
//echo '<th>Cantidad</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarServicioMasSolicitadoDesc();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[id]. '</td>';
//    echo '<td>' . $row[tipo]. '</td>';
//    echo '<td>' . $row[cantidad]. '</td>';
//    echo '</tr>';
//}
//
//echo '</table>';
///*---------------------------------------------------------*/

?>
