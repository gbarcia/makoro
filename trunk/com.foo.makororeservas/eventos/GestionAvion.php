<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorAvionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Avion.class.php';

/**
 * Metodo xajax para autosugerir un avion 
 * @param <type> $busqueda La busqueda a realizar y comparar con el sistema
 * @return <type> Objeto de respuesta xajax
 */
function autoSugerir($busqueda){
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlBD = new controladorAvionBDclass();
    $recurso = $controlBD->consultarAvionesMat($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="tabla">';
    $resultado.= '<tr class="titulo">';
    $resultado.= '<th>MATRICULA</th>';
    $resultado.= '<th>ASIENTOS</th>';
    $resultado.= '<th>HABILITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '</tr>';
    if (isset($busqueda)) {
        if ($numFilas > 0){ 
            while ($row = mysql_fetch_array($recurso)) {
                $avion = new Avionclass();
                $avion->setHabilitadoString($row[habilitado]);
                $resultado.= '<td>' . $row[matricula]. '</td>';
                $resultado.= '<td>' . $row[asientos]. '</td>';
                $resultado.= '<td>' . $avion->getHabilitado(). '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[matricula].')"/></td>';
                $resultado.= '<td><input type="checkbox" name="aviones[]" value="'.$row[matricula].'"></td>';
                $resultado.= '</tr>';
            }
        }
        else { 
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else {
        $recurso = $controlBD->consultarAvionesHab(TRUE);
        foreach ($recurso as $row) {
            $resultado.= '<td>' . $row->getMatricula(). '</td>';
            $resultado.= '<td>' . $row->getAsientos(). '</td>';
            $resultado.= '<td>' . $row->getHabilitadoString(). '</td>';
            $resultado.='<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row->getMatricula().')"/></td>';
            $resultado.= '<td><input type="checkbox" name="aviones[]" value="'.$row->getMatricula().'"></td>';
            $resultado.= '</tr>';
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestionAvion", "innerHTML", "$resultado");

    return $objResponse;
}

function editar($matricula) {
    $controlBD = new controladorAvionBDclass();
    $recurso = $controlBD->consultarAvionesPorMatricula($matricula);
    $row = mysql_fetch_array($recurso);
    $resultado = '<form id="formUpdate">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td>EDITAR AVION</td>
      <td><div align="right">
        <label>
        <input type="submit" name="cerrar" id="cerrar" value="X" onclick="xajax_cerrarVentanaEditar()"/>
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td>Matricula</td>
      <td><label>
        <input type="text" name="matricula" id="matricula" READONLY size="30" value='.$row[matricula].'>
      </label></td>
    </tr>
    <tr class="r0">
      <td>Asientos</td>
      <td><label>
        <input type="text" name="asientos" id="asientos" size="30" value='.$row[asientos].'>
      </label></td>
    </tr>
    <tr class="r0">
      <td>&nbsp;</td>
      <td><p>
        <label></label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" onClick="" value="EDITAR">
      </div>
      </label></td>
    </tr>
  </table>
</form>';
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", $resultado);
    return $objResponse;
}
//xajax_procesarUpdate(xajax.getFormValues(\'formUpdate\'))

function mostrarAviones(){
    $controlBD = new controladorAvionBDclass();
    $objResponse = new xajaxResponse();
    $resultado = "";
    $recurso = $controlBD->consultarAvionesHab(TRUE);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="tabla">';
    $resultado.= '<tr class = "titulo">';
    $resultado.= '<th>MATRICULA</th>';
    $resultado.= '<th>ASIENTOS</th>';
    $resultado.= '<th>HABILITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '</tr>';
    while ($row = mysql_fetch_array($recurso)) {
        $resultado.= '<td>' . $row[matricula]. '</td>';
        $resultado.= '<td>' . $row[asientos]. '</td>';
        $resultado.= '<td>' . $row[habilitado]. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick=""/></td>';
        $resultado.= '<td><input type="checkbox" name="aviones[]" value=""></td>';
        $resultado.= '</tr>';
    }
    $resultado.= '</table>';
    $resultado.= '</form>';

    $objResponse->addAssign("gestionAvion", "innerHTML", "$resultado");
    return $objResponse;
}

function obtenerAviones(){
    $controlBD = new controladorAvionBDclass();
    $objResponse = new xajaxResponse();
    $resultado = "";
    $recurso = $controlBD->consultarAvionesHab(TRUE);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="tabla">';
    $resultado.= '<tr class = "titulo">';
    $resultado.= '<th>MATRICULA</th>';
    $resultado.= '<th>ASIENTOS</th>';
    $resultado.= '<th>HABILITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '</tr>';
    while ($row = mysql_fetch_array($recurso)) {
        $resultado.= '<td>' . $row[matricula]. '</td>';
        $resultado.= '<td>' . $row[asientos]. '</td>';
        $resultado.= '<td>' . $row[habilitado]. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick=""/></td>';
        $resultado.= '<td><input type="checkbox" name="aviones[]" value=""></td>';
        $resultado.= '</tr>';
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function mostrarAvionesInhabilitados($inhab){
    if($inhab == "true"){
        $controlBD = new controladorAvionBDclass();
        $objResponse = new xajaxResponse();
        $resultado = "";
        $recurso = $controlBD->consultarAvionesHab(FALSE);
        $numFilas = mysql_num_rows($recurso);
        $resultado = '<form id="formularioEditarMarcar">';
        $resultado.= '<table class="tabla">';
        $resultado.= '<tr class = "titulo">';
        $resultado.= '<th>MATRICULA</th>';
        $resultado.= '<th>ASIENTOS</th>';
        $resultado.= '<th>HABILITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '</tr>';
        while ($row = mysql_fetch_array($recurso)) {
            $resultado.= '<td>' . $row[matricula]. '</td>';
            $resultado.= '<td>' . $row[asientos]. '</td>';
            $resultado.= '<td>' . $row[habilitado]. '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick=""/></td>';
            $resultado.= '<td><input type="checkbox" name="aviones[]" value=""></td>';
            $resultado.= '</tr>';
        }
        $resultado.= '</table>';
        $resultado.= '</form>';

        $objResponse->addAssign("gestionAvion", "innerHTML", $resultado);
    }else{
        $controlBD = new controladorAvionBDclass();
        $objResponse = new xajaxResponse();
        $resultado = "";
        $recurso = $controlBD->consultarAvionesHab(TRUE);
        $numFilas = mysql_num_rows($recurso);
        $resultado = '<form id="formularioEditarMarcar">';
        $resultado.= '<table class="tabla">';
        $resultado.= '<tr class = "titulo">';
        $resultado.= '<th>MATRICULA</th>';
        $resultado.= '<th>ASIENTOS</th>';
        $resultado.= '<th>HABILITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '</tr>';
        while ($row = mysql_fetch_array($recurso)) {
            $resultado.= '<td>' . $row[matricula]. '</td>';
            $resultado.= '<td>' . $row[asientos]. '</td>';
            $resultado.= '<td>' . $row[habilitado]. '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick=""/></td>';
            $resultado.= '<td><input type="checkbox" name="aviones[]" value=""></td>';
            $resultado.= '</tr>';
        }
        $resultado.= '</table>';
        $resultado.= '</form>';

        $objResponse->addAssign("gestionAvion", "innerHTML", $resultado);
    }
    return $objResponse;
}

function insertarNuevoAvion(){
    $contenido ='<form id="formularioAgregar" name="formularioAgregar">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td>AGREGAR AVION</td>
      <td><div align="right">
        <label>
        <input type="submit" name="cerrar" id="cerrar" value="X" accesskey="X" onclick="xajax_cerrarVentana()"/>
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td>Matricula</td>
      <td><label>
        <input type="text" name="matricula" id="matricula" size="30" onKeyUp="this.value=this.value.toUpperCase();">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Asientos</td>
      <td><label>
        <input type="text" name="asientos" id="asientos" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>&nbsp;</td>
      <td><label></label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2">
      <div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onClick="xajax_agregarAvion(xajax.getFormValues(\'formularioAgregar\'))">
      </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $contenido;
}

function agregarAvion($datos){
    $controlBD = new controladorAvionBDclass();
    $avion = new Avionclass();
    $avion->setMatricula($datos[matricula]);
    $avion->setAsientos($datos[asientos]);
    $resultado = $controlBD->agregarAvion($avion);
    if ($resultado==true){
        $mensaje = 'Avion insertado con exito';
    }else{
        $mensaje = 'No se pudo insertar el avion';
    }
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("mensaje", "innerHTML", $mensaje);
    $actualizar = obtenerAviones();
    $objResponse->addAssign("gestionAvion", "innerHTML", $actualizar);

    return $objResponse;
}

function mostrarFormularioAgregar(){
    $resultado = insertarNuevoAvion();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izquierda", "innerHTML", $resultado);
    return $objResponse;
}

/**
 * Metodo para cerrar la ventana de los formularios
 * @return <ajaxResponse> objeto de respuesta para modificar el div
 */
function cerrarVentana() {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", $resultado);
    return $objResponse;
}

?>