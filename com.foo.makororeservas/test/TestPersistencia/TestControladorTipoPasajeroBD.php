<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoPasajero.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoPasajeroBD.class.php';

$tipoPasajero = new TipoPasajeroclass();
$controlPrueba = new controladorTipoPasajeroBDclass();

///* EDITAR TIPO PASAJERO <SOLO EL PORCENTAJE DESCUENTO> */
//$tipoPasajero->setId("CHD");
//$tipoPasajero->setPorcentajeDescuento(0.75);
//$resultado = $controlPrueba->editarTipoPasajero($tipoPasajero);
//echo $resultado;
///*-----------------------------------------------------*/


///* CONSULTAR TIPO PASAJEROS */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Tipo</th>';
//echo '<th>Descuento</th>';
//echo '</tr>';
//$resultado = $controlPrueba->consultarTipoPasajero();
//    while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['id'] . '</td>';
//    echo '<td>' . $row['porcentajeDescuento'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*--------------------------*/
?>
