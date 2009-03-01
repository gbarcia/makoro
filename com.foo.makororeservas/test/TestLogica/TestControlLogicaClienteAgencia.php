<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlClienteAgenciaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteAgencia.class.php';

$controlBD = new ControlClienteAgenciaLogicaclass();
$clienteAgenciaPrueba = new ClienteAgenciaclass();

///* NUEVO CLIENTE AGENCIA */
//$resultado = $controlBD->nuevoClienteAgencia("J-112233", "XEROX", "2233445", "Chacao", "Dtto Capital", "Caracas", 0);
//echo $resultado;
///*-----------------------*/


///* EDITAR CLIENTE AGENCIA */
//$resultado = $controlBD->actualizarClienteAgencia("J-112233", "XEROX", "2003040", "Chacaito", "Dtto Capital", "Caracas", 0.35);
//echo $resultado;
///*-----------------------*/


///* BUSCAR CLIENTE AGENCIA POR RIF Y NOMBRE*/
//$busqueda = 'x';
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Rif</th>';
//echo '<th>Nombre</th>';
//echo '</tr>';
//$result = $controlBD->busquedaClienteAgenciaRifNombre($busqueda);
//while ($row = mysql_fetch_array($result)) {
//    echo '<tr>';
//    echo '<td>' . $row[rif]. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*----------------------------------------*/


///* BUSCAR CLIENTES AGENCIAS CON MAS VUELOS */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Rif</th>';
//echo '<th>Nombre</th>';
//echo '<th>Telefono</th>';
//echo '<th>Direccion</th>';
//echo '<th>Estado</th>';
//echo '<th>Ciudad</th>';
//echo '<th>Porcentaje Comision</th>';
//echo '<th>Cantidad de vuelos</th>';
//echo '</tr>';
//$resultado = $controlBD->busquedaClienteAgenciaConMasVuelos();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[rif]. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[telefono]. '</td>';
//    echo '<td>' . $row[direccion]. '</td>';
//    echo '<td>' . $row[estado]. '</td>';
//    echo '<td>' . $row[ciudad]. '</td>';
//    echo '<td>' . $row[porcentajeComision]. '</td>';
//    echo '<td>' . $row[cnt]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-----------------------------------------*/


///* CONSULTAR CLIENTES AGENCIAS CON VUELOS EN ORDEN DESCENDENTE */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Rif</th>';
//echo '<th>Nombre</th>';
//echo '<th>Telefono</th>';
//echo '<th>Direccion</th>';
//echo '<th>Estado</th>';
//echo '<th>Ciudad</th>';
//echo '<th>Porcentaje Comision</th>';
//echo '<th>Cantidad de vuelos</th>';
//echo '</tr>';
//$resultado = $controlBD->busquedaClientesAgenciasVuelosDescendente();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[rif]. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[telefono]. '</td>';
//    echo '<td>' . $row[direccion]. '</td>';
//    echo '<td>' . $row[estado]. '</td>';
//    echo '<td>' . $row[ciudad]. '</td>';
//    echo '<td>' . $row[porcentajeComision]. '</td>';
//    echo '<td>' . $row[cnt]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*--------------------------------------------------*/


///* BUSCAR CLIENTES AGENCIAS POR PAGAR */
//    echo '<table border=1>';
//    echo '<tr>';
//    echo '<th>Rif</th>';
//    echo '<th>Nombre</th>';
//    echo '<th>Telefono</th>';
//    echo '<th>Direccion</th>';
//    echo '<th>Estado</th>';
//    echo '<th>Ciudad</th>';
//    echo '<th>Porcentaje Comision</th>';
//    echo '<th>Fecha</th>';
//    echo '</tr>';
//    $Coleccion = $controlBD->busquedaClientesAgenciasPorPagar('2008-01-01', '2009-12-31');
//    while ($row = mysql_fetch_array($Coleccion)) {
//        echo '<tr>';
//        echo '<td>' . $row[rif]. '</td>';
//        echo '<td>' . $row[nombre]. '</td>';
//        echo '<td>' . $row[telefono]. '</td>';
//        echo '<td>' . $row[direccion]. '</td>';
//        echo '<td>' . $row[estado] . '</td>';
//        echo '<td>' . $row[ciudad]. '</td>';
//        echo '<td>' . $row[porcentajeComision]. '</td>';
//        echo '<td>' . $row[fecha]. '</td>';
//        echo '</tr>';
//    }
//    echo '</table>';
///*------------------------------------*/
?>
