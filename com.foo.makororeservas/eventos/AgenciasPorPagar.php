<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteAgencia.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorClienteAgenciaBD.class.php';


function AgenciasPorPagar ($datos) {
    $control = new controladorClienteAgenciaBDclass();
    $recurso = $control->consultarClientesAgenciasPorPagar($datos[fechaInicio], $datos[fechaFin]);
    $cant = mysql_num_rows($recurso);
    $resultado = "";
    $objResponse = new xajaxResponse();
    if ($cant > 0) {
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0" class="formTable">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>RIF</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>RESERVAS POR PAGAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[rif] .'</td>';
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[telefono]. '</td>';
        $resultado.= '<td>' . $row[estado]. '</td>';
        $resultado.= '<td>' . $row[ciudad]. '</td>';
        $resultado.= '<td align="right>' . $row[cn]. '</td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>'; }
    else {
        $resultado = 'No hay pagos pendientes para este período';
    }
    $objResponse->addAssign("ResultadoCa", "innerHTML", $resultado);
    return $objResponse;
}

?>
