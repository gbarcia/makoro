<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSucursalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';

function autoSugerir($busqueda){
    $activado = false;
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlSucursalLogicaclass();
    $recurso = $controlLogica->consultarSucursalIdNombreEstadoCiudad($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>HABLITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '<th>VER PERSONAL</th>';
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
                $SucursalMay = new Sucursalclass();
                $SucursalMay->setHabilitadoString($row[habilitado]);
                $resultado.= '<td>' . $row[nombre]. '</td>';
                $resultado.= '<td>' . $row[estado]. '</td>';
                $resultado.= '<td>' . $row[ciudad]. '</td>';
                $resultado.= '<td>' . $row[telefono] . '</td>';
                $resultado.= '<td>' . $SucursalMay->getHabilitado(). '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
                $resultado.= '<td><input type="checkbox" name="sucursales[]" value="'.$row[id].'"></td>';
                $resultado.= '<td><input type="button" value="VER PERSONAL" onclick="xajax_mostrar('.$row[id].')"/></td>';

                $resultado.= '</tr>';
                $color = !$color;
            }
        }
        else { // si no hay coincidencias
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else { // retorno o borrar datos
        $recurso = $controlLogica->consultarSucursales(TRUE);
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $SucursalMay = new Sucursalclass();
            $SucursalMay->setHabilitadoString($row[habilitado]);
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad]. '</td>';
            $resultado.= '<td>' . $row[telefono]. '</td>';
            $resultado.= '<td>' . $SucursalMay->getHabilitado(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
            $resultado.= '<td><input type="checkbox" name="sucursales[]" value="'.$row[id].'"></td>';
            $resultado.= '<td><input type="button" value="VER PERSONAL" onclick="xajax_mostrar('.$row[id].')"/></td>';

            $resultado.= '</tr>';
            $color = !$color;
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestionSucursal", "innerHTML", "$resultado");

    return $objResponse;
}

function cadenaTodasLasSucursales () {
    $resultado = "";
    $controlLogica = new ControlSucursalLogicaclass();
    $recurso = $controlLogica->consultarSucursales(TRUE);
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>HABLITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '<th>VER PERSONAL</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $SucursalMay = new Sucursalclass();
        $SucursalMay->setHabilitadoString($row[habilitado]);
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[estado]. '</td>';
        $resultado.= '<td>' . $row[ciudad]. '</td>';
        $resultado.= '<td>' . $row[telefono]. '</td>';
        $resultado.= '<td>' . $SucursalMay->getHabilitado(). '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
        $resultado.= '<td><input type="checkbox" name="sucursales[]" value="'.$row[id].'"></td>';
        $resultado.= '<td><input type="button" value="VER PERSONAL" onclick="xajax_mostrar('.$row[id].')"/></td>';

        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodasLasSucursales();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestionSucursal", "innerHTML", $resultado);
    return $objResponse;
}

function inabilitado ($ina) {
    if ($ina == "true") {
        $resultado = "";
        $objResponse = new xajaxResponse();
        $resultado = '<form id="formularioEditarMarcar">';
        $resultado.= '<table class="scrollTable" cellspacing="0">';
        $resultado.= '<thead>';
        $resultado.= '<tr>';
        $resultado.= '<th>NOMBRE</th>';
        $resultado.= '<th>ESTADO</th>';
        $resultado.= '<th>CIUDAD</th>';
        $resultado.= '<th>TELEFONO</th>';
        $resultado.= '<th>HABLITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '<th>VER PERSONAL</th>';
        $resultado.= '</tr>';
        $resultado.= '</thead>';
        $controlLogica = new ControlSucursalLogicaclass();
        $recurso = $controlLogica->consultarSucursales(0);
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $SucursalMay = new Sucursalclass();
            $SucursalMay->setHabilitadoString($row[habilitado]);
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad]. '</td>';
            $resultado.= '<td>' . $row[telefono]. '</td>';
            $resultado.= '<td>' . $SucursalMay->getHabilitado(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
            $resultado.= '<td><input type="checkbox" name="sucursales[]" value="'.$row[id].'"></td>';
            $resultado.= '<td><input type="button" value="VER PERSONAL" onclick="xajax_mostrar('.$row[id].')"/></td>';

            $resultado.= '</tr>';
            $color = !$color;
        }
        $resultado.= '</table>';
        $boton = crearBotonHabilitarTripulante();
        $objResponse->addAssign("gestionSucursal", "innerHTML", $resultado);
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);

    }
    else  { // los habilitados
        $resultado = "";
        $objResponse = new xajaxResponse();
        $resultado = '<form id="formularioEditarMarcar">';
        $resultado.= '<table class="scrollTable" cellspacing="0">';
        $resultado.= '<thead>';
        $resultado.= '<tr>';
        $resultado.= '<th>NOMBRE</th>';
        $resultado.= '<th>ESTADO</th>';
        $resultado.= '<th>CIUDAD</th>';
        $resultado.= '<th>TELEFONO</th>';
        $resultado.= '<th>HABLITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '<th>VER PERSONAL</th>';
        $resultado.= '</tr>';
        $resultado.= '</thead>';
        $controlLogica = new ControlSucursalLogicaclass();
        $recurso = $controlLogica->consultarSucursales(TRUE);
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $SucursalMay = new Sucursalclass();
            $SucursalMay->setHabilitadoString($row[habilitado]);
            $resultado.= '<td>' . $row[nombre]. '</td>';
            $resultado.= '<td>' . $row[estado]. '</td>';
            $resultado.= '<td>' . $row[ciudad]. '</td>';
            $resultado.= '<td>' . $row[telefono]. '</td>';
            $resultado.= '<td>' . $SucursalMay->getHabilitado(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
            $resultado.= '<td><input type="checkbox" name="sucursales[]" value="'.$row[id].'"></td>';
            $resultado.= '<td><input type="button" value="VER PERSONAL" onclick="xajax_editar('.$row[id].')"/></td>';

            $resultado.= '</tr>';
            $color = !$color;
        }
        $resultado.= '</table>';
        $resultado.= '</form>';
        $boton = crearBotonInhabilitarTripulante();
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);
        $objResponse->addAssign("gestionSucursal", "innerHTML", $resultado);
    }
    return $objResponse;
}

function crearBotonHabilitarTripulante () {
    $boton = '<input type="button" name="button3" id="button3" value="HABILITAR SELECCION" onclick="xajax_habilitar(xajax.getFormValues(\'formularioEditarMarcar\'))" />';
    return $boton;
}
/**
 * Metodo para generar el boton para inhabilitar tripulantes
 * @return <String> html para generar el boton
 */
function crearBotonInhabilitarTripulante () {
    $boton = '<input type="button" name="button3" id="button3" value="INHABILITAR SELECCION" onclick="xajax_inhabilitar(xajax.getFormValues(\'formularioEditarMarcar\'))" />';
    return $boton;
}

function desmarcarCheckBox () {
    $codigo = '<label>
   <input type="checkbox" name="desabilitado" value="0"
   onClick="xajax_inabilitado(document.formBusqueda.desabilitado.checked)" />
   </label><span class="styleLetras">Ver solo deshabilitados</span>';
    return $codigo;
}

function habilitar($lista) {
    $objResponse = new xajaxResponse();
    if ($lista[sucursales] != ""){
        $respuesta ="";
        $controlTripulante = new controladorSucursalBDclass();
        $objResponse->addConfirmCommands(6, "Esta seguro de habilitar la seleccion?");
        foreach ($lista[sucursales] as $trip) {
            $controlTripulante->eliminarRegenerarSucursal(1,$trip);
        }
        $actualizarCheck = desmarcarCheckBox();
        $boton = crearBotonInhabilitarTripulante();
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);
        $respuesta ='<div class="exito">
                          <div class="textoMensaje">
                          Sucursal(es) habilitada(s) con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLasSucursales();
        $objResponse->addAssign("gestionSucursal", "innerHTML", $actualizarTablaPrincipalRespuesta);
        $objResponse->addAssign("check", "innerHTML", $actualizarCheck);
        $objResponse->addScript("deseleccionar_todo()");
    }
    else {
        $respuesta = '<div class="advertencia">
                          <div class="textoMensaje">
                          Debe marcar alguna sucursal para habilitar.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function inhabilitar($lista) {
    $objResponse = new xajaxResponse();
    if ($lista[sucursales] != ""){
        $respuesta ="";
        $controlTripulante = new controladorSucursalBDclass();
        $objResponse->addConfirmCommands(6, "Esta seguro de inhabilitar la seleccion?");
        foreach ($lista[sucursales] as $trip) {
            $controlTripulante->eliminarRegenerarSucursal(0,$trip);
        }
        $actualizarCheck = desmarcarCheckBox();
        $boton = crearBotonInhabilitarTripulante();
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);
        $respuesta ='<div class="exito">
                          <div class="textoMensaje">
                          Sucursal(es) inhabilitada(s) con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLasSucursales();
        $objResponse->addAssign("gestionSucursal", "innerHTML", $actualizarTablaPrincipalRespuesta);
        $objResponse->addAssign("check", "innerHTML", $actualizarCheck);
        $objResponse->addScript("deseleccionar_todo()");
    }
    else {
        $respuesta = '<div class="advertencia">
                          <div class="textoMensaje">
                          Debe marcar alguna sucursal para inhabilitar.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function generarFormularioNuevaSucursal () {
    $formulario = '<form id="formNuevoCargo">
 <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVA SUCURSAL
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
<tr class="r1">
      <td colspan="2">Todos los campos son requeridos
        <input type="hidden" name="id" id="id" value= '.$row[id].' /></td>
      </tr>
    </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Estado</td>
      <td><label>
        <input type="text" name="estado" id="estado" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>Ciudad</td>
      <td><label>
        <input type="text" name="ciudad" id="ciudad" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Direccion</td>
      <td><input type="text" name="direccion" id="direccion" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Telefono</td>
      <td><input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarSucursal(xajax.getFormValues(\'formNuevoCargo\'))" />
      </div></td>
    </tr>
  </table>
  <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}
function desplegarFormularioNuevaSucursal () {
    $respuesta = generarFormularioNuevaSucursal();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}

function validarSucursal ($datos) {
    $resultado = false;
    if (is_string($datos[nombre]) && $datos[nombre] != "")
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
    if (is_string($datos[telefono]) && $datos[telefono] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesarSucursal($datos) {
    $repuesta = "";
    $objResponse = new xajaxResponse();
    if (validarSucursal($datos)) {
        $control = new ControlSucursalLogicaclass();
        $resultado = $control->nuevaSucursal($datos[nombre], $datos[estado], $datos[ciudad], $datos[direccion], $datos[telefono], 1);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nueva sucursal '.$datos[nombre]. ' agregada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion.Verifique el manual del usuario. CODIGO GSBD001.
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
                          No se pudo completar la operacion. El formulario no es correcro. CODIGO GSF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $actualizar = cadenaTodasLasSucursales();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $objResponse->addAssign("gestionSucursal", "innerHTML", $actualizar);
    return $objResponse;
}

function generarFormularioEditarSucursal ($id) {
    $control = new controladorSucursalBDclass();
    $recurso = $control->consultarSucursal($id);
    $row = mysql_fetch_array($recurso);
    $formulario = '<form id="formEditar">
 <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            EDITAR SUCURSAL
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">Todos los campos son requeridos
        <input type="hidden" name="id" id="id" value= '.$row[id].' /></td>
      </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" value= "'.$row[nombre].'"size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Estado</td>
      <td><label>
        <input type="text" name="estado" id="estado" value= "'.$row[estado].'"onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>Ciudad</td>
      <td><label>
        <input type="text" name="ciudad" id="ciudad" value= "'.$row[ciudad].'"onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Direccion</td>
      <td><input type="text" name="direccion" id="direccion" value= "'.$row[direccion].'"onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Telefono</td>
      <td><input type="text" name="telefono" id="telefono"value= "'.$row[telefono].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarSucursalEditar(xajax.getFormValues(\'formEditar\'))" />
      </div></td>
    </tr>
  </table>
  <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function editar ($id) {
    $respuesta = generarFormularioEditarSucursal($id);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}

function procesarSucursalEditar ($datos) {
    $repuesta = "";
    $objResponse = new xajaxResponse();
    if (validarSucursal($datos)) {
        $objResponse->addConfirmCommands(20, "Esta seguro de editar ".$datos[nombre]." ?");
        $control = new ControlSucursalLogicaclass();
        $resultado = $control->editarSucursal($datos[id],$datos[nombre], $datos[estado], $datos[ciudad], $datos[direccion], $datos[telefono], 1);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Sucursal '.$datos[nombre]. ' editada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion.Verifique el manual del usuario. CODIGO GSBD001.
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
                          No se pudo completar la operacion. El formulario no es correcro. CODIGO GSF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $actualizar = cadenaTodasLasSucursales();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $objResponse->addAssign("gestionSucursal", "innerHTML", $actualizar);
    return $objResponse;
}

function generarTablaEmpleados ($id) {
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado .= '<table class="formTable" cellspacing="0">';
    $resultado .= '<thead>';
    $resultado .= '<tr>';
    $resultado .= '<th>CEDULA</th>';
    $resultado .='<th>NOMBRE</th>';
    $resultado .= '<th>APELLIDO</th>';
    $resultado .= '<th>CARGO</th>';
    $resultado .= '</tr>';
    $resultado .= '</thead>';
    $controlBD = new ControlSucursalLogicaclass();
    $recurso = $controlBD->consultarEncargadosSucursal($id);
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
        $resultado.= '<td>' . $row[tipo]. '</td>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function mostrar($idSucursal) {
    $respuesta = generarTablaEmpleados($idSucursal);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("der", "innerHTML", $respuesta);
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
