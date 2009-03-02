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

/* CONSULTAR DETALLES VUELO */
echo '<table border=1>';
echo '<tr>';
echo '<th>cedula</th>';
echo '<th>pasajeroNombre</th>';
echo '<th>pasajeroApellido</th>';
echo '<th>tipoPasajero</th>';
echo '<th>servicio</th>';
echo '<th>encargadoNombre</th>';
echo '<th>tipo</th>';
echo '<th>agencia</th>';
echo '<th>particular</th>';
echo '<th>clienteNombre</th>';
echo '</tr>';
$resultado = $controlBD->consultarVuelosDetalles(9, 1);
    while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row[cedula] . '</td>';
    echo '<td>' . $row[pasajeroNombre] . '</td>';
    echo '<td>' . $row[pasajeroApellido] . '</td>';
    echo '<td>' . $row[tipoPasajero] . '</td>';
    echo '<td>' . $row[servicio] . '</td>';
    echo '<td>' . $row[encargadoNombre] . '</td>';
    echo '<td>' . $row[tipo] . '</td>';
    echo '<td>' . $row[agencia] . '</td>';
    echo '<td>' . $row[particular] . '</td>';
    echo '<td>' . $row[clienteNombre] . '</td>';
    echo '</tr>';
}
echo '</table>';
/*-------------------------------*/

?>
