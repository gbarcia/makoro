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

/* CONSULTAR VUELO ESPECIFICO CON FILTROS */
//($fechaInicio, $fechaFin, $hora, $avionMatricula, $rutaSitioSalida, $rutaSitioLlegada, $cantidadAdultosNinos, $cantidadInfantes, $cedulaPasaporte, $nombrePasajero, $apellidoPasajero, $cedulaPart, $nombrePart, $apellidoPart, $rifAgencia, $nombreAgencia, $solicitud, $estado)
$Coleccion = $controlBD->vueloEspecificoConFiltro('2008-01-01', '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '');
foreach ($Coleccion as $var) {
    $recursoDetalles = $var->getColeccionVuelo();
    $cantidadDisponible = $var->getAsientosDisponibles();
    $piloto = $var->getPiloto();
    $copiloto = $var->getCopiloto();
    $disponibilidadAdulto = $var->getDisponibilidadadulto();
    $disponibilidadInfante = $var->getDisponibilidadinfante();
    $idVuelo = $var->getIdvuelo();
    $cantInfantes = $var->getCantinfantesquedan();

    echo "\n";
    echo '<table border=1>';
    echo '<tr>';
    echo '<th>Id</th>';
    echo '<th>Fecha</th>';
    echo '<th>Hora</th>';
    echo '<th>Sitio Salida</th>';
    echo '<th>Sitio Llegada</th>';
    echo '<th>Avion Matricula</th>';
    echo '<th>Asientos Disponibles</th>';
    echo '<th>InfantesQuedan</th>';
    echo '<th>Piloto</th>';
    echo '<th>Copiloto</th>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>' . $idVuelo. '</td>';
    echo '<td>' . $recursoDetalles->getFecha(). '</td>';
    echo '<td>' . $recursoDetalles->getHora(). '</td>';
    echo '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
    echo '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
    echo '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
    echo '<td>' . $cantidadDisponible. '</td>';
    echo '<td>' . $cantInfantes. '</td>';
    echo '<td>' . $piloto. '</td>';
    echo '<td>' . $copiloto. '</td>';
    echo '</tr>';
    echo '</table>';
}
/*-------------------------------*/

///* CONSULTAR VUELO ESPECIFICO SIN FILTRO */
////($fechaInicio,$fechaFin,$hora,$avionMatricula,$rutaSitioSalida,$rutaSitioLlegada,$capacidad,$cedulaPasaporte,$nombrePasajero,$apellidoPasajero,$cedulaPart,$nombrePart,$apellidoPart,$rifAgencia,$nombreAgencia)
//$Coleccion = $controlBD->vueloEspecificoSinFiltro('2008-01-01', '2010-05-31');
//foreach ($Coleccion as $var) {
//    $recursoDetalles = $var->getColeccionVuelo();
//    $cantidadDisponible = $var->getAsientosDisponibles();
//    $piloto = $var->getPiloto();
//    $copiloto = $var->getCopiloto();
//    $disponibilidadAdulto = $var->getDisponibilidadadulto();
//    $disponibilidadInfante = $var->getDisponibilidadinfante();
//    $cantInfantesQuedan = $var->getCantinfantesquedan();
//    $idVuelo = $var->getIdvuelo();
//
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
//    echo '<th>CantInfantesQuedan</th>';
//    echo '<th>Piloto</th>';
//    echo '<th>Copiloto</th>';
//    echo '</tr>';
//
//    echo '<tr>';
//    echo '<td>' . $idVuelo. '</td>';
//    echo '<td>' . $recursoDetalles->getFecha(). '</td>';
//    echo '<td>' . $recursoDetalles->getHora(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
//    echo '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
//    echo '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
//    echo '<td>' . $cantidadDisponible. '</td>';
//    echo '<td>' . $cantInfantesQuedan. '</td>';
//    echo '<td>' . $piloto. '</td>';
//    echo '<td>' . $copiloto. '</td>';
//    echo '</tr>';
//    echo '</table>';
//}
///*-------------------------------*/


//falta probarlo
///* CONSULTAR VUELOS POR FECHA Y RUTAS */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Id</th>';
//echo '<th>Fecha</th>';
//echo '<th>Hora</th>';
//echo '<th>Ruta Salida</th>';
//echo '<th>Ruta Retorno</th>';
//echo '<th>Avion Matricula</th>';
//echo '</tr>';
//$resultado = $controlBD->buscarVuelosPorFechaRutas('L', '2009-03-15');
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[id] . '</td>';
//    echo '<td>' . $row[fecha] . '</td>';
//    echo '<td>' . $row[hora] . '</td>';
//    echo '<td>' . $row[rutaSalida] . '</td>';
//    echo '<td>' . $row[rutaLlegada] . '</td>';
//    echo '<td>' . $row[matricula] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/


///* CONSULTAR DETALLES VUELO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>solicitud</th>';
//echo '<th>tipoPasajero</th>';
//echo '<th>pasajero</th>';
//echo '<th>servicio</th>';
//echo '<th>encargadoNombre</th>';
//echo '<th>sucursal</th>';
//echo '<th>tipo</th>';
//echo '<th>agencia</th>';
//echo '<th>particular</th>';
//echo '<th>clienteNombre</th>';
//echo '<th>pago</th>';
//echo '<th>banco</th>';
//echo '<th>numeroTran</th>';
//echo '<th>monto</th>';
//echo '<th>boleto</th>';
//echo '<th>vueloRetorno</th>';
//echo '<th>posada</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarVuelosDetalles(2);
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[solicitud] . '</td>';
//    echo '<td>' . $row[tipoPasajero] . '</td>';
//    echo '<td>' . $row[pasajero] . '</td>';
//    echo '<td>' . $row[servicio] . '</td>';
//    echo '<td>' . $row[encargadoNombre] . '</td>';
//    echo '<td>' . $row[sucursal] . '</td>';
//    echo '<td>' . $row[tipo] . '</td>';
//    echo '<td>' . $row[agencia] . '</td>';
//    echo '<td>' . $row[particular] . '</td>';
//    echo '<td>' . $row[clienteNombre] . '</td>';
//    echo '<td>' . $row[pago] . '</td>';
//    echo '<td>' . $row[banco] . '</td>';
//    echo '<td>' . $row[numeroTran] . '</td>';
//    echo '<td>' . $row[monto] . '</td>';
//    echo '<td>' . $row[boleto] . '</td>';
//    echo '<td>' . $row[vueloRetorno] . '</td>';
//    echo '<td>' . $row[posada] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/

///* CONSULTAR INFORMACION VUELO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>fecha</th>';
//echo '<th>hora</th>';
//echo '<th>sitioSalida</th>';
//echo '<th>sitioLlegada</th>';
//echo '<th>matricula</th>';
//echo '<th>adlChlQuedan</th>';
//echo '<th>infQuedan</th>';
//echo '<th>piloto</th>';
//echo '<th>copiloto</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarInformacionVuelo(1);
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[fecha] . '</td>';
//    echo '<td>' . $row[hora] . '</td>';
//    echo '<td>' . $row[sitioSalida] . '</td>';
//    echo '<td>' . $row[sitioLlegada] . '</td>';
//    echo '<td>' . $row[matricula] . '</td>';
//    echo '<td>' . $row[adlChlQuedan] . '</td>';
//    echo '<td>' . $row[infQuedan] . '</td>';
//    echo '<td>' . $row[piloto] . '</td>';
//    echo '<td>' . $row[copiloto] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/

///* CONSULTAR CIENTE CON MAS VUELOS */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>id</th>';
//echo '<th>particular</th>';
//echo '<th>agencia</th>';
//echo '<th>cliente</th>';
//echo '<th>cantidad</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarClientesMasVuelos(1, '2009-01-01', '2009-05-31');
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[id] . '</td>';
//    echo '<td>' . $row[particular] . '</td>';
//    echo '<td>' . $row[agencia] . '</td>';
//    echo '<td>' . $row[cliente] . '</td>';
//    echo '<td>' . $row[cantidad] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------------------*/


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

///* CALCULO DE HORAS DE VUELO */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Horas de Vuelo</th>';
//echo '</tr>';
//$resultado = $controlBD->sumaHorasDeVuelos();
//    echo '<tr>';
//    echo '<td>' . $resultado . '</td>';
//    echo '</tr>';
//
//echo '</table>';
///*---------------------------*/
//esFechaValida($fechaVuelo, $fechaActual, $horaVuelo, $horaActual)
//$controlBD->esFechaValida('2010-12-31', '2009-01-01', '00:00:00', '10:00:00');

?>
