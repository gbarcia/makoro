<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';

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
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_mostrarFormularioEditar('.$row[cedula].')"/></td>';
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
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_mostrarFormularioEditar('.$row[cedula].')"/></td>';
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
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_mostrarFormularioEditar('.$row[cedula].')"/></td>';
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
/**
 * Metodo para generar el formulario para crear un nuevo vendedor
 * @return <String> codigo html para generar el formulario
 */
function generarFormularioNuevoVendedor () {
    $controlSucursal = new ControlSucursalLogicaclass();
    $recursoSucursal = $controlSucursal->consultarSucursales();
    $formulario = '<form name="formularioNuevoEncargado" id = "formularioNuevoEncargado"><table cellpadding="2" cellspacing="1">
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
          <input type="radio" name="sexo" value="M" id="sexo_0">
          Masculino</label>
        <br>
        <label>
          <input type="radio" name="sexo" value="F" id="sexo_1">
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
          <option value="V" selected="selected">Vendedor</option>
          <option value="A">Administrador</option>
        </select>
      </label></td>
    </tr>
    <tr class="r0">
      <td>Fecha de Nacimiento</td>
      <td><input type="text" name="fechaNac" id="f_date_c" readonly="1" size="15" /><img src="jscalendar/img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector"
</td>
    </tr>
    <tr class="r1">
      <td>correo electr&oacute;nico</td>
      <td><input type="text" name="correo" id="correo" size="30" onKeyUp="this.value=this.value.toLowerCase();" /></td>
    </tr>
        <tr class="r0">
      <td>repita correo electr&oacute;nico</td>
      <td><input type="text" name="correor" id="correor" size="30" onKeyUp="this.value=this.value.toLowerCase();" /></td>
        </tr>
    <tr class="r1">
      <td>login</td>
      <td><input type="text" name="login" id="login" size="30" onKeyUp="this.value=this.value.toLowerCase();" /></td>
    </tr>
    <tr class="r0">
      <td>Sucursal</td>
      <td><select name="sucursal" id="sucursal">';
    while ($rowS = mysql_fetch_array($recursoSucursal)) {
        $formulario .= '<option value="'.$rowS[id].'"';
        $formulario .= '>'.$rowS[nombre].'</option>';
    }
           $formulario.=' </select></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button"  value="AGREGAR" onclick = "xajax_procesarNuevoEncargado(xajax.getFormValues(\'formularioNuevoEncargado\'))">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $formulario;
}
/**
 * Cogigo para mostrar el formulario de un nuevo vendedor
 * @return <xAjaxResponse> respuesta del servidor
 */
function mostrarFormularioNuevoVendedor() {
    $formulario = generarFormularioNuevoVendedor();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", "$formulario");
    $objResponse->addScript('
    Calendar.setup({
        inputField     :    "f_date_c",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });');
    return $objResponse;
}
/**
 * Metodo para validar un vendedor
 * @param <Array> $datos los datos del formulario
 * @return <boolean> resultado de la validacion
 */
function validarForumularioNuevoVendedor ($datos) {
    $resultado = false;
    if (is_numeric($datos[cedula]) && $datos[cedula] != "") 
        $resultado = true;
    else return false;
    if (is_string($datos[nombre]) && $datos[nombre] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[apellido]) && $datos[apellido] != "")
    $resultado = true;
    else return false;
    if ($datos[sexo] == 'M' || $datos[sexo] == 'F')
    $resultado = true;
    else return false;
    if (is_string($datos[telefono]) && $datos[telefono] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[estado]) && $datos[estado] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[ciudad]) && $datos[ciudad] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[direccion]) && $datos[direccion] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[tipo]) && $datos[tipo] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[correo]) && $datos[correo] != "")
    $resultado =true;
    else return false;
    if (is_string($datos[login]) && $datos[login] != "")
    $resultado =true;
    else return false;
    if (is_numeric($datos[sucursal]) && $datos[sucursal] != "")
    $resultado =true;
    else return false;
    if (is_string($datos[correor]) && $datos[correor] != "")
    $resultado =true;
    else return false;
    if ($datos[correo] == $datos[correor])
    $resultado =true;
    else return false;
    if ($datos[fechaNac] != "")
    $resultado =true;
    else return false;

    return $resultado;
}
/**
 * Metodo para procesar en el sistema un nuevo encargado
 * @param <array> $datos los datos del formulario
 * @return <xajaxResponse> rspuesta del servidor con el resultado de la operacion
 */
function procesarNuevoEncargado ($datos) {
    $objResponse = new xajaxResponse();
    if (validarForumularioNuevoVendedor($datos)) {
    $respuesta = "";
    $controlLogica = new ControlSeguridadclass();
    $encargado = new Encargadoclass();
    $encargado->setApellido($datos[apellido]);
    $encargado->setCedula($datos[cedula]);
    $encargado->setCiudad($datos[ciudad]);
    $encargado->setCorreo($datos[correo]);
    $encargado->setDireccion($datos[direccion]);
    $encargado->setEstado($datos[estado]);
    $encargado->setFechaNac($datos[fechaNac]);
    $encargado->setHabilitado(1);
    $encargado->setLogin($datos[login]);
    $encargado->setNombre($datos[nombre]);
    $encargado->setSexo($datos[sexo]);
    $encargado->setSucursalDondeTrabaja($datos[sucursal]);
    $encargado->setTelefono($datos[telefono]);
    $encargado->setTipo($datos[tipo]);
    $resultado = $controlLogica->nuevoEncargado($encargado, $datos[correor]);
   $objResponse = new xajaxResponse();
   if ($resultado){
         $respuesta .= '<div class="exito">Nuevo Vendedor '.$datos[cedula]. ' agregado con exito <input name="button" type="button" id="button" value="X" onclick="xajax_borrarMensaje()">';
         $objResponse->addAssign("izq", "innerHTML", "");
   }
   else {
       $respuesta .= '<div class="error">No se pudo completar la operacion. Error FE001 <input name="button" type="button" id="button" value="X" onclick="xajax_borrarMensaje()"></div>';
   }
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $actualizarTablaPrincipalRespuesta = CadenaTodosLosEmpleados();
    $objResponse->addAssign("gestionEncargado", "innerHTML", $actualizarTablaPrincipalRespuesta);
    }
    else {
        $respuesta .= '<div class="error">No se pudo completar la operacion. Los datos del formulario no son correctos. ERROR FGE02 <input name="button" type="button" id="button" value="X" onclick="xajax_borrarMensaje()"></div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}
/**
 * Metodo para generar el formulario para editar un encargado
 * @param <Integer> $cedula la cedula del encargado a editar
 * @return <String> codigo HTML para generar el formulario
 */
function generarFormularioEditar ($cedula) {
    $controlSucursal = new ControlSucursalLogicaclass();
    $controlBD = new controladorSeguridadBDclass();
    $encargado = $controlBD->buscarEncargadoPorCedula($cedula);
    $recursoSucursal = $controlSucursal->consultarSucursales();
    $formulario = '<form name="formularioEditarEncargado" id = "formularioEditarEncargado">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td width="161">EDITAR VENDEDOR</td>
      <td width="242"><div align="right">
        <label>
        <input type="submit" name="cerrar" id="cerrar" value="X" accesskey="X" />
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td colspan="2">Todos los campos son obligatorios</td>
    </tr>
    <tr class="r1">
      <td>Cedula</td>
      <td><label>
        <input name="cedula" type="text" id="cedula" value="'.$encargado->getCedula().'" READONLY size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" size="30" onKeyUp="this.value=this.value.toUpperCase();" value="'.$encargado->getNombre().'">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Apellido</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" size="30" onKeyUp="this.value=this.value.toUpperCase();" value="'.$encargado->getApellido().'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Sexo</td>
      <td><p>
        <label>
          <input type="radio" name="sexo" value="M" id="sexo_0"';
    if($encargado->getSexo() == 'M'){
        $formulario.= 'checked="checked"';
    }
    $formulario.= '>Masculino</label>
        <br>
        <label>
          <input type="radio" name="sexo" value="F" id="sexo_1"';
    if($encargado->getSexo() == 'F'){
        $formulario.= 'checked="checked"';
    }
    $formulario.= '>Femenino</label>
      </td>
    </tr>
    <tr class="r1">
      <td>Telefono</td>
      <td><label>
        <input type="text" name="telefono" id="telefono" size="30" onKeyUp="this.value=this.value.toUpperCase();" value="'.$encargado->getTelefono().'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Estado de residencia</td>
      <td><label>
        <input type="text" name="estado" id="estado" size="30" onKeyUp="this.value=this.value.toUpperCase();" value="'.$encargado->getEstado().'">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Ciudad de residencia</td>
      <td><label>
        <input type="text" name="ciudad" id="ciudad" size="30" onKeyUp="this.value=this.value.toUpperCase();" value="'.$encargado->getCiudad().'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Direccion de residencia</td>
      <td><label>
        <textarea name="direccion" id="direccion" cols="23" rows="3"onKeyUp="this.value=this.value.toUpperCase();">'.$encargado->getDireccion().'</textarea>
      </label></td>
    </tr>
    <tr class="r1">
      <td>Cargo en el sistema</td>
      <td><label>
        <select name="tipo" id="tipo">';
        $formulario .= '<option value="V"';
        if ($encargado->getTipo() == 'V')
        $formulario .= 'selected="selected"';
        $formulario .= '>Vendedor</option>';
        $formulario .= '<option value="A"';
        if ($encargado->getTipo() == 'A')
        $formulario .= 'selected="selected"';
        $formulario .= '>Administrador</option>';
    $formulario .='</select>
      </label></td>
    </tr>
    <tr class="r0">
      <td>Fecha de Nacimiento</td>
      <td><input type="text" name="fechaNac" id="f_date_c" readonly="1" size="15" value="'.$encargado->getFechaNac().'" /><img src="jscalendar/img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector"
</td>
    </tr>
    <tr class="r1">
      <td>correo electr&oacute;nico</td>
      <td><input type="text" name="correo" id="correo" size="30" value = "'.$encargado->getCorreo().'" onKeyUp="this.value=this.value.toLowerCase();" /></td>
    </tr>
    <tr class="r1">
      <td>repetir correo electr&oacute;nico</td>
      <td><input type="text" name="correor" id="correor" size="30" value = "solo en caso de editar el correo" onKeyUp="this.value=this.value.toLowerCase();" onclick= "colocarEnBlanco()" /></td>
    </tr>
    <tr class="r0">
      <td>login</td>
      <td><input type="text" name="login" id="login" READONLY value="'.$encargado->getLogin().'" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Sucursal</td>
      <td><select name="sucursal" id="sucursal">';
    while ($rowS = mysql_fetch_array($recursoSucursal)) {
        $formulario .= '<option value="'.$rowS[id].'"';
        if ($rowS[id] == $encargado->getSucursalDondeTrabaja())
        $formulario .= 'selected="selected"';
        $formulario .= '>'.$rowS[nombre].'</option>';
    }
           $formulario.= '</select></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" value="EDITAR" onclick="xajax_procesarEditarEncargado(xajax.getFormValues(\'formularioEditarEncargado\'))">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $formulario;
}
/**
 * Metodo para mostrar el formulario para editar un encargado
 * @param <Integer> $cedula la cedula del encargado a editar
 * @return <xAjaxResponse> respuesta del servidor
 */
function mostrarFormularioEditar ($cedula) {
    $formulario = generarFormularioEditar($cedula);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", "$formulario");
    $objResponse->addScript('
    Calendar.setup({
        inputField     :    "f_date_c",     // id of the input field
        ifFormat       :    "%Y-%m-%d",      // format of the input field
        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
        align          :    "Tl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });');
    return $objResponse;
}

?>
