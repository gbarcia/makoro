<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlRutaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorRutaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSucursalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';

function generarComboBoxLugar(){
    $objResponse = new xajaxResponse();
    $combo = 'Ruta: <select name="ruta"><option value="">TODAS</option>';
    $controladorRutas = new ControlRutaLogicaclass();
    $recurso = $controladorRutas->consultarTodasLasRutas();
    foreach ($recurso as $row) {
        $combo.= '<option value="' . $row->getSitioSalida() .'-'. $row->getSitioLlegada() . '">'
        . $row->getAbreviaturaSalida() .' - '. $row->getAbreviaturaLlegada() . '</option>';
    }
    $combo.= '</select>';
    $objResponse->addAssign("comboBoxRuta", "innerHTML", "$combo");
    return $objResponse;
}

function generarComboBoxSucursal(){
    $objResponse = new xajaxResponse();
    $combo = 'Sucursal: <select name="sucursal"><option value="">TODAS</option>';
    $controladorSucursal = new controladorSucursalBDclass();
    $recurso = $controladorSucursal->consultarSucursales(true);
    while ($row = mysql_fetch_array($recurso)){
        $combo.= '<option value="' . $row[id] . '">' . $row[nombre] . '</option>';
    }
    $combo.= '</select>';
    $objResponse->addAssign("comboBoxSucursal", "innerHTML", "$combo");
    return $objResponse;
}

function generarComboBoxEncargado(){
    $objResponse = new xajaxResponse();
    $combo = 'Encargado: <select name="encargado"><option value="">TODAS</option>';
    $controladorEncargado = new controladorSeguridadBDclass();
    $recurso = $controladorEncargado->traerTodosLosEncargados(true);
    while ($row = mysql_fetch_array($recurso)){
        $combo.= '<option value="' . $row[cedula] . '">' . $row[apellido] . ', ' . $row[nombre] . '</option>';
    }
    $combo.= '</select>';
    $objResponse->addAssign("comboBoxEncargado", "innerHTML", "$combo");
    return $objResponse;
}

function procesarFiltros($datos){
    $arregloRuta = split("-", $datos[ruta]);
    echo $arregloRuta[0];
    echo $arregloRuta[1];

    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>RUTA</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>DISPONIBILIDAD</th>';
    $resultado.= '<th>VER INFO</th>';
    $resultado.= '<th>V</th>';
    $resultado.= '<th></th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
//    $controlLogica = new ControlVueloLogicaclass();
//    $recurso = $controlLogica->consultarTodoPersonal(TRUE);
    $color = false;
//    while ($row = mysql_fetch_array($recurso)) {
    while ($i != 100) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[a] . '</td>';
        $resultado.= '<td>' . $row[b] . '</td>';
        $resultado.= '<td>' . $row[c] . '</td>';
        $resultado.= '<td>' . $row[d] . '</td>';
        $resultado.= '<td>' . $row[e] . '</td>';
        $resultado.= '<td>' . $row[f] . '</td>';
        $resultado.= '<td><input type="button" value="VER MAS" onclick="xajax_editar(1)"/></td>';
        $resultado.= '<td><input type="button" value="RESERVAR" onclick="xajax_editar(1)"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
        $i++;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestionReserva", "innerHTML", "$resultado");
    return $objResponse;
}

?>
