<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPasajeroBD.class.php';

$pasajero = new Pasajeroclass();
$controlPrueba = new controladorPasajeroBDclass();

///* AGREGAR UN NUEVO PASAJERO */
//$pasajero->setNombre("Laurita");
//$pasajero->setApellido("Pino");
//$pasajero->setSexo("F");
//$pasajero->setCedula("17800900");
//$pasajero->setPasaporte("D-5566441");
//$pasajero->setNacionalidad("Venezolana");
//$pasajero->setTipoPasajeroId("ADL");
//$resultado = $controlPrueba->agregarPasajero($pasajero);
//echo $resultado;
///*---------------------------*/


///* EDITAR PASAJERO */
//$pasajero->setId(15);
//$pasajero->setNombre("Laura");
//$pasajero->setApellido("Pino");
//$pasajero->setSexo("F");
//$pasajero->setCedula("17800900");
//$pasajero->setPasaporte("D-5566441");
//$pasajero->setNacionalidad("Venezolana");
//$pasajero->setTipoPasajeroId("ADL");
//$resultado = $controlPrueba->editarPasajero($pasajero);
//echo $resultado;
///*-----------------*/


///* CONSULTAR PASAJEROS */
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
//$resultado = $controlPrueba->consultarPasajeros();
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['nombre'] . '</td>';
//    echo '<td>' . $row['apellido'] . '</td>';
//    echo '<td>' . $row['sexo'] . '</td>';
//    echo '<td>' . $row['cedula'] . '</td>';
//    echo '<td>' . $row['pasaporte'] . '</td>';
//    echo '<td>' . $row['nacionalidad'] . '</td>';
//    echo '<td>' . $row['tipoPasajeroId'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*---------------------*/


///* BUSCAR PASAJERO POR NOMBRE, APELLIDO, CEDULA, PASAPORTE */
//$busqueda = 'A';
//
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Nombre</th>';
//echo '<th>Apellido</th>';
//echo '<th>Cedula</th>';
//echo '<th>Pasaporte</th>';
//echo '</tr>';
//$resultado = $controlPrueba->consultarPasajeroNombreApellidoCedulaPasaporte($busqueda);
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['nombre'] . '</td>';
//    echo '<td>' . $row['apellido'] . '</td>';
//    echo '<td>' . $row['cedula'] . '</td>';
//    echo '<td>' . $row['pasaporte'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*---------------------------------------------------------*/



///* BUSCAR PASAJEROS CON VIAJES REALIZADOS SEGUN LA FECHA */
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
//$resultado = $controlPrueba->consultarPasajerosConViajesRealizados($fechaini, $fechafin);
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['cedula'] . '</td>';
//    echo '<td>' . $row['pasaporte'] . '</td>';
//    echo '<td>' . $row['nombre'] . '</td>';
//    echo '<td>' . $row['apellido'] . '</td>';
//    echo '<td>' . $row['tipo'] . '</td>';
//    echo '<td>' . $row['fecha'] . '</td>';
//    echo '<td>' . $row['hora'] . '</td>';
//    echo '<td>' . $row['RUTA_sitioSalida'] . '</td>';
//    echo '<td>' . $row['RUTA_sitioLlegada'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------------------------------*/
?>
