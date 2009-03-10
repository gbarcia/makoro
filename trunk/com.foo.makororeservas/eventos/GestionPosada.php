<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPosadaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Posada.class.php';


function cadenaTodasLasPosadas () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>NOMBRE POSADA</th>';
    $resultado.= '<th>NOMBRE ENCARGADO</th>';
    $resultado.= '<th>APELLIDO ENCARGADO</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>OPCION</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $controlLogica = new controladorPosadaBDclass();
    $recurso = $controlLogica->consultarPosadas();
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[nombrePosada] . '</td>';
        $resultado.= '<td>' . $row[nombreEncargado] . '</td>';
        $resultado.= '<td>' . $row[apellidoEncargado] . '</td>';
        $resultado.= '<td>' . $row[telefono] . '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_desplegarFormularioEditarPosada('. $row[id] .')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodasLasPosadas();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    return $objResponse;
}

function generarFormularioNuevaPosada () {
    $formulario ='<form id="formNuevaPosada">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVA POSADA
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
      <td>Nombre de la posada</td>
      <td><label>
        <input type="text" name="nombrePosada" id="nombrePosada" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Nombre Encargado de la Posada</td>
      <td><label>
        <input type="text" name="nombreE" id="nombreE" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>Apellido del Encargado de la Posada</td>
      <td><label>
        <input type="text" name="apellidoE" id="apellidoE" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Telefono de Contacto</td>
      <td><input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
<tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarPosada(xajax.getFormValues(\'formNuevaPosada\'))" />
      </div></td>
    </tr>
  </table><label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioNuevaPosada () {
    $resultado = generarFormularioNuevaPosada();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function validarFormularioPosada ($datos) {
    $resultado = false;
    if (is_string($datos[nombrePosada]) && $datos[nombrePosada] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[nombreE]) && $datos[nombreE] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[apellidoE]) && $datos[apellidoE] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[telefono]) && $datos[telefono] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesarPosada ($datos) {
    $objResponse = new xajaxResponse();
    if (validarFormularioPosada($datos)) {
        $respuesta = "";
        $controlRuta = new controladorPosadaBDclass();
        $posada = new Posadaclass();
        $posada->setNombrePosada($datos[nombrePosada]);
        $posada->setNombreEncargado($datos[nombreE]);
        $posada->setApellidoEncargado($datos[apellidoE]);
        $posada->setTelefono($datos[telefono]);
        $resultado = $controlRuta->agregarPosada($posada);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nueva POSADA agregada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que la posada no existe.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLasPosadas();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        $objResponse->addAssign("izq", "innerHTML", "");
    }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. No debe dejar ningun campo sin llenar.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function generarFormularioEditar ($id) {
    $control = new controladorPosadaBDclass();
    $recurso = $control->consultarPosadaID($id);
    $row = mysql_fetch_array($recurso);
    $formulario ='<form id="formNuevaPosada">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            EDITAR POSADA<input type="hidden" name="id" id="id" value = "'.$row[id].'"/>
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
      <td>Nombre de la posada</td>
      <td><label>
        <input type="text" name="nombrePosada" value = "'.$row[nombrePosada].'" id="nombrePosada" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Nombre Encargado de la Posada</td>
      <td><label>
        <input type="text" name="nombreE" id="nombreE" value = "'.$row[nombreEncargado].'" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>Apellido del Encargado de la Posada</td>
      <td><label>
        <input type="text" name="apellidoE" id="apellidoE" value = "'.$row[apellidoEncargado].'" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Telefono de Contacto</td>
      <td><input type="text" name="telefono" id="telefono" value = "'.$row[telefono].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
<tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarEditarPosada(xajax.getFormValues(\'formNuevaPosada\'))" />
      </div></td>
    </tr>
  </table><label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioEditarPosada ($id) {
    $resultado = generarFormularioEditar($id);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function procesarEditarPosada ($datos) {
    $objResponse = new xajaxResponse();
    if (validarFormularioPosada($datos)) {
        $respuesta = "";
        $controlRuta = new controladorPosadaBDclass();
        $posada = new Posadaclass();
        $posada->setId($datos[id]);
        $posada->setNombrePosada($datos[nombrePosada]);
        $posada->setNombreEncargado($datos[nombreE]);
        $posada->setApellidoEncargado($datos[apellidoE]);
        $posada->setTelefono($datos[telefono]);
        $resultado = $controlRuta->editarPosada($posada);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Posada actualizada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que la posada no existe.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLasPosadas();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        $objResponse->addAssign("izq", "innerHTML", "");
    }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. No debe dejar ningun campo sin llenar.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
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

?>
