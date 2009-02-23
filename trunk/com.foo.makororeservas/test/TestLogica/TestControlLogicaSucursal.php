<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';

$controlTest = new ControlSucursalLogicaclass();
$sucursalTest = new Sucursalclass();

/**
 * Agregar sucursal
 */
//$nombre = 'Raulito';
//$estado = 'Dtto Cpital';
//$ciudad = 'Caracs';
//$direccion = 'Chacao';
//$telefono = '02123334456';
//$habilitado = 0;
//
//$resultado = $controlTest->nuevaSucursal($nombre, $estado, $ciudad, $direccion, $telefono, $habilitado);
//echo $resultado;

/**
 * Editar sucursal
 */
//$id = 6;
//$nombre = 'LaSucursalita';
//$estado = 'Dtto Capital';
//$ciudad = 'Caracas';
//$direccion = 'Chacao';
//$telefono = '02128887766';
//$habilitado = 1;
//
//$resultado = $controlTest->editarSucursal($id, $nombre, $estado, $ciudad, $direccion, $telefono, $habilitado);
//echo $resultado;

/**
 * Consultar todas las sucursales
 */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>id</th>';
//echo '<th>nombre</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '<th>telefono</th>';
//echo '<th>habilitado</th>';
//echo '</tr>';
//$resultado = $controlTest->consultarSucursales();
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['id'] . '</td>';
//    echo '<td>' . $row['nombre'] . '</td>';
//    echo '<td>' . $row['estado'] . '</td>';
//    echo '<td>' . $row['ciudad'] . '</td>';
//    echo '<td>' . $row['direccion'] . '</td>';
//    echo '<td>' . $row['telefono'] . '</td>';
//    echo '<td>' . $row['habilitado'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';

/**
 * Consultar Sucursales por Id,nombre,estado o ciudad
 */
//$busqueda = 'l';
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>id</th>';
//echo '<th>nombre</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '<th>telefono</th>';
//echo '<th>habilitado</th>';
//echo '</tr>';
//$resultado = $controlTest->consultarSucursalIdNombreEstadoCiudad($busqueda);
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['id'] . '</td>';
//    echo '<td>' . $row['nombre'] . '</td>';
//    echo '<td>' . $row['estado'] . '</td>';
//    echo '<td>' . $row['ciudad'] . '</td>';
//    echo '<td>' . $row['direccion'] . '</td>';
//    echo '<td>' . $row['telefono'] . '</td>';
//    echo '<td>' . $row['habilitado'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';

/**
 * Consultar encargados de una sucursal
 */
//$idSucursal = 1;
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>cedula</th>';
//echo '<th>nombre</th>';
//echo '<th>apellido</th>';
//echo '<th>sexo</th>';
//echo '<th>fechaNacimiento</th>';
//echo '<th>tipo</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '<th>telefono</th>';
//echo '<th>habilitado</th>';
//echo '</tr>';
//$resultado = $controlTest->consultarEncargadosSucursal($idSucursal);
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['cedula'] . '</td>';
//    echo '<td>' . $row['nombre'] . '</td>';
//    echo '<td>' . $row['apellido'] . '</td>';
//    echo '<td>' . $row['sexo'] . '</td>';
//    echo '<td>' . $row['fechaNacimiento'] . '</td>';
//    echo '<td>' . $row['tipo'] . '</td>';
//    echo '<td>' . $row['estado'] . '</td>';
//    echo '<td>' . $row['ciudad'] . '</td>';
//    echo '<td>' . $row['direccion'] . '</td>';
//    echo '<td>' . $row['telefono'] . '</td>';
//    echo '<td>' . $row['habilitado'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';

/**
 * Las ventas realizadas por una sucursal en un rango de fecha
 */
//$idSucursal = 1;
//$fechaInicio = '2009-02-01';
//$fechaFin = '2009-03-31';
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>sucursal</th>';
//echo '<th>nombre</th>';
//echo '<th>fecha</th>';
//echo '<th>monto</th>';
//echo '</tr>';
//$resultado = $controlTest->consultarVentasSucursal($idSucursal, $fechaInicio, $fechaFin);
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row[sucursal] . '</td>';
//    echo '<td>' . $row[nombre] . '</td>';
//    echo '<td>' . $row[fecha] . '</td>';
//    echo '<td>' . $row[monto] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';

/**
 * La sucursal que vendio mas
 */
$fechaInicio = '2009-02-01';
$fechaFin = '2009-03-31';
echo '<table border=1>';
echo '<tr>';
echo '<th>sucursal</th>';
echo '<th>nombre</th>';
echo '<th>tipo</th>';
echo '<th>monto</th>';
echo '</tr>';
$resultado = $controlTest->consultarSucursalMasVentas($fechaInicio, $fechaFin);
while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row[sucursal] . '</td>';
    echo '<td>' . $row[nombre] . '</td>';
    echo '<td>' . $row[tipo] . '</td>';
    echo '<td>' . $row[monto] . '</td>';
    echo '</tr>';
}
echo '</table>';

?>
