<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/AsientosDisponiblesVueloTripulacion.class.php';

$controlBD = new ControlVueloLogicaclass();
$vueloPrueba = new Vueloclass();

///* AGREGAR UN VUELO */
//$fecha = '2009-05-01';
//$hora = '16:00:00';
//$avionMatricula = 'YV 302T';
//$rutaSitioSalida = 'Maiquetia';
//$rutaSitioLlegada = 'Los Roques';
//
//$resultado = $controlBD->nuevoVuelo($fecha, $hora, $avionMatricula, $rutaSitioSalida, $rutaSitioLlegada);
//echo $resultado;
///*---------------------------*/

///* ACTUALIZAR VUELO */
//$resultado = $controlBD->actualizarVuelo(11, '2009-05-05', '17:00:00', 'YV 302T', 'Maiquetia', 'Los Roques');
//echo $resultado;
///*---------------------------*/

///* CONSULTAR VUELO ESPECIFICO */
//$Coleccion = $controlBD->vueloEspecificoAsientosReservados('2009-02-01', '07:00:00', 'YV 307T', 'Maiquetia', 'Los Roques');
//foreach ($Coleccion as $var) {
//    $recursoDetalles = $var->getColeccionVuelo();
//    $cantidadDisponible = $var->getAsientosDisponibles();
//    $piloto = $var->getPiloto();
//    $copiloto = $var->getCopiloto();
//
//    echo "\n";
//    echo '<table border=1>';
//    echo '<tr>';
//    echo '<th>Fecha</th>';
//    echo '<th>Hora</th>';
//    echo '<th>Sitio Salida</th>';
//    echo '<th>Sitio Llegada</th>';
//    echo '<th>Avion Matricula</th>';
//    echo '<th>Asientos Disponibles</th>';
//    echo '<th>Piloto</th>';
//    echo '<th>Copiloto</th>';
//    echo '</tr>';
//
//    echo '<tr>';
//    echo '<td>' . $recursoDetalles->getFecha(). '</td>';
//    echo '<td>' . $recursoDetalles->getHora(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
//    echo '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
//    echo '<td>' . $cantidadDisponible. '</td>';
//    echo '<td>' . $piloto. '</td>';
//    echo '<td>' . $copiloto. '</td>';
//    echo '</tr>';
//    echo '</table>';
//}
///*-------------------------------*/

///* CONSULTAR TODOS LOS VUELOS REALIZADOS */
//echo '<table border=1>';
//echo '<tr>';
//    echo '<th>Fecha</th>';
//    echo '<th>Hora</th>';
//    echo '<th>Sitio Salida</th>';
//    echo '<th>Sitio Llegada</th>';
//    echo '<th>Avion Matricula</th>';
//echo '</tr>';
//$result = $controlBD->vuelosRealizados();
//while ($row = mysql_fetch_array($result)) {
//    echo '<tr>';
//    echo '<td>' . $row[fecha]. '</td>';
//    echo '<td>' . $row[hora]. '</td>';
//    echo '<td>' . $row[RUTA_sitioSalida]. '</td>';
//    echo '<td>' . $row[RUTA_sitioLlegada] . '</td>';
//    echo '<td>' . $row[avionMatricula]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/


/* CONSULTAR TODOS LOS VUELOS CON LOS ASIENTOS DISPONIBLES*/
$Coleccion = $controlBD->vuelosCantidadAsientosDisponibles();
foreach ($Coleccion as $var) {
    $recursoDetalles = $var->getColeccionVuelo();
    $cantidadDisponible = $var->getAsientosDisponibles();
    $piloto = $var->getPiloto();
    $copiloto = $var->getCopiloto();

    echo "\n";
    echo '<table border=1>';
    echo '<tr>';
    echo '<th>Fecha</th>';
    echo '<th>Hora</th>';
    echo '<th>Sitio Salida</th>';
    echo '<th>Sitio Llegada</th>';
    echo '<th>Avion Matricula</th>';
    echo '<th>Asientos Disponibles</th>';
    echo '<th>Piloto</th>';
    echo '<th>Copiloto</th>';
    echo '</tr>';
while ($row = mysql_fetch_array($recursoDetalles)) {
    echo '<tr>';
    echo '<td>' . $row[fecha]. '</td>';
    echo '<td>' . $row[hora]. '</td>';
    echo '<td>' . $row[rutaSitioSalida]. '</td>';
    echo '<td>' . $row[rutaSitioLLegada]. '</td>';
    echo '<td>' . $row[avionMatricula]. '</td>';
    echo '<td>' . $cantidadDisponible. '</td>';
    echo '<td>' . $piloto. '</td>';
    echo '<td>' . $copiloto. '</td>';
    echo '</tr>';
}
    echo '</table>';
}
/*-------------------------------*/

?>
