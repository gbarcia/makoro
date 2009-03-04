<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlBoletoLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/EmitirBoleto.class.php';


$controlBD = new ControlBoletoLogicaclass();
$boletoPrueba = new Boletoclass();

/* CONSULTAR BOLETO POR SOLICITUD */
$solicitud = "11M5";

$Coleccion = $controlBD->emitirBoleto($solicitud);
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
    echo "\n";
    echo 'Solicitud: ' . $solicitud;
    echo '<p></p>';
    echo 'Fecha de Emision: ' . $fechaEmision;
    echo '<p></p>';
    echo 'Agente: ' . $agente;
    echo '<p></p>';
    echo 'Servicio: ' . $servicio;
    echo '<p></p>';
    echo 'Cliente: ' . $cliente .'   |   '. 'C.I. o Rif: '. $identificadorCliente;
    echo '<p></p>';
    echo '<p></p>';
    echo '<p></p>';

    echo '<table border=1>';
    echo '<tr>';
    echo '<th> VUELO IDA </th>';
    echo '</tr>';
    echo '<p></p>';
    echo '<td>';
    echo '        -'.'Fecha: ' . $fechaIda;
    echo '<p></p>';
    echo '        -'.'Hora: ' . $horaIda;
    echo '<p></p>';
    echo '        -'.'Ruta: ' . $lugarSalida;
    echo '<p></p>';
    echo '<p></p>';
    echo '<p></p>';
    echo '</td>';
    echo '</table>';

echo '<table border=1>';
    echo '<tr>';
    echo '<th> VUELO RETORNO </th>';
    echo '</tr>';
    echo '<p></p>';
    echo '<td>';
    echo '        -'.'Fecha: ' . $fechaVuelta;
    echo '<p></p>';
    echo '        -'.'Hora: ' . $horaVuelta;
    echo '<p></p>';
    echo '        -'.'Ruta: ' . $lugarLlegada;
     echo '<p></p>';
    echo '</td>';
    echo '</table>';

    echo '<p></p>';
    echo '<p></p>';
    echo '<p></p>';

    echo '<table border=1>';
    echo '<tr>';
    echo '<th>Pasajeros</th>';
    echo '<th>Tipo</th>';
    echo '</tr>';

    $ColeccionPasajeros = $controlBD->emitirBoleto($solicitud);
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
