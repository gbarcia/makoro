<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSucursalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';

function accion ($datos) {
    $control = new controladorSucursalBDclass();
    $recurso = $control->consultarEncargadoConMasReservas($datos[fechaInicio], $datos[fechaFin]);
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0" class="formTable">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>CEDULA</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>APELLIDO</th>';
    $resultado.= '<th>SUCURSAL</th>';
    $resultado.= '<th>CANTIDAD RESERVAS</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[cedula]. '</td>';
        $resultado.= '<td>' . $row[encargadoNombre]. '</td>';
        $resultado.= '<td>' . $row[apellido]. '</td>';
        $resultado.= '<td>' . $row[nombreSucursal]. '</td>';
        $resultado.= '<td  align="right">' . $row[cantidad]. '</td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("ResultadoCa", "innerHTML", $resultado);
    return $objResponse;
}
?>
