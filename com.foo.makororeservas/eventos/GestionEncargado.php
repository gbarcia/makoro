<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';

/**
 * Metodo xajax para autosugerir un encargado
 * @param <type> $busqueda la busqueda a realizar y comparar con el sistema
 * @return <type> objeto de respuesta xjax
 */
function autoSugerir($busqueda){
    $activado = false;
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlBD = new controladorSeguridadBDclass();
    $recurso = $controlBD->busquedaEncargadoAutoSugerir($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="tabla">';
    $resultado.= '<tr class="titulo">';
    $resultado.= '<th>CEDULA</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>APELLIDO</th>';
    $resultado.= '<th>SEXO</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>CARGO</th>';
    $resultado.= '<th>SUCURSAL</th>';
    $resultado.= '<th>HABILITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '</tr>';
    if (isset($busqueda)) {
        if ($numFilas > 0){ //Si hay coincidencias
            $color = false;
            while ($row = mysql_fetch_array($recurso)) {
                if ($color){
                    $resultado.= '<tr class="r0">';
                } else {
                    $resultado.= '<tr class="r1">';
                }
                $encargado = new Encargadoclass();
                $encargado->setHabilitado($row[habilitado]);
                $resultado.= '<td>' . $row[cedula]. '</td>';
                $resultado.= '<td>' . $row[nombre]. '</td>';
                $resultado.= '<td>' . $row[apellido]. '</td>';
                $resultado.= '<td>' . $row[sexo]. '</td>';
                $resultado.= '<td>' . $row[telefono] . '</td>';
                $resultado.= '<td>' . $row[estado]. '</td>';
                $resultado.= '<td>' . $row[ciudad]. '</td>';
                $resultado.= '<td>' . $row[tipo]. '</td>';
                $resultado.= '<td>' . $row[nSucursal].'</td>';
                $resultado.= '<td>' . $encargado->getHabilitadoString(). '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[cedula].')"/></td>';
                $resultado.= '<td><input type="checkbox" name="encargados[]" value="'.$row[cedula].'"></td>';
                $resultado.= '</tr>';
                $color = !$color;
            }
        }
        else { // si no hay coincidencias
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else { // retorno o borrar datos
        $recurso = $controlBD->traerTodosLosEncargados(TRUE);
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $encargado = new Encargadoclass();
            $encargado->setHabilitado($row[habilitado]);
            $resultado.= '<td>' . $row[cedula]. '</td>';
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[apellido]. '</td>';
            $resultado.= '<td>' . $row[sexo]. '</td>';
            $resultado.= '<td>' . $row[telefono] . '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad]. '</td>';
            $resultado.= '<td>' . $row[tipo]. '</td>';
            $resultado.= '<td>' . $row[nSucursal].'</td>';
            $resultado.= '<td>' . $encargado->getHabilitadoString(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[cedula].')"/></td>';
            $resultado.= '<td><input type="checkbox" name="encargados[]" value="'.$row[cedula].'"></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestionEncargado", "innerHTML", "$resultado");

    return $objResponse;
}
/**
 * Metodo que retorna el codigo html para mostrar todos los encargados registrados
 * @return <String> codigo HTML
 */
function CadenaTodosLosEmpleados () {
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="tabla">';
    $resultado.= '<tr class="titulo">';
    $resultado.= '<th>CEDULA</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>APELLIDO</th>';
    $resultado.= '<th>SEXO</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>CARGO</th>';
    $resultado.= '<th>SUCURSAL</th>';
    $resultado.= '<th>HABILITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '</tr>';
    $controlBD = new controladorSeguridadBDclass();
    $recurso = $controlBD->traerTodosLosEncargados(TRUE);
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $encargado = new Encargadoclass();
        $encargado->setHabilitado($row[habilitado]);
        $resultado.= '<td>' . $row[cedula]. '</td>';
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[apellido]. '</td>';
        $resultado.= '<td>' . $row[sexo]. '</td>';
        $resultado.= '<td>' . $row[telefono] . '</td>';
        $resultado.= '<td>' . $row[estado]. '</td>';
        $resultado.= '<td>' . $row[ciudad]. '</td>';
        $resultado.= '<td>' . $row[tipo]. '</td>';
        $resultado.= '<td>' . $row[nSucursal]. '</td>';
        $resultado.= '<td>' . $encargado->getHabilitadoString(). '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[cedula].')"/></td>';
        $resultado.= '<td><input type="checkbox" name="encargados[]" value="'.$row[cedula].'"></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}
/**
 * Metodo para mostrar todos los vencargados al inicio
 * @return <xajaxResponse> respuesta del servidor
 */
function mostrarInicio() {
    $objResponse = new xajaxResponse();
    $resultado = CadenaTodosLosEmpleados();
    $objResponse->addAssign("gestionEncargado", "innerHTML", "$resultado");
    return $objResponse;
}


/**
 * Funcion con xjax para consultar todo el personal inhabilitado y regresar
 * a consultar los habilitados
 * @param <boolean> $ina 0 para mostrar todos los inhabilitados y 1 los habilitados
 * @return <xajaxObjeto> respuesta del servidor
 */
function inabilitado ($ina) {
    if ($ina == "true") {
        $resultado = "";
        $objResponse = new xajaxResponse();
        $resultado = '<form id="formularioEditarMarcar">';
        $resultado.= '<table class="tabla">';
        $resultado.= '<tr class="titulo">';
        $resultado.= '<th>CEDULA</th>';
        $resultado.= '<th>NOMBRE</th>';
        $resultado.= '<th>APELLIDO</th>';
        $resultado.= '<th>SEXO</th>';
        $resultado.= '<th>TELEFONO</th>';
        $resultado.= '<th>ESTADO</th>';
        $resultado.= '<th>CIUDAD</th>';
        $resultado.= '<th>CARGO</th>';
        $resultado.= '<th>SUCURSAL</th>';
        $resultado.= '<th>HABILITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '</tr>';
        $controlBD = new controladorSeguridadBDclass();
        $recurso = $controlBD->traerTodosLosEncargados(FALSE);
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $encargado = new Encargadoclass();
            $encargado->setHabilitado($row[habilitado]);
            $resultado.= '<td>' . $row[cedula]. '</td>';
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[apellido]. '</td>';
            $resultado.= '<td>' . $row[sexo]. '</td>';
            $resultado.= '<td>' . $row[telefono] . '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad]. '</td>';
            $resultado.= '<td>' . $row[tipo]. '</td>';
            $resultado.= '<td>' . $row[nSucursal]. '</td>';
            $resultado.= '<td>' . $encargado->getHabilitadoString(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[cedula].')"/></td>';
            $resultado.= '<td><input type="checkbox" name="encargados[]" value="'.$row[cedula].'"></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
        $resultado.= '</table>';
        $boton = crearBotonHabilitarTripulante();
        $objResponse->addAssign("gestionEncargado", "innerHTML", $resultado);
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);

    }
    else  { // los habilitados
        $resultado = "";
        $objResponse = new xajaxResponse();
        $resultado = '<form id="formularioEditarMarcar">';
        $resultado.= '<table class="tabla">';
        $resultado.= '<tr class="titulo">';
        $resultado.= '<th>CEDULA</th>';
        $resultado.= '<th>NOMBRE</th>';
        $resultado.= '<th>APELLIDO</th>';
        $resultado.= '<th>SEXO</th>';
        $resultado.= '<th>TELEFONO</th>';
        $resultado.= '<th>ESTADO</th>';
        $resultado.= '<th>CIUDAD</th>';
        $resultado.= '<th>CARGO</th>';
        $resultado.= '<th>SUCURSAL</th>';
        $resultado.= '<th>HABILITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '</tr>';
        $controlBD = new controladorSeguridadBDclass();
        $recurso = $controlBD->traerTodosLosEncargados(TRUE);
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $encargado = new Encargadoclass();
            $encargado->setHabilitado($row[habilitado]);
            $resultado.= '<td>' . $row[cedula]. '</td>';
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[apellido]. '</td>';
            $resultado.= '<td>' . $row[sexo]. '</td>';
            $resultado.= '<td>' . $row[telefono] . '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad]. '</td>';
            $resultado.= '<td>' . $row[tipo]. '</td>';
            $resultado.= '<td>' . $row[nSucursal]. '</td>';
            $resultado.= '<td>' . $encargado->getHabilitadoString(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[cedula].')"/></td>';
            $resultado.= '<td><input type="checkbox" name="encargados[]" value="'.$row[cedula].'"></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
        $resultado.= '</table>';
        $resultado.= '</form>';
        $boton = crearBotonInhabilitarTripulante();
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);
        $objResponse->addAssign("gestionEncargado", "innerHTML", $resultado);
    }
    return $objResponse;
}

/**
 * Metodo para generar el boton par habilitar los tripulantes
 * @return <String> html para generar el boton
 */
function crearBotonHabilitarTripulante () {
    $boton = '<input type="button" name="button3" id="button3" value="HABLITAR SELECCION" onclick="xajax_habilitarTripulante(xajax.getFormValues(\'formularioEditarMarcar\'))" />';
    return $boton;
}
/**
 * Metodo para generar el boton para inhabilitar tripulantes
 * @return <String> html para generar el boton
 */
function crearBotonInhabilitarTripulante () {
    $boton = '<input type="button" name="button3" id="button3" value="INHABLITAR SELECCION" onclick="xajax_eliminarTripulante(xajax.getFormValues(\'formularioEditarMarcar\'))" />';
    return $boton;
}

function generarFormularioNuevoVendedor () {
    $formulario = '<form name="formularioNuevoEncargado" id = "formularioNuevoEncargado"> <script type="text/javascript">
            Calendar.setup({
                inputField     :    "fechaNac",     // id of the input field
                ifFormat       :    "%Y-%m-%d",      // format of the input field
                button         :    "f_trigger_c",  // trigger for the calendar (button ID)
                align          :    "Tl",           // alignment (defaults to "Bl")
                singleClick    :    true
            });
        </script>' ;
    $formulario .= '<table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td width="156">NUEVO VENDEDOR</td>
      <td width="242"><div align="right">
        <label>
        <input type="button" name="cerrar" id="cerrar" value="X" />
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td colspan="2">Todos los campos son obligatorios</td>
    </tr>
    <tr class="r1">
      <td>Cedula</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Apellido</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Sexo</td>
      <td><p>
        <label>
          <input type="radio" name="sexo" value="radio" id="sexo_0">
          Masculino</label>
        <br>
        <label>
          <input type="radio" name="sexo" value="radio" id="sexo_1">
          Femenino</label>
      </td>
    </tr>
    <tr class="r1">
      <td>Telefono</td>
      <td><label>
        <input type="text" name="telefono" id="telefono" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Estado de residencia</td>
      <td><label>
        <input type="text" name="estado" id="estado" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Ciudad de residencia</td>
      <td><label>
        <input type="text" name="ciudad" id="ciudad" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Direccion de residencia</td>
      <td><label>
        <textarea name="direccion" id="direccion" cols="23" onKeyUp="this.value=this.value.toUpperCase();" rows="3"></textarea>
      </label></td>
    </tr>
    <tr class="r1">
      <td>Cargo en el sistema</td>
      <td><label>
        <select name="tipo" id="tipo">
        </select>
      </label></td>
    </tr>
    <tr class="r1">
      <td>Fecha de Nacimiento</td>
      <td><input type="text" name="fechaNac" id="fechaNac" readonly="1" size="15" /></td><td<img src="img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector"
/></td>
    </tr>
    <tr class="r1">
      <td>correo electr&oacute;nico</td>
      <td><input type="text" name="correo" id="correo" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>login</td>
      <td><input type="text" name="login" id="login" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Sucursal</td>
      <td><select name="sucursal" id="sucursal">
            </select></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button"  value="AGREGAR">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $formulario;
}

function mostrarFormularioNuevoVendedor() {
    $formulario = generarFormularioNuevoVendedor();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", "$formulario");
    return $objResponse;
}
?>
