<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';

$controlBD = new ControlVueloLogicaclass();
$vueloPrueba = new Vueloclass();

/* AGREGAR UN VUELO */
$fecha = '2009-05-01';
$hora = '16:00:00';
$avionMatricula = 'YV 302T';
$rutaSitioSalida = 'Maiquetia';
$rutaSitioLlegada = 'Los Roques';

$resultado = $controlBD->nuevoVuelo($fecha, $hora, $avionMatricula, $rutaSitioSalida, $rutaSitioLlegada);
echo $resultado;
/*---------------------------*/

///* ACTUALIZAR VUELO */
//$resultado = $controlBD->actualizarVuelo(11, '2009-05-05', '17:00:00', 'YV 302T', 'Maiquetia', 'Los Roques');
//echo $resultado;
///*---------------------------*/

///* CONSULTAR VUELO ESPECIFICO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Fecha</th>';
//echo '<th>Hora</th>';
//echo '<th>Sitio Salida</th>';
//echo '<th>Sitio Llegada</th>';
//echo '<th>Avion Matricula</th>';
//echo '<th>Asientos Disponibles</th>';
//echo '<th>Piloto</th>';
//echo '<th>Copiloto</th>';
//echo '</tr>';
//$result = $controlBD->vueloEspecificoAsientosReservados('2009-02-01', '07:00:00', 'YV 307T', 'Maiquetia', 'Los Roques');
//while ($row = mysql_fetch_array($result)) {
//    echo '<tr>';
//    echo '<td>' . $row[fecha]. '</td>';
//    echo '<td>' . $row[hora]. '</td>';
//    echo '<td>' . $row[rutaSitioSalida]. '</td>';
//    echo '<td>' . $row[rutaSitioLlegada]. '</td>';
//    echo '<td>' . $row[avionMatricula]. '</td>';
//    echo '<td>' . $row[piloto]. '</td>';
//    echo '<td>' . $row[copiloto]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/
?>
