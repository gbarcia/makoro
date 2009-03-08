<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlClienteAgenciaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteAgencia.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorClienteAgenciaBD.class.php';

function autoSugerir($busqueda){
    $activado = false;
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlClienteAgenciaLogicaclass();
    $recurso = $controlLogica->busquedaClienteAgenciaRifNombre($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>RIF</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>DIRECCION</th>';
    $resultado.= '<th>% DESCUENTO</th>';
    $resultado.= '<th>EDITAR</th>';
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
                $resultado.= '<td>' . $row[rif]. '</td>';
                $resultado.= '<td>' . $row[nombre]. '</td>';
                $resultado.= '<td>' . $row[telefono]. '</td>';
                $resultado.= '<td>' . $row[estado]. '</td>';
                $resultado.= '<td>' . $row[ciudad] . '</td>';
                $resultado.= '<td>' . $row[direccion] . '</td>';
                $resultado.= '<td>' . $row[porcentajeComision] . '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar(\''. $row[rif] .'\')"/></td>';
                $resultado.= '</tr>';
                $color = !$color;
            }
        }
        else { // si no hay coincidencias
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else { // retorno o borrar datos
        $controlBD = new controladorClienteAgenciaBDclass();
        $recurso = $controlBD->consultarTodasLasAgencias();
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $resultado.= '<td>' . $row[rif]. '</td>';
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[telefono]. '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad] . '</td>';
            $resultado.= '<td>' . $row[direccion] . '</td>';
            $resultado.= '<td>' . $row[porcentajeComision] . '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar(\''. $row[rif] .'\')"/></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestionAgencia", "innerHTML", "$resultado");

    return $objResponse;
}

function cadenaTodasLasAgencias () {
    $resultado = "";
    $controlBD = new controladorClienteAgenciaBDclass();
    $recurso = $controlBD->consultarTodasLasAgencias();
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>RIF</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>DIRECCION</th>';
    $resultado.= '<th>%DESCUENTO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[rif]. '</td>';
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[telefono]. '</td>';
        $resultado.= '<td>' . $row[estado]. '</td>';
        $resultado.= '<td>' . $row[ciudad] . '</td>';
        $resultado.= '<td>' . $row[direccion] . '</td>';
        $resultado.= '<td>' . $row[porcentajeComision] . '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar(\''. $row[rif] .'\')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodasLasAgencias();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestionAgencia", "innerHTML", $resultado);
    return $objResponse;
}

function generarFormularioNuevaAgencia () {
    $formulario = '<form id="formNuevaAgencia">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVA AGENCIA
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">(*) Son campos obligatorios</td>
      </tr>
    <tr class="r0">
      <td>* RIF</td>
      <td><label>
        <input type="text" name="rif" id="rif" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>* Nombre de la Agencia</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>* Telefono</td>
      <td><label>
        <input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Estado</td>
      <td><input type="text" name="estado" id="estado" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Ciudad</td>
      <td><input type="text" name="ciudad" id="ciudad" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Direccion</td>
      <td><input type="text" name="direccion" id="direccion" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Porcentaje de Descuento</td>
      <td><input name="porcentaje" type="text" id="porcentaje" size="30" /></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarAgencia(xajax.getFormValues(\'formNuevaAgencia\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function mostrarFormularioAgregar () {
    $respuesta = generarFormularioNuevaAgencia();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}

function validarAgencia ($datos) {
    $resultado = false;
    if (is_string($datos[rif]) && $datos[rif] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[nombre]) && $datos[nombre] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[telefono]) && $datos[telefono] != "")
    $resultado = true;
    else return false;
    if (is_numeric($datos[porcentaje]) && $datos[porcentaje] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesarAgencia($datos) {
    $repuesta = "";
    $objResponse = new xajaxResponse();
    if (validarAgencia($datos)) {
        $control = new ControlClienteAgenciaLogicaclass();
        $resultado = $control->nuevoClienteAgencia($datos[rif], $datos[nombre], $datos[telefono], $datos[direccion], $datos[estado], $datos[ciudad], $datos[porcentaje]);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nueva agencia '.$datos[nombre]. ' agregada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion.Verifique el manual del usuario. CODIGO GCABD001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
    }
    else {
        $respuesta ='<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. El formulario no es correcro. CODIGO GCAF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $actualizar = cadenaTodasLasAgencias();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $objResponse->addAssign("gestionAgencia", "innerHTML", $actualizar);
    return $objResponse;
}

function generarFormularioEditar ($rif) {
    $control = new controladorClienteAgenciaBDclass();
    $recurso = $control->consultarAgencia($rif);
    $row = mysql_fetch_array($recurso);
    $formulario = '<form id="formAgencia">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            EDITAR AGENCIA
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">(*) Son campos obligatorios</td>
      </tr>
    <tr class="r0">
      <td>* RIF</td>
      <td><label>
        <input type="text" name="rif" id="rif" value = "'.$row[rif].'" READONLY size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>* Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" value = "'.$row[nombre].'" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>* Telefono</td>
      <td><label>
        <input type="text" name="telefono" id="telefono" value = "'.$row[telefono].'" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Estado</td>
      <td><input type="text" name="estado" id="estado" value = "'.$row[estado].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Ciudad</td>
      <td><input type="text" name="ciudad" id="ciudad" value = "'.$row[ciudad].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Direccion</td>
      <td><input type="text" name="direccion" id="direccion" value = "'.$row[direccion].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Porcentaje de Descuento</td>
      <td><input name="porcentaje" type="text" id="porcentaje" size="30" value = "'.$row[porcentajeComision].'" /></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarEditar(xajax.getFormValues(\'formAgencia\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function editar ($rif) {
    $respuesta = generarFormularioEditar($rif);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}

function procesarEditar($datos) {
    $repuesta = "";
    $objResponse = new xajaxResponse();
    if (validarAgencia($datos)) {
        $control = new ControlClienteAgenciaLogicaclass();
        $resultado = $control->actualizarClienteAgencia($datos[rif], $datos[nombre], $datos[telefono], $datos[direccion], $datos[estado], $datos[ciudad], $datos[porcentaje]);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Agencia '.$datos[nombre]. ' actualizada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion.Verifique el manual del usuario. CODIGO GCABD001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
    }
    else {
        $respuesta ='<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. El formulario no es correcro. CODIGO GCAF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $actualizar = cadenaTodasLasAgencias();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $objResponse->addAssign("gestionAgencia", "innerHTML", $actualizar);
    return $objResponse;
}

function borrarMensaje(){
    $respuesta = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function cerrarVentana() {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    $objResponse->addAssign("Mensaje", "innerHTML", $resultado);
    return $objResponse;
}

?>
