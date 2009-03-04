<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlClienteParticularLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteParticular.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorClienteParticularBD.class.php';


function autoSugerir($busqueda){
    $activado = false;
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlClienteParticularLogicaclass();
    $recurso = $controlLogica->consultarClientesParticularesCedulaNombreApellido($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>CEDULA</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>APELLIDO</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
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
                $resultado.= '<td>' . $row[cedula]. '</td>';
                $resultado.= '<td>' . $row[nombre]. '</td>';
                $resultado.= '<td>' . $row[apellido]. '</td>';
                $resultado.= '<td>' . $row[telefono] . '</td>';
                $resultado.= '<td>' . $row[estado] . '</td>';
                $resultado.= '<td>' . $row[ciudad] . '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar(\''. $row[cedula] .'\')"/></td>';
                $resultado.= '</tr>';
                $color = !$color;
            }
        }
        else { // si no hay coincidencias
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else { // retorno o borrar datos
        $controlBD = new controladorClienteParticularBDclass();
        $recurso = $controlBD->consultarTodoLosClientesPersonales();
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
            $resultado.= '<td>' . $row[telefono] . '</td>';
            $resultado.= '<td>' . $row[estado] . '</td>';
            $resultado.= '<td>' . $row[ciudad] . '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar(\''. $row[cedula] .'\')"/></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestion", "innerHTML", "$resultado");

    return $objResponse;
}

function cadenaTodasLasPersonas () {
    $resultado = "";
    $controlBD = new controladorClienteParticularBDclass();
    $recurso = $controlBD->consultarTodoLosClientesPersonales();
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>CEDULA</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>APELLIDO</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
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
        $resultado.= '<td>' . $row[cedula]. '</td>';
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[apellido]. '</td>';
        $resultado.= '<td>' . $row[telefono] . '</td>';
        $resultado.= '<td>' . $row[estado] . '</td>';
        $resultado.= '<td>' . $row[ciudad] . '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar(\''. $row[cedula] .'\')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodasLasPersonas();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    return $objResponse;
}

function generarFormularioNuevoClientePersona () {
    $formulario = '<form id="formNuevoCliente">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVO CLIENTE NATURAL
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r0">
      <td colspan="2">(*) Son campos obligatorios</td>
      </tr>
    <tr class="r1">
      <td>* Cedula</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>* Nombre de la Persona</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>* Apellido de la Persona</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>* Telefono</td>
      <td><input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Estado</td>
      <td><input type="text" name="estado" id="estado" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Ciudad</td>
      <td><input type="text" name="ciudad" id="ciudad" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Direccion</td>
      <td><input name="direccion" type="text" id="direccion" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarCliente(xajax.getFormValues(\'formNuevoCliente\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function mostrarFormularioAgregar () {
    $respuesta = generarFormularioNuevoClientePersona();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}

function validarPersona ($datos) {
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
    if (is_string($datos[telefono]) && $datos[telefono] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesarCliente($datos) {
    $repuesta = "";
    $objResponse = new xajaxResponse();
    if (validarPersona($datos)) {
        $control = new ControlClienteParticularLogicaclass();
        $resultado = $control->nuevoClienteParticular($datos[cedula], $datos[nombre], $datos[apellido], 'M', '0000-00-00', $datos[telefono], $datos[estado], $datos[ciudad], $datos[direccion]);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nuevo cliente personal '.$datos[nombre]. ' agregado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion.Verifique el manual del usuario. CODIGO GCPBD001.
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
                          No se pudo completar la operacion. El formulario no es correcro. CODIGO GCPF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $actualizar = cadenaTodasLasPersonas();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $objResponse->addAssign("gestion", "innerHTML", $actualizar);
    return $objResponse;
}

function generarFormularioEditar ($cedula) {
    $control = new controladorClienteParticularBDclass();
    $recurso = $control->consultarClienteParticular($cedula);
    $row = mysql_fetch_array($recurso);
    $formulario = '<form id="formCliente">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVO CLIENTE NATURAL
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r0">
      <td colspan="2">(*) Son campos obligatorios</td>
      </tr>
    <tr class="r1">
      <td>* Cedula</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" size="30" value="'.$row[cedula].'" READONLY onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>* Nombre de la Persona</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" value="'.$row[nombre].'"onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>* Apellido de la Persona</td>
      <td><label>
        <input type="text" name="apellido" id="apellido"  value="'.$row[apellido].'" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>* Telefono</td>
      <td><input type="text" name="telefono" id="telefono" value="'.$row[telefono].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Estado</td>
      <td><input type="text" name="estado" id="estado" value="'.$row[estado].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Ciudad</td>
      <td><input type="text" name="ciudad" id="ciudad" value="'.$row[ciudad].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Direccion</td>
      <td><input name="direccion" type="text" id="direccion" value="'.$row[ciudad].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarEditar(xajax.getFormValues(\'formCliente\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function editar ($cedula) {
    $respuesta = generarFormularioEditar($cedula);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}

function procesarEditar($datos) {
    $repuesta = "";
    $objResponse = new xajaxResponse();
    if (validarPersona($datos)) {
        $control = new ControlClienteParticularLogicaclass();
        $resultado = $control->actualizarClienteParticular($datos[cedula], $datos[nombre], $datos[apellido], $datos[telefono], $datos[estado], $datos[ciudad], $datos[direccion]);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Cliente persona '.$datos[nombre]. ' actualizada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion.Verifique el manual del usuario. CODIGO GCPBD001.
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
                          No se pudo completar la operacion. El formulario no es correcro. CODIGO GCPF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $actualizar = cadenaTodasLasPersonas();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $objResponse->addAssign("gestion", "innerHTML", $actualizar);
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
    $objResponse->addAssign("der", "innerHTML", $resultado);
    $objResponse->addAssign("Mensaje", "innerHTML", $resultado);
    return $objResponse;
}

?>
