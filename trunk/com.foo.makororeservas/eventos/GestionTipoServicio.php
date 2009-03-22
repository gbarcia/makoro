<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTipoServicioLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoServicio.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoServicioBD.class.php';

function cadenaTodosLosServicios () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>IDENTIFICADOR</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>ABREVIATURA</th>';
    $resultado.= '<th>VECES SOLICITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $controlLogica = new ControlTipoServicioLogicaclass();
    $recurso = $controlLogica->consultarServicios();
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[id]. '</td>';
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[abreviatura]. '</td>';
        $resultado.= '<td>' . $row[numero]. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_desplegarFormularioEditar(\''. $row[id] .'\')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodosLosServicios();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    return $objResponse;
}

function generarFormularioNuevoServicio () {
    $formulario ='<form id="formNuevoServicio">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVO SERVICIO
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">Todos los campos son requeridos</td>
      </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Abreviatura</td>
      <td><label>
        <input type="text" name="abreviatura" id="abrevitura" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesar(xajax.getFormValues(\'formNuevoServicio\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioNuevoServicio () {
    $resultado = generarFormularioNuevoServicio();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function validarFormularioServicio ($datos) {
    $resultado = false;
    if (is_string($datos[nombre]) && $datos[nombre] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[abreviatura]) && $datos[abreviatura] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesar ($datos) {
    $objResponse = new xajaxResponse();
    if (validarFormularioServicio($datos)) {
        $respuesta = "";
        $control = new ControlTipoServicioLogicaclass();
        $resultado = $control->nuevoTipoServicio($datos[abreviatura], $datos[nombre]);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nuevo SERVICIO agregado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que el nombre del servicio no exista.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodosLosServicios();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        if ($resultado)
        $objResponse->addAssign("izq", "innerHTML", "");
        }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. No puede dejar ningun campo en blanco
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function generarFormularioEditarServicio ($id) {
    $control = new controladorTipoServicioBDclass();
    $recurso = $control->consultarServicioId($id);
    $row = mysql_fetch_array($recurso);
    $formulario ='<form id="formNuevoServicio">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            EDITAR SERVICIO <input type="hidden" name="id" id="id" value="'.$row[id].'" />
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">Todos los campos son requeridos</td>
      </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" size="30" value = "'.$row[nombre].'"onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Abreviatura</td>
      <td><label>
        <input type="text" name="abreviatura" value = "'.$row[abreviatura].'" id="abrevitura" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarEditar(xajax.getFormValues(\'formNuevoServicio\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}


function desplegarFormularioEditar ($id) {
    $resultado = generarFormularioEditarServicio($id);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}


function cerrarVentana() {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    $objResponse->addAssign("Mensaje", "innerHTML", $resultado);
    return $objResponse;
}

function borrarMensaje(){
    $respuesta = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function procesarEditar ($datos) {
    $objResponse = new xajaxResponse();
    if (validarFormularioServicio($datos)) {
        $respuesta = "";
        $control = new ControlTipoServicioLogicaclass();
        $resultado = $control->actualizarTipoServicio($datos[id], $datos[abreviatura], $datos[nombre], 1);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Servicio actualizado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que el nombre del servicio no exista.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodosLosServicios();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        if ($resultado)
        $objResponse->addAssign("izq", "innerHTML", "");
        }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. No puede dejar ningun campo en blanco
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}
?>