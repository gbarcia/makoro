<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';

/**
 * Funcion para realizar la sugerencia en la busquedas de los tripulantes
 * @param <String> $busqueda la cadena que contiene la busqueda
 * @return <ObjetoXAJAX> el objeto Xajax
 */
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

function mostrarEmpleados(){
    $controlLogica = new ControlTripulanteLogicaclass();
    $objResponse = new xajaxResponse();

    $resultado = "No existen resultados de su busqueda";

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
    //$recurso = $controlLogica->consul
    foreach ($recurso as $row) {
        $resultado.= '<tr>';
        $resultado.= '<td>' . $row->getCedula(). '</td>';
        $resultado.= '<td>' . $row->getNombre(). '</td>';
        $resultado.= '<td>' . $row->getApellido(). '</td>';
        $resultado.= '<td>' . $row->getSexo(). '</td>';
        $resultado.= '<td>' . $row->getTelefono() . '</td>';
        $resultado.= '<td>' . $row->getEstado(). '</td>';
        $resultado.= '<td>' . $row->getCiudad(). '</td>';
        $resultado.= '<td>' . $row->getDireccion(). '</td>';
        $resultado.= '<td>' . $row->getCargo(). '</td>';
        $resultado.= '<td>' . $row->getSueldo(). '</td>';
        $resultado.= '<td>' . $row->getHabilitado(). '</td>';
        $resultado.= '</tr>';
    }

    $resultado.= '</table>';
    $objResponse->addAssign("gestionTripulante", "innerHTML", $resultado);
    return $objResponse;
}
?>
