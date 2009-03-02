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
//$Coleccion = $controlBD->vueloEspecificoAsientosReservados('2009-05-01', '16:00:00', 'YV 302T', 'Maiquetia', 'Los Roques');
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

/* CONSULTAR DETALLES VUELO */
echo '<table border=1>';
echo '<tr>';
echo '<th>id</th>';
echo '<th>tipoPasajero</th>';
echo '<th>pasajero</th>';
echo '<th>servicio</th>';
echo '<th>encargadoNombre</th>';
echo '<th>tipo</th>';
echo '<th>agencia</th>';
echo '<th>particular</th>';
echo '<th>clienteNombre</th>';
echo '<th>pago</th>';
echo '<th>banco</th>';
echo '<th>numeroTran</th>';
echo '<th>monto</th>';
echo '<th>boleto</th>';
echo '</tr>';
$resultado = $controlBD->consultarVuelosDetalles(9, 1);
    while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row[id] . '</td>';
    echo '<td>' . $row[tipoPasajero] . '</td>';
    echo '<td>' . $row[pasajero] . '</td>';
    echo '<td>' . $row[servicio] . '</td>';
    echo '<td>' . $row[encargadoNombre] . '</td>';
    echo '<td>' . $row[tipo] . '</td>';
    echo '<td>' . $row[agencia] . '</td>';
    echo '<td>' . $row[particular] . '</td>';
    echo '<td>' . $row[clienteNombre] . '</td>';
    echo '<td>' . $row[pago] . '</td>';
    echo '<td>' . $row[banco] . '</td>';
    echo '<td>' . $row[numeroTran] . '</td>';
    echo '<td>' . $row[monto] . '</td>';
    echo '<td>' . $row[boleto] . '</td>';
    echo '</tr>';
}
echo '</table>';
/*-------------------------------*/


///* CONSULTAR VUELOS APARTIR DE HOY*/
//    echo "\n";
//    echo "\n";
//    echo "\n";
//    echo "\n";
//    echo '<table border=1>';
//    echo '<tr>';
//    echo '<th>Id</th>';
//    echo '<th>Fecha</th>';
//    echo '<th>Hora</th>';
//    echo '<th>Sitio Salida</th>';
//    echo '<th>Sitio Llegada</th>';
//    echo '<th>Avion Matricula</th>';
//    echo '<th>Asientos Disponibles</th>';
//    echo '<th>Piloto</th>';
//    echo '<th>Copiloto</th>';
//    echo '</tr>';
//$Coleccion = $controlBD->vuelosCantidadAsientosDisponibles();
//foreach ($Coleccion as $var) {
//    $recursoDetalles = $var->getColeccionVuelo();
//    $cantidadDisponible = $var->getAsientosDisponibles();
//    $piloto = $var->getPiloto();
//    $copiloto = $var->getCopiloto();
//
//    echo '<tr>';
//    echo '<td>' . $recursoDetalles->getId(). '</td>';
//    echo '<td>' . $recursoDetalles->getFecha(). '</td>';
//    echo '<td>' . $recursoDetalles->getHora(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
//    echo '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
//    echo '<td>' . $cantidadDisponible. '</td>';
//    echo '<td>' . $piloto. '</td>';
//    echo '<td>' . $copiloto. '</td>';
//    echo '</tr>';
//}
//    echo '</table>';
/*-------------------------------*/

///* CONSULTAR VUELO REALIZADOS */
//    echo "\n";
//    echo "\n";
//    echo "\n";
//    echo "\n";
//    echo '<table border=1>';
//    echo '<tr>';
//    echo '<th>Id</th>';
//    echo '<th>Fecha</th>';
//    echo '<th>Hora</th>';
//    echo '<th>Sitio Salida</th>';
//    echo '<th>Sitio Llegada</th>';
//    echo '<th>Avion Matricula</th>';
//    echo '<th>Asientos Disponibles</th>';
//    echo '<th>Piloto</th>';
//    echo '<th>Copiloto</th>';
//    echo '</tr>';
//    $Coleccion = $controlBD->vuelosRealizados();
//foreach ($Coleccion as $var) {
//    $recursoDetalles = $var->getColeccionVuelo();
//    $cantidadDisponible = $var->getAsientosDisponibles();
//    $piloto = $var->getPiloto();
//    $copiloto = $var->getCopiloto();
//
//    echo '<tr>';
//    echo '<td>' . $recursoDetalles->getId(). '</td>';
//    echo '<td>' . $recursoDetalles->getFecha(). '</td>';
//    echo '<td>' . $recursoDetalles->getHora(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
//    echo '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
//    echo '<td>' . $cantidadDisponible. '</td>';
//    echo '<td>' . $piloto. '</td>';
//    echo '<td>' . $copiloto. '</td>';
//    echo '</tr>';
//}
//    echo '</table>';
///*-------------------------------*/

?>
