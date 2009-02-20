<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';

/**
 * Funcion para realizar la sugerencia en la busquedas de los tripulantes
 * @param <String> $busqueda la cadena que contiene la busqueda
 * @return <ObjetoXAJAX> el objeto Xajax
 */
//function autoSugerir($busqueda) {
//    $objResponse = new  xajaxResponse();
//
//    $resultado = "";
//
//    if (isset($busqueda) && $busqueda != "") {
//        $controlLogica = new ControlTripulanteLogicaclass();
//        $recurso = $controlLogica->consultarTripulanteCedulaNombreApellido($busqueda);
//        $numFilas = mysql_num_rows($recurso);
//        if ($numFilas > 0){
//            while ($row = mysql_fetch_array($recurso)) {
//                $resultado .= "<div title='". $row[cedula]. "'onmouseover='javascript:suggest_over(this);'";
//                $resultado .= "onmouseout='javascript:suggest_out(this);'";
//                $resultado .= "onclick='javascript:set_search(this.title);' class='suggest_link'>";
//                $resultado .= "<table border='0' width='500'><td width='500><b>" . $row[cedula] . "</b></td><td>";
//                $resultado .= "</td></tr></table></div>";
//            }
//            $objResponse->addAssign("txt_result", "style.display", 'block');
//            $objResponse->addAssign("txt_result", "innerHTML", $resultado);
//        }
//        else {
//            $objResponse->addAssign("txt_result", "style.display", 'none');
//        }
//    }
//    else {
////        $objResponse->addAssign("txt_result", "style.display", 'none');
//    }
//    return $objResponse;
//}

function autoSugerir($busqueda){
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlTripulanteLogicaclass();
    $recurso = $controlLogica->consultarTripulanteCedulaNombreApellido($busqueda);
    $numFilas = mysql_num_rows($recurso);
    if ($numFilas > 0){
        $resultado = '<table border=1>';
        $resultado.= '<tr>';
        $resultado.= '<th>Cedula</th>';
        $resultado.= '<th>Nombre</th>';
        $resultado.= '<th>Apellido</th>';
        $resultado.= '<th>Sexo</th>';
        $resultado.= '<th>Telefono</th>';
        $resultado.= '<th>Estado</th>';
        $resultado.= '<th>Ciudad</th>';
        $resultado.= '<th>Direccion</th>';
        $resultado.= '<th>Cargo</th>';
        $resultado.= '<th>Sueldo</th>';
        $resultado.= '<th>Habilitado</th>';
        $resultado.= '</tr>';
       while ($row = mysql_fetch_array($recurso)) {
            $resultado.= '<tr>';
            $resultado.= '<td>' . $row[cedula]. '</td>';
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[apellido]. '</td>';
            $resultado.= '<td>' . $row[sexo]. '</td>';
            $resultado.= '<td>' . $row[telefono] . '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad]. '</td>';
            $resultado.= '<td>' . $row[direccion]. '</td>';
            $resultado.= '<td>' . $row[cargo]. '</td>';
            $resultado.= '<td>' . $row[sueldo]. '</td>';
            $resultado.= '<td>' . $row[habilitado]. '</td>';
            $resultado.= '</tr>';
        }
    $resultado.= '</table>';
    $objResponse->addAssign("gestionTripulante", "innerHTML", $resultado);
    }
    return $objResponse;
}
?>
