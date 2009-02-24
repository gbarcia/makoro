<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Moneda.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorMonedaBD.class.php';

$moneda = new Monedaclass();
$controlPrueba = new controladorMonedaBDclass();

///* AGREGAR MONEDA */
//$moneda->setTipo("LIBRAS ESTERLINAS");
//$resultado = $controlPrueba->agregarMoneda($moneda);
//echo $resultado;
///*----------------*/


///* EDITAR MONEDA */
//$moneda->setId(4);
//$moneda->setTipo("YENCITO");
//$resultado = $controlPrueba->editarMoneda($moneda);
///*---------------*/


///* CONSULTAR MONEDAS */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Moneda</th>';
//echo '</tr>';
//$resultado = $controlPrueba->consultarMonedas();
//while (($row = mysql_fetch_array($resultado))) {
//    echo '<tr>';
//    echo '<td>' . $row['tipo'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-------------------*/
?>
