<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSucursalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';

$sucursal = new Sucursalclass();
$controlBD = new controladorSucursalBDclass();

/**
 * Nueva sucursal
 */
//$sucursal->setNombre('Lasucur');
//$sucursal->setEstado('dtto cap');
//$sucursal->setCiudad('ccs');
//$sucursal->setDireccion('en caracas');
//$sucursal->setTelefono('02123332222');
//$sucursal->setHabilitado('0');
//
//$resultado = $controlBD->agregarSucursal($sucursal);
//echo $resultado;

/**
 * Editar sucursal
 */
//$sucursal->setId(5);
//$sucursal->setNombre('Lasucursalita');
//$sucursal->setEstado('Distrito capital');
//$sucursal->setCiudad('Caracas');
//$sucursal->setDireccion('Chacaito');
//$sucursal->setTelefono('02121377692');
//$sucursal->setHabilitado(1);
//
//$resultado = $controlBD->editarSucursal($sucursal);
//echo $resultado;

/**
 * Consultar todas las sucursales
 */
echo '<table border=1>';
echo '<tr>';
echo '<th>id</th>';
echo '<th>nombre</th>';
echo '<th>estado</th>';
echo '<th>ciudad</th>';
echo '<th>direccion</th>';
echo '<th>telefono</th>';
echo '<th>habilitado</th>';
echo '</tr>';
$resultado = $controlBD->consultarSucursales();
    while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['estado'] . '</td>';
    echo '<td>' . $row['ciudad'] . '</td>';
    echo '<td>' . $row['direccion'] . '</td>';
    echo '<td>' . $row['telefono'] . '</td>';
    echo '<td>' . $row['habilitado'] . '</td>';
    echo '</tr>';
}
echo '</table>';

?>
