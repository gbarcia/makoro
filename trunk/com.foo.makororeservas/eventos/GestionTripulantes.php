<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';
function autoSugerir($busqueda) {
    $objResponse = new  xajaxResponse();

    $resultado = "";

    if (isset($busqueda) && $busqueda != "") {
        $controlLogica = new ControlTripulanteLogicaclass();
        $recurso = $controlLogica->consultarTripulanteCedulaNombreApellido($busqueda);
        $numFilas = mysql_num_rows($recurso);
        if ($numFilas > 0){
            while ($row = mysql_fetch_array($recurso)) {
                 $resultado .= "<div title='". $row[dato]. "'onmouseover='javascript:suggest_over(this);'";
                 $resultado .= "onmouseout='javascript:suggest_out(this);'";
                 $resultado .= "onclick='javascript:set_search(this.title);' class='suggest_link'>";
                 $resultado .= "<table border='0' width='500'><td width='500'><b>" . $row[dato]. "</b></td><td>";
                 $resultado .= "</td></tr></table></div>";
            }
            $objResponse->addAssign("txt_result", "style.display", 'block');
            $objResponse->addAssign("txt_result", "innerHTML", $resultado);
        }
        else {
            $objResponse->addAssign("txt_result", "style.display", 'none');
        }
    }
    else {
        $objResponse->addAssign("txt_result", "style.display", 'none');
    }
    return $objResponse;
}
?>
