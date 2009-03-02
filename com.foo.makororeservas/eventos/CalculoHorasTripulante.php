<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/PagoNominaTripulacion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoCargoBD.class.php';

function calculoHora($datos) {
    $fechaini = $datos[fechaInicio];
    $fechafin = $datos[fechaFin];
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlTripulanteLogicaclass();
    $Coleccion = $controlLogica->consultarSueldoNominaTripulantesDetalles($fechaini, $fechafin);
    
    foreach ($Coleccion as $variable) {

    $recursoDetalles = $variable->getColeccionDetalles();
    $total = $variable->getTotalPago();
    $tripulante = $variable->getTripulante();

    $resultado.= "\n";
    $resultado.= "\n";
    $resultado.= '<table border=1>';
    $resultado.= '<tr>';
    $resultado.= '<th>Cedula</th>';
    $resultado.= '<th>Nombre</th>';
    $resultado.= '<th>Apellido</th>';
    $resultado.= '<th>Sitio Salida</th>';
    $resultado.= '<th>Sitio Llegada</th>';
    $resultado.= '<th>Tiempo</th>';
    $resultado.= '<th>Matricula</th>';
    $resultado.= '<th>Cargo</th>';
    $resultado.= '<th>SUBTOTAL</th>';
    $resultado.= '</tr>';
    while ($row = mysql_fetch_array($recursoDetalles)) {
        $controlTipoCargo = new controladorTipoCargoBDclass();
        $tarifa = $controlTipoCargo->obtenerSueldoTipoCargo($row[idCargo]);
        $resultado.= '<tr>';
        $resultado.= '<td>' . $row[cedula]. '</td>';
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[apellido]. '</td>';
        $resultado.= '<td>' . $row[sitioSalida]. '</td>';
        $resultado.= '<td>' . $row[sitioLlegada] . '</td>';
        $resultado.= '<td>' . $row[tiempo]. '</td>';
        $resultado.= '<td>' . $row[AVION_matricula]. '</td>';
        $resultado.= '<td>' . $row[cargo]. '</td>';
        $resultado.= '<td>' . $row[tiempo]*$tarifa . ' BS'. '</td>';
        $resultado.= '</tr>';
    }

    $resultado.= '</table>';
    $resultado.= ' BS'. $total;
}
    $objResponse->addAssign("ResultadoCa", "innerHTML", $resultado);

    return $objResponse;
}

?>
