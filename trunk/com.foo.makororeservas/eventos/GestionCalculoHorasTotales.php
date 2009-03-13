<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloBD.class.php';


function calculoHora ($datos) {
    $resultado  = "";
    $controLogica = new ControlVueloLogicaclass();
    $controlBD = new controladorVueloBDclass();
    $resultadoTiempo = $controLogica->sumaHorasDeVuelos($datos[fechaInicio], $datos[fechaFin]);
    $resultadoDinero = $controlBD->consultarHorasDeVuelo($datos[fechaInicio], $datos[fechaFin]);
    $rowDinero = mysql_fetch_array($resultadoDinero);
    $horasDecimal = round($rowDinero[horasVuelo],2);
    $totalDinero = $horasDecimal * $datos[tarifa];
    $objResponse = new xajaxResponse();
    $resultado.= '</table>';
    $resultado.= '<table width="100%" class="formTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>TIEMPO REAL</th>';
    $resultado.= '<th>TIEMPO EN DECIMAL</th>';
    $resultado.= '<th>TOTAL DINERO</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $resultado.= '<tfoot>';
    $resultado.= '<tr>';
    $resultado.= '<td colspan="7" align="right">'. 'Total: Bs. ' . $totalDinero .'</td>';
    $resultado.= '</tr>';
    $resultado.= '</tfoot>';
    $resultado.= '<td>' . $resultadoTiempo. '</td>';
    $resultado.= '<td>' . $horasDecimal. '</td>';
    $resultado.= '<td>' . $totalDinero . '</td>';
    $resultado.= '</tr>';
    $resultado.= '</table>';
    $objResponse->addAssign("ResultadoCa", "innerHTML", $resultado);
    return $objResponse;
}

?>
