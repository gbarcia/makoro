<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPagoBD.class.php';

$pago = new Pagoclass();
$controlPrueba = new controladorPagoBDclass();

///* AGREGAR PAGO */
//$pago->setTipo("T");
//$pago->setMonto(3.3);
//$pago->setNombreBanco("Federal");
//$pago->setNumeroTransaccion(4686435);
//$pago->setMonedaId(1);
//$resultado = $controlPrueba->agregarPago($pago);
//echo $resultado;
///*----------------*/


/////* EDITAR PAGO */
//$pago->setId(6);
//$pago->setTipo("T");
//$pago->setMonto(5.8);
//$pago->setNombreBanco("Federalito");
//$pago->setNumeroTransaccion(4686437);
//$pago->setMonedaId(1);
//$resultado = $controlPrueba->editarPago($pago);
//echo $resultado;
/////*---------------*/


///* CONSULTAR PAGOS */
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Tipo Pago</th>';
//echo '<th>Monto</th>';
//echo '<th>Moneda</th>';
//echo '<th>Banco</th>';
//echo '<th>Numero Transaccion</th>';
//echo '</tr>';
//$resultado = $controlPrueba->consultarPagos();
//while (($row = mysql_fetch_array($resultado))) {
//    echo '<tr>';
//    echo '<td>' . $row['tipo'] . '</td>';
//    echo '<td>' . $row['monto'] . '</td>';
//    echo '<td>' . $row['MONEDA_id'] . '</td>';
//    echo '<td>' . $row['nombreBanco'] . '</td>';
//    echo '<td>' . $row['numeroTransaccion'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
///*-----------------*/


///* CONSULTAR CANCELACION DE PAGO DE CLIENTE PARTICULAR */
//$cedula = 14567875;
//$fechaini = '2009-01-01';
//$fechafin = '2009-01-31';
//$resultado = $controlPrueba->cancelarPagoRealizadoClienteParticular($cedula, $fechaini, $fechafin);
//echo $resultado;
///*-----------------------------------------------------*/


/* CONSULTAR CANCELACION DE PAGO DE CLIENTE AGENCIA */
//$rif = 'J-566456';
//$fechaini = '2009-01-01';
//$fechafin = '2009-01-31';
//$resultado = $controlPrueba->cancelarPagoRealizadoClienteAgencia($rif, $fechaini, $fechafin);
//echo $resultado;
/*-----------------------------------------------------*/
?>
