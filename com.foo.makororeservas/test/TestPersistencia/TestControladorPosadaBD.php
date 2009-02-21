<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Posada.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPosadaBD.class.php';

$posada = new Posadaclass();
$posada->setId(6);
$posada->setNombrePosada("Nombre Posada");
$posada->setNombreEncargado("Nombre Encargado");
$posada->setApellidoEncargado("Apellido Encargado");
$posada->setTelefono("1234567890");
$controlPrueba = new controladorPosadaBDclass();
//$resultado = $controlPrueba->agregarPosada($posada);
//$resultado = $controlPrueba->editarPosada($posada);
$resultado = $controlPrueba->consultarPosadas();
echo '*';
echo '<table border=1>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Nombre</th>';
echo '<th>Encargado N</th>';
echo '<th>Encargado A</th>';
echo '<th>Telefono</th>';
echo '</tr>';
    while (($row = mysql_fetch_array($resultado))) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['nombrePosada'] . '</td>';
    echo '<td>' . $row['nombreEncargado'] . '</td>';
    echo '<td>' . $row['apellidoEncargado'] . '</td>';
    echo '<td>' . $row['telefono'] . '</td>';
    echo '</tr>';
}
echo '</table>';
?>
