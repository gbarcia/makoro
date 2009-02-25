<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoCargo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoCargoBD.class.php';

$tipoCargo = new TipoCargoclass();
$controlPrueba = new controladorTipoCargoBDclass();
$tipoCargo->setCargo('limpia piso');
$tipoCargo->setDescripcion('Tipo que indica instruccion');
$tipoCargo->setSueldo(100);

//$controlPrueba = new controladorTipoCargoBDclass();
$resultado = $controlPrueba->agregarTipoCargo($tipoCargo);
echo $resultado;

//$resultado = $controlPrueba->actualizarSueldoTipoCargo(4, 150);
//echo $resultado;

//echo '<table border=1>';
//echo '<tr>';
//echo '<th>id</th>';
//echo '<th>cargo</th>';
//echo '<th>descripciom</th>';
//echo '<th>sueldo</th>';
//echo '</tr>';
//$resultado = $controlPrueba->obtenerTodosLosTiposCargo();
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['id'] . '</td>';
//    echo '<td>' . $row['cargo'] . '</td>';
//    echo '<td>' . $row['descripcion'] . '</td>';
//    echo '<td>' . $row['sueldo'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';

?>
