<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlClienteParticularLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteParticular.class.php';

$controlTest = new ControlClienteParticularLogicaclass();
$clienteParticularTest = new ClienteParticularclass();

//$cedula = 12345678;
//$nombre = 'Raul';
//$apellido = 'Narvaez';
//$sexo = 'M';
//$fechanacimiento = '1980-03-01';
//$telefono = '02123334456';
//$estado = 'Dtto Capital';
//$ciudad = 'Caracas';
//$direccion = 'Chacaito';

//$resultado = $controlBD->nuevoClienteParticular($cedula, $nombre, $apellido, $sexo, $fechaNacimiento, $telefono, $estado, $ciudad, $direccion);
//echo $resultado;
//$resultado = $controlBD->actualizarClienteParticular($cedula, $nombre, $apellido, $telefono, $estado, $ciudad, $direccion);
//echo $resultado;

//$busqueda = 'r';
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>cedula</th>';
//echo '<th>nombre</th>';
//echo '<th>apellido</th>';
//echo '<th>sexo</th>';
//echo '<th>fechaNacimiento</th>';
//echo '<th>telefono</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '</tr>';
//$resultado = $controlTest->consultarClientesParticularesCedulaNombreApellido($busqueda);
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['cedula']. '</td>';
//    echo '<td>' . $row['nombre']. '</td>';
//    echo '<td>' . $row['apellido']. '</td>';
//    echo '<td>' . $row['sexo']. '</td>';
//    echo '<td>' . $row['fechaNacimiento']. '</td>';
//    echo '<td>' . $row['telefono']. '</td>';
//    echo '<td>' . $row['estado']. '</td>';
//    echo '<td>' . $row['ciudad']. '</td>';
//    echo '<td>' . $row['direccion']. '</td>';
//    echo '</tr>';
//}
//echo '</table>';

//echo '<table border=1>';
//echo '<tr>';
//echo '<th>cedula</th>';
//echo '<th>nombre</th>';
//echo '<th>apellido</th>';
//echo '<th>sexo</th>';
//echo '<th>fechaNacimiento</th>';
//echo '<th>telefono</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '<th>cnt</th>';
//echo '</tr>';
//$resultado = $controlTest->consultarClienteParticularConMasVuelos();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['cedula']. '</td>';
//    echo '<td>' . $row['nombre']. '</td>';
//    echo '<td>' . $row['apellido']. '</td>';
//    echo '<td>' . $row['sexo']. '</td>';
//    echo '<td>' . $row['fechaNacimiento']. '</td>';
//    echo '<td>' . $row['telefono']. '</td>';
//    echo '<td>' . $row['estado']. '</td>';
//    echo '<td>' . $row['ciudad']. '</td>';
//    echo '<td>' . $row['direccion']. '</td>';
//    echo '<td>' . $row[cnt]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';

//echo '<table border=1>';
//echo '<tr>';
//echo '<th>cedula</th>';
//echo '<th>nombre</th>';
//echo '<th>apellido</th>';
//echo '<th>sexo</th>';
//echo '<th>fechaNacimiento</th>';
//echo '<th>telefono</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '<th>cnt</th>';
//echo '</tr>';
//$resultado = $controlTest->consultarClienteParticularConMasVuelosDescendente();
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['cedula']. '</td>';
//    echo '<td>' . $row['nombre']. '</td>';
//    echo '<td>' . $row['apellido']. '</td>';
//    echo '<td>' . $row['sexo']. '</td>';
//    echo '<td>' . $row['fechaNacimiento']. '</td>';
//    echo '<td>' . $row['telefono']. '</td>';
//    echo '<td>' . $row['estado']. '</td>';
//    echo '<td>' . $row['ciudad']. '</td>';
//    echo '<td>' . $row['direccion']. '</td>';
//    echo '<td>' . $row[cnt]. '</td>';
//    echo '</tr>';
//}
//echo '</table>';

echo '<table border=1>';
echo '<tr>';
echo '<th>cedula</th>';
echo '<th>nombre</th>';
echo '<th>apellido</th>';
echo '<th>sexo</th>';
echo '<th>fechaNacimiento</th>';
echo '<th>telefono</th>';
echo '<th>estado</th>';
echo '<th>ciudad</th>';
echo '<th>direccion</th>';
echo '<th>fechaReserva</th>';
echo '</tr>';
$resultado = $controlTest->consultarClientesParticularesPorPagar('2009-01-01', '2009-12-31');
while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row['cedula']. '</td>';
    echo '<td>' . $row['nombre']. '</td>';
    echo '<td>' . $row['apellido']. '</td>';
    echo '<td>' . $row['sexo']. '</td>';
    echo '<td>' . $row['fechaNacimiento']. '</td>';
    echo '<td>' . $row['telefono']. '</td>';
    echo '<td>' . $row['estado']. '</td>';
    echo '<td>' . $row['ciudad']. '</td>';
    echo '<td>' . $row['direccion']. '</td>';
    echo '<td>' . $row[fecha]. '</td>';
    echo '</tr>';
}
echo '</table>';

?>
