<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';

function autoSugerir($busqueda){
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlTripulanteLogicaclass();
    $recurso = $controlLogica->consultarTripulanteCedulaNombreApellido($busqueda);
    $numFilas = mysql_num_rows($recurso);
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
    if (isset($busqueda) && $busqueda != "") {
        if ($numFilas > 0){
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

function autosugerirInicio () {
    $controlLogica = new ControlTripulanteLogicaclass();
    echo '<table border=1>';
    echo '<tr>';
    echo '<th>cedula</th>';
    echo '<th>nombre</th>';
    echo '<th>apellido</th>';
    echo '<th>sexo</th>';
    echo '<th>telefono </th>';
    echo '<th>estado</th>';
    echo '<th>ciudad</th>';
    echo '<th>direccion</th>';
    echo '<th>habilitado</th>';
    echo '<th>cargo</th>';
    echo '<th>sueldo</th>';
    echo '</tr>';
    $resultado = $controlLogica->consultarTodoPersonal(TRUE);
    foreach ($resultado as $row) {
        echo '<tr>';
        echo '<td>' . $row->getCedula(). '</td>';
        echo '<td>' . $row->getNombre(). '</td>';
        echo '<td>' . $row->getApellido(). '</td>';
        echo '<td>' . $row->getSexo(). '</td>';
        echo '<td>' . $row->getTelefono() . '</td>';
        echo '<td>' . $row->getEstado(). '</td>';
        echo '<td>' . $row->getCiudad(). '</td>';
        echo '<td>' . $row->getDireccion(). '</td>';
        echo '<td>' . $row->getHabilitado(). '</td>';
        echo '<td>' . $row->getCargo(). '</td>';
        echo '<td>' . $row->getSueldo(). '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

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
            $resultado.= '<td>' . $row->getHabilitado(). '</td>';
            $resultado.= '<td>' . $row->getCargo(). '</td>';
            $resultado.= '<td>' . $row->getSueldo(). '</td>';
            $resultado.= '</tr>';
        }
        $resultado.= '</table>';
        $objResponse->addAssign("gestionTripulante", "innerHTML", $resultado);
    }
    return $objResponse;
}
?>
