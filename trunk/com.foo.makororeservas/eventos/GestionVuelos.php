<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/AsientosDisponiblesVueloTripulacion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloBD.class.php';


function limpiar ($cadena) {
    $nueva_cadena = ereg_replace('%20', " ", $cadena);
    return $nueva_cadena;
}

function autoSugerir($busqueda){
    $busqueda = limpiar ($busqueda);
    $activado = false;
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new controladorVueloBDclass();
    $recurso = $controlLogica->consultarTodosVuelosPorFechaRutas($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>IDENTIFICADOR</th>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>SITIO DE SALIDA</th>';
    $resultado.= '<th>SITIO DE LLEGADA</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>OPCIONES</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    if (isset($busqueda)) {
        if ($numFilas > 0){ //Si hay coincidencias
            $color = false;
            while ($row = mysql_fetch_array($recurso)) {
                if ($color){
                    $resultado.= '<tr class="r0">';
                } else {
                    $resultado.= '<tr class="r1">';
                }
                $controlTripulacion = new controladorVueloPersonalBDclass();
                $recursoPiloto = $controlTripulacion->consultarVueloPersonalPiloto($row[id]);
                $recursoCopiloto = $controlTripulacion->consultarVueloPersonalCopiloto($row[id]);
                $rowPiloto = mysql_fetch_array($recursoPiloto);
                $rowCopiloto = mysql_fetch_array($recursoCopiloto);
                if ($rowPiloto == "" || $rowPiloto == NULL)
                $pilotoMostrar = 'POR ASIGNAR';
                else
                $pilotoMostrar = $rowPiloto[tripulante];
                if ($rowCopiloto == "" || $rowCopiloto == NULL)
                $copilotoMostrar = 'POR ASIGNAR';
                else
                $copilotoMostrar = $rowCopiloto[tripulante];
                $resultado.= '<td>' . $row[id]. '</td>';
                $resultado.= '<td>' . $row[fecha]. '</td>';
                $resultado.= '<td>' . $row[hora]. '</td>';
                $resultado.= '<td>' . $row[rutaSalida]. '</td>';
                $resultado.= '<td>' . $row[rutaLlegada] . '</td>';
                $resultado.= '<td>' . $row[matricula]. '</td>';
                $resultado.= '<td>' . $pilotoMostrar. '</td>';
                $resultado.= '<td>' . $copilotoMostrar. '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
                $resultado.= '</tr>';
                $color = !$color;
            }
        }
        else { // si no hay coincidencias
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else { // retorno o borrar datos
        $recurso = $controlLogica->consultarTodosVuelosPorFechaRutas("");
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $resultado.= '<td>' . $row[id]. '</td>';
            $resultado.= '<td>' . $row[fecha]. '</td>';
            $resultado.= '<td>' . $row[hora]. '</td>';
            $resultado.= '<td>' . $row[rutaSalida]. '</td>';
            $resultado.= '<td>' . $row[rutaLlegada] . '</td>';
            $resultado.= '<td>' . $row[matricula]. '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestion", "innerHTML", "$resultado");

    return $objResponse;
}

function cadenaTodosLosVuelos () {
    $resultado = "";
    $control = new controladorVueloBDclass();
    $recurso = $control->consultarTodosVuelosPorFechaRutas("");
    $row = mysql_fetch_array($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>IDENTIFICADOR</th>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>SITIO DE SALIDA</th>';
    $resultado.= '<th>SITIO DE LLEGADA</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>OPCIONES</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $controlTripulacion = new controladorVueloPersonalBDclass();
        $recursoPiloto = $controlTripulacion->consultarVueloPersonalPiloto($row[id]);
        $recursoCopiloto = $controlTripulacion->consultarVueloPersonalCopiloto($row[id]);
        $rowPiloto = mysql_fetch_array($recursoPiloto);
        $rowCopiloto = mysql_fetch_array($recursoCopiloto);
        if ($rowPiloto == "" || $rowPiloto == NULL)
        $pilotoMostrar = 'POR ASIGNAR';
        else
        $pilotoMostrar = $rowPiloto[tripulante];
        if ($rowCopiloto == "" || $rowCopiloto == NULL)
        $copilotoMostrar = 'POR ASIGNAR';
        else
        $copilotoMostrar = $rowCopiloto[tripulante];
        $resultado.= '<td>' . $row[id]. '</td>';
        $resultado.= '<td>' . $row[fecha]. '</td>';
        $resultado.= '<td>' . $row[hora]. '</td>';
        $resultado.= '<td>' . $row[rutaSalida]. '</td>';
        $resultado.= '<td>' . $row[rutaLlegada] . '</td>';
        $resultado.= '<td>' . $row[matricula]. '</td>';
        $resultado.= '<td>' . $pilotoMostrar. '</td>';
        $resultado.= '<td>' . $copilotoMostrar. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodosLosVuelos();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    return $objResponse;
}

?>
