<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlBoletoLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';

$controlBD = new ControlBoletoLogicaclass();
$boletoPrueba = new Boletoclass();

/* CONSULTAR BOLETO POR SOLICITUD */
$solicitud = "34FN";
echo '<table border=1>';
echo '<tr>';
echo '<th>Id</th>';
echo '<th>Pago Id</th>';
echo '<th>Pasajero Id</th>';
echo '</tr>';
$resultado = $controlBD->busquedaBoletoEspecifico($solicitud);
    while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row[idBoleto] . '</td>';
    echo '<td>' . $row[idPago] . '</td>';
    echo '<td>' . $row[idPasajero] . '</td>';
    echo '</tr>';
}
echo '</table>';
/*-------------------------------*/
?>
