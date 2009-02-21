<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';

/**
 * Metodo xajax para autosugerir un tipulante
 * @param <type> $busqueda
 * @return <type> objeto de respuesta xjax
 */
function autoSugerir($busqueda){
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlTripulanteLogicaclass();
    $recurso = $controlLogica->consultarTripulanteCedulaNombreApellido($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<table class="tabla">';
    $resultado.= '<tr class="titulo">';
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
    if (isset($busqueda) && $busqueda != "") {
        if ($numFilas > 0){
            $color = false;
            while ($row = mysql_fetch_array($recurso)) {
                if ($color){
                    $resultado.= '<tr class="r0">';
                } else {
                    $resultado.= '<tr class="r1">';
                }
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
                $color = !$color;
            }
        }
        else {
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else {
        $recurso = $controlLogica->consultarTodoPersonal(TRUE);
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
            $resultado.= '<td>' . $row->getHabilitado(). '</td>';
            $resultado.= '<td>' . $row->getCargo(). '</td>';
            $resultado.= '<td>' . $row->getSueldo(). '</td>';
            $resultado.= '</tr>';
        }
    }
    $resultado.= '</table>';
    $objResponse->addAssign("gestionTripulante", "innerHTML", $resultado);

    return $objResponse;
}

/**
 * Metodo para el inicio de la pagina
 * @param <type> $reg1
 * @param <type> $tamPag
 */
function autosugerirInicio ($reg1,$tamPag) {
    $controlLogica = new ControlTripulanteLogicaclass();
    echo '<table border=1>';
    echo '<tr>';
    echo '<th>Cedula</th>';
    echo '<th>Nombre</th>';
    echo '<th>Apellido</th>';
    echo '<th>Sexo</th>';
    echo '<th>Telefono </th>';
    echo '<th>Estado</th>';
    echo '<th>Ciudad</th>';
    echo '<th>Direccion</th>';
    echo '<th>Habilitado</th>';
    echo '<th>Cargo</th>';
    echo '<th>Sueldo</th>';
    echo '</tr>';
    $resultado = $controlLogica->consultarTodoPersonal(TRUE);
    $tamanoArreglo = sizeof($resultado);
    for ($i=$reg1; $i<min($reg1+$tamPag, $tamanoArreglo); $i++) {
        echo '<tr>';
        echo '<td>' . $resultado[$i]->getCedula(). '</td>';
        echo '<td>' . $resultado[$i]->getNombre(). '</td>';
        echo '<td>' . $resultado[$i]->getApellido(). '</td>';
        echo '<td>' . $resultado[$i]->getSexo(). '</td>';
        echo '<td>' . $resultado[$i]->getTelefono() . '</td>';
        echo '<td>' . $resultado[$i]->getEstado(). '</td>';
        echo '<td>' . $resultado[$i]->getCiudad(). '</td>';
        echo '<td>' . $resultado[$i]->getDireccion(). '</td>';
        echo '<td>' . $resultado[$i]->getHabilitado(). '</td>';
        echo '<td>' . $resultado[$i]->getCargo(). '</td>';
        echo '<td>' . $resultado[$i]->getSueldo(). '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

/**
 * Metodo para consultar el numero total de los empleados de vuelo registrados en el sistema
 * @return <type>
 */
function consultarNumeroTotalPersonal () {
    $controlLogica = new ControlTripulanteLogicaclass();
    $resultado = $controlLogica->consultarTodoPersonal(TRUE);
    $tamanoArreglo = sizeof($resultado);
    return $tamanoArreglo;
}

/**
 * Funcion pa mostrar los links de la paginacion
 * @param <type> $actual
 * @param <type> $total
 * @param <type> $por_pagina
 * @param <type> $enlace
 * @return <type>
 */
function paginar($actual, $total, $por_pagina, $enlace) {
  $total_paginas = ceil($total/$por_pagina);
  $anterior = $actual - 1;
  $posterior = $actual + 1;
  if ($actual>1)
    $texto = "<a href=\"$enlace$anterior\">&laquo;</a> ";
  else
    $texto = "<b>&laquo;</b> ";
  for ($i=1; $i<$actual; $i++)
    $texto .= "<a href=\"$enlace$i\">$i</a> ";
  $texto .= "<b>$actual</b> ";
  for ($i=$actual+1; $i<=$total_paginas; $i++)
    $texto .= "<a href=\"$enlace$i\">$i</a> ";
  if ($actual<$total_paginas)
    $texto .= "<a href=\"$enlace$posterior\">&raquo;</a>";
  else
    $texto .= "<b>&raquo;</b>";
  return $texto;
    }

/**
 * Funcion con xjax para consultar todo el personal inhabilitado
 * @param <type> $ina
 * @return <type>
 */
function inabilitado ($ina) {
    if ($ina == "true") {
        $resultado = "";
        $objResponse = new xajaxResponse();
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
        $controlLogica = new ControlTripulanteLogicaclass();
        $recurso = $controlLogica->consultarTodoPersonal(FALSE);
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
            $resultado.= '<td>' . $row->getHabilitado(). '</td>';
            $resultado.= '<td>' . $row->getCargo(). '</td>';
            $resultado.= '<td>' . $row->getSueldo(). '</td>';
            $resultado.= '</tr>';
        }
        $resultado.= '</table>';
        $objResponse->addAssign("gestionTripulante", "innerHTML", $resultado);

    }
    else  {
        $resultado = "";
        $objResponse = new xajaxResponse();
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
        $controlLogica = new ControlTripulanteLogicaclass();
        $recurso = $controlLogica->consultarTodoPersonal(TRUE);
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
    }
    return $objResponse;
}
?>
