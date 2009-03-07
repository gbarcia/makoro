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
        $totalGeneral += $total;


        $resultado.= '<hr size="1" width="98%" color="#067AC2">';
        $resultado.= '<div class="tituloNegro3">CI: ' . $tripulante->getCedula() . ' - ' . $tripulante->getApellido() . ', ' . $tripulante->getNombre() . '</div>';
        $resultado.= '</table>';
        $resultado.= '<table width="100%" class="formTable" cellspacing="0">';
        $resultado.= '<thead>';
        $resultado.= '<tr>';
        $resultado.= '<th>FECHA</th>';
        $resultado.= '<th>SITIO SALIDA</th>';
        $resultado.= '<th>SITIO LLEGADA</th>';
        $resultado.= '<th>TIEMPO</th>';
        $resultado.= '<th>MATRICULA</th>';
        $resultado.= '<th>CARGO</th>';
        $resultado.= '<th>SUBTOTAL</th>';
        $resultado.= '</tr>';
        $resultado.= '</thead>';
        $resultado.= '<tfoot>';
        $resultado.= '<tr>';
        $resultado.= '<td>&nbsp</td>';
        $resultado.= '<td>&nbsp</td>';
        $resultado.= '<td>&nbsp</td>';
        $resultado.= '<td>&nbsp</td>';
        $resultado.= '<td>&nbsp</td>';
        $resultado.= '<td align="center">Total:</td>';
        $resultado.= '<td align="right">'. 'Bs. ' . $total .'</td>';
        $resultado.= '</tr>';
        $resultado.= '</tfoot>';
        $color = false;
        while ($row = mysql_fetch_array($recursoDetalles)) {
            $controlTipoCargo = new controladorTipoCargoBDclass();
            $tarifa = $controlTipoCargo->obtenerSueldoTipoCargo($row[idCargo]);
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $resultado.= '<td>' . $row[fecha]. '</td>';
            $resultado.= '<td>' . $row[sitioSalida]. '</td>';
            $resultado.= '<td>' . $row[sitioLlegada] . '</td>';
            $resultado.= '<td>' . $row[tiempo]. '</td>';
            $resultado.= '<td>' . $row[AVION_matricula]. '</td>';
            $resultado.= '<td>' . $row[cargo]. '</td>';
            $resultado.= '<td align="right">' . ' Bs. ' . $row[tiempo]*$tarifa . '</td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
        $resultado.= '</table>';
        $resultado.= '<br/>';

        $resultadoTotal = '<hr size="1" width="98%" color="#067AC2">';
        $resultadoTotal.= '<table  width="100%" class="formTable" cellspacing="0">';
        $resultadoTotal.= '<tfoot>';
        $resultadoTotal.= '<tr>';
        $resultadoTotal.= '<td align="right">'. 'Total Egresos: Bs. ' . $totalGeneral .'</td>';
        $resultadoTotal.= '</tr>';
        $resultadoTotal.= '</tfoot>';
        $resultadoTotal.= '</table><br />';
    }
    $objResponse->addAssign("ResultadoCa", "innerHTML", $resultado);
    $objResponse->addAssign("totalGeneral", "innerHTML", $resultadoTotal);

    return $objResponse;
}

?>
