<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlPagoLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pago.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/InformacionGeneralBoletoRecibo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/DetallesReciboDePago.class.php';

$controlBD = new ControlPagoLogicaclass();
$pagoPrueba = new Pagoclass();

///* AGREGAR PAGO */
//$resultado = $controlBD->nuevoPago('E', 45.0, '', 'null', 1);
//echo $resultado;
///*--------------*/

///* ACTUALIZAR PAGO */
//$resultado = $controlBD->actualizarPago(7, 'E', 500.50, '', 'null', 1);
//echo $resultado;
///*---------------------------*/

/* GENERAR RECIBO DE PAGO POR SOLICITUD */
$solicitud = "34FN";

$Coleccion = $controlBD->informacionRecibo($solicitud);
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

$Coleccion = $controlBD->detallesReciboDePago($solicitud);
foreach ($Coleccion as $var) {

    $cantidadAdultosSalida = $var->getCantidadAdultosSalida();
    $cantidadAdultosLlegada = $var->getCantidadAdultosLlegada();
    $cantidadNinosSalida = $var->getCantidadNinosSalida();
    $cantidadNinosLlegada = $var->getCantidadNinosLlegada();
    $cantidadInfantes = $var->getCantidadInfantes();
    $costoSalida = $var->getCostoSalida();
    $costoPasajeNinoSalida = $var->getCostoPasajeNinosSalida();
    $costoRetorno = $var->getCostoLlegada();
    $costoPasajeNinoLlegada = $var->getCostoPasajeNinosLlegada();
    $subtotalAdultosSalida = $var->getSubtotalAdultosSalida();
    $subtotalAdultosLlegada = $var->getSubtotalAdultosLlegada();
    $subtotalNinosSalida = $var->getSubtotalNinosSalida();
    $subtotalNinosLlegada = $var->getSubtotalNinosLlegada();
    $subtotalAdultosNinos = $var->getSubtotalAdultosNinos();
    $porcentajeIvaSalida = $var->getPorcentajeIvaSalida();
    $porcentajeIvaLlegada = $var->getPorcentajeIvaLlegada();
    $comisionAgencia = $var->getComisionAgencia();
    $totalApagar = $var->getTotalApagar();
}

echo "\n";
echo 'Solicitud: ' . $solicitud;
echo '<p></p>';
echo 'Fecha de Emision: ' . $fechaEmision;
echo '<p></p>';
echo 'Agente: ' . $agente;
echo '<p></p>';
echo 'Servicio: ' . $servicio.'   |   '.'ADL: '.$cantidadAdultosSalida.'  '
                                       .'CHD: '.$cantidadNinosSalida.'  '
                                       .'INF: '.$cantidadInfantes;
echo '<p></p>';
echo 'Cliente: ' . $cliente .'   |   '. 'C.I. o Rif: '. $identificadorCliente;
echo '<p></p>';
echo '<p></p>';
echo '<p></p>';

echo '<table border=1>';
echo '<tr>';
echo '<th>Vuelo</th>';
echo '<th>Ruta</th>';
echo '<th>Fecha</th>';
echo '<th>Hora</th>';
echo '<th>Costo</th>';
echo '<tr>';
echo '<td>IDA</td>';
echo '<td>'. $lugarSalida .'</td>';
echo '<td>'. $fechaIda .'</td>';
echo '<td>'. $horaIda .'</td>';
echo '<td>'. $costoSalida .' Bs'.'</td>';
echo '</tr>';
echo '<tr>';
echo '<td>VUELTA</td>';
echo '<td>'. $lugarLlegada .'</td>';
echo '<td>'. $fechaVuelta .'</td>';
echo '<td>'. $horaVuelta .'</td>';
echo '<td>'. $costoRetorno .' Bs'.'</td>';
echo '</tr>';
echo '</tr>';
echo '</table>';

echo '<p></p>';
echo '<p></p>';
echo '<p></p>';

echo '<table border=1>';
echo '<th></th>';
echo '<th>Cantidad</th>';
echo '<th>Costo</th>';
echo '<th></th>';
echo '<tr>';
echo '<td>Tarifa Salida TKT ADL</td>';
echo '<td>'. $cantidadAdultosSalida .'</td>';
echo '<td>'.' Bs. '. $costoSalida .'</td>';
echo '<td>'.' Bs. '. $subtotalAdultosSalida .'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Tarifa Retorno TKT ADL</td>';
echo '<td>'. $cantidadAdultosLlegada .'</td>';
echo '<td>'.' Bs. '. $costoRetorno .'</td>';
echo '<td>'.' Bs. '. $subtotalAdultosLlegada .'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Tarifa Salida TKT CHD</td>';
echo '<td>'. $cantidadNinosSalida .'</td>';
echo '<td>'.' Bs. '. $costoPasajeNinoSalida .'</td>';
echo '<td>'.' Bs. '. $subtotalNinosSalida .'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Tarifa Retorno TKT CHD</td>';
echo '<td>'. $cantidadNinosLlegada .'</td>';
echo '<td>'.' Bs. '. $costoPasajeNinoLlegada .'</td>';
echo '<td>'.' Bs. '. $subtotalNinosLlegada .'</td>';
echo '</tr>';

echo '<tr>';
echo '<th>SUBTOTAL</th>';
echo '<td></td>';
echo '<td></td>';
echo '<th>'.' Bs. '. $subtotalAdultosNinos .'</th>';
echo '</tr>';

echo '<tr>';
echo '<th>COMISION TKT</th>';
echo '<td></td>';
echo '<td></td>';
echo '<th>'.' Bs. '. $comisionAgencia .'</th>';
echo '</tr>';

echo '<tr>';
echo '<td>Ruta Salida IVA 8%</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td>'.' Bs. '. $porcentajeIvaSalida .'</td>';
echo '</tr>';

echo '<tr>';
echo '<td>Ruta Retorno IVA 8%</td>';
echo '<td></td>';
echo '<td></td>';
echo '<td>'.' Bs. '. $porcentajeIvaLlegada .'</td>';
echo '</tr>';

echo '<tr>';
echo '<th>TOTAL A PAGAR</th>';
echo '<td></td>';
echo '<td></td>';
echo '<th>'.' Bs. '. $totalApagar .'</th>';
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

$ColeccionPasajeros = $controlBD->informacionRecibo($solicitud);
foreach ($ColeccionPasajeros as $var) {
    $recursoDetalles = $var->getColeccionPasajero();

    echo '<tr>';
    echo '<td>' . $recursoDetalles->getNombre().' '. $recursoDetalles->getApellido(). '</td>';
    echo '<td>' . $recursoDetalles->getTipoPasajeroId(). '</td>';
    echo '</tr>';
}
echo '</table>';

?>
