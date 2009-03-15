<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlBoletoLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/InformacionGeneralBoletoRecibo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/DetallesEmitirBoleto.class.php';

$controlBD = new ControlBoletoLogicaclass();
$boletoPrueba = new Boletoclass();

/* GENERAR BOLETO POR SOLICITUD */
$solicitud = "34FN";

$Coleccion = $controlBD->informacionGeneralReciboBoleto($solicitud);
foreach ($Coleccion as $var) {
    $agente = $var->getAgente();
    $solicitud = $var->getSolicitud();
    $fechaEmision = $var->getFechaEmision();
    $fechaIda = $var->getFechaIda();
    $horaIda = $var->getHoraIda();
    $fechaVuelta = $var->getFechaVuelta();
    $horaVuelta = $var->getHoraVuelta();
    $lugarSalida = $var->getSalida();
    $lugarLlegada = $var->getRetorno();
    $servicio = $var->getServicio();
    $cliente = $var->getCliente();
    $identificadorCliente = $var->getIdentificadorCliente();
}
$Coleccion = $controlBD->detallesEmitirBoleto($solicitud);
foreach ($Coleccion as $var) {
    $cantidadAdultos = $var->getCantidadAdultos();
    $cantidadNinos = $var->getCantidadNinos();
    $cantidadInfantes = $var->getCantidadInfantes();
}
echo "\n";
echo '<th>Localizador:</th> ' . $solicitud;
echo '<p></p>';
echo '<th>Fecha de Emision</th>: ' . $fechaEmision;
echo '<p></p>';
echo '<th>Agente</th>: ' . $agente;
echo '<p></p>';
echo '<th>Cliente</th>: ' . $cliente .'   |   '. '<th>C.I. o Rif:</th> '. $identificadorCliente;
echo '<p></p>';
echo '<th>Servicio</th>: ' . $servicio.'   |   '.'<th>ADL:</th> '.$cantidadAdultos.'  '.'<th>CHD:</th> '.$cantidadNinos.'  '.'<th>INF:</th> '.$cantidadInfantes;
echo '<p></p>';
echo '<p></p>';
echo '<p></p>';

echo '<table border=1>';
echo '<tr>';
echo '<th>Vuelo</th>';
echo '<th>Ruta</th>';
echo '<th>Fecha</th>';
echo '<th>Hora</th>';
echo '<tr>';
echo '<td>IDA</td>';
echo '<td>'. $lugarSalida .'</td>';
echo '<td>'. $fechaIda .'</td>';
echo '<td>'. $horaIda .'</td>';
echo '</tr>';
echo '<tr>';
echo '<td>RETORNO</td>';
echo '<td>'. $lugarLlegada .'</td>';
echo '<td>'. $fechaVuelta .'</td>';
echo '<td>'. $horaVuelta .'</td>';
echo '</tr>';
echo '</tr>';
echo '</table>';

echo '<p></p>';
echo '<p></p>';
echo '<p></p>';

echo '<table border=1>';
echo '<tr>';
echo '<th>Pasajeros</th>';
echo '<th>Tipo</th>';
echo '</tr>';

$ColeccionPasajeros = $controlBD->informacionGeneralReciboBoleto($solicitud);
foreach ($ColeccionPasajeros as $var) {
    $recursoDetalles = $var->getColeccionPasajero();

    echo '<tr>';
    echo '<td>' . $recursoDetalles->getNombre().' '. $recursoDetalles->getApellido(). '</td>';
    echo '<td>' . $recursoDetalles->getTipoPasajeroId(). '</td>';
    echo '</tr>';
}
echo '</table>';
/*-------------------------------*/
?>
