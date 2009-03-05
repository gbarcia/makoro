<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoCargoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoCargo.class.php';

function cadenaTodasLosCargos () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>IDENTIFICADOR</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>DESCRIPCION</th>';
    $resultado.= '<th>SUELDO</th>';;
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $controlLogica = new controladorTipoCargoBDclass();
    $recurso = $controlLogica->obtenerTodosLosTiposCargo();
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[id] . '</td>';
        $resultado.= '<td>' . $row[cargo]. '</td>';
        $resultado.= '<td>' . $row[descripcion]. '</td>';
        $resultado.= '<td>' . $row[sueldo]. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_desplegarFormularioEditar('.$row[id].')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodasLosCargos();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    return $objResponse;
}

function crearFormularioNuevoCargo () {
    $contenido = '<form id="formNuevoCargo">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVO CARGO
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" size="30" onKeyUp="this.value=this.value.toUpperCase();">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Descripcion</td>
      <td><label>
        <input type="text" name="descripcion" id="descripcion" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Sueldo</td>
      <td><label>
        <input type="text" name="sueldo" id="sueldo" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarCargo(xajax.getFormValues(\'formNuevoCargo\'))">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $contenido;
}

function desplegarFormularioNuevoCargo () {
    $resultado = crearFormularioNuevoCargo();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function validarCargo ($datos) {
    $resultado = false;
    if (is_string($datos[nombre]) && $datos[nombre] != "")
    $resultado = true;
    else return false;
    if (is_numeric($datos[sueldo]) && $datos[sueldo] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesarCargo ($datos) {
    $objResponse = new xajaxResponse();
    if (validarCargo($datos)) {
        $respuesta = "";
        $control = new controladorTipoCargoBDclass();
        $tipoCargo = new TipoCargoclass();
        $tipoCargo->setCargo($datos[nombre]);
        $tipoCargo->setDescripcion($datos[descripcion]);
        $tipoCargo->setSueldo($datos[sueldo]);
        $resultado = $control->agregarTipoCargo($tipoCargo);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nueva CARGO agregado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que el cargo no exista.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLosCargos();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        if ($resultado)
        $objResponse->addAssign("izq", "innerHTML", "");
        }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. El campo de sueldo debe ser numerico.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function crearFormularioEditarCargo ($id) {
    $control = new controladorTipoCargoBDclass();
    $recurso = $control->obtenerCargoID($id);
    $row = mysql_fetch_array($recurso);
    $contenido = '<form id="formNuevoCargo">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            EDITAR CARGO <input type="hidden" name="id" id="id" value= "'.$row[id].'" />
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" value="'.$row[cargo].'" READONLY id="nombre" size="30" onKeyUp="this.value=this.value.toUpperCase();">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Descripcion</td>
      <td><label>
        <input type="text" name="descripcion" value="'.$row[descripcion].'" READONLY id="descripcion" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Sueldo</td>
      <td><label>
        <input type="text" name="sueldo" id="sueldo" value="'.$row[sueldo].'" onKeyUp="this.value=this.value.toUpperCase();" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarCargoEditar(xajax.getFormValues(\'formNuevoCargo\'))">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $contenido;
}

function desplegarFormularioEditar ($id) {
    $resultado = crearFormularioEditarCargo($id);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function procesarCargoEditar ($datos) {
    $objResponse = new xajaxResponse();
    if (validarCargo($datos)) {
        $respuesta = "";
        $control = new controladorTipoCargoBDclass();
        $resultado = $control->actualizarSueldoTipoCargo($datos[id], $datos[sueldo]);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Cargo actualizado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Contacte con el equipo de soporte.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLosCargos();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        if ($resultado)
        $objResponse->addAssign("izq", "innerHTML", "");
        }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. El campo de sueldo debe ser numerico.
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
