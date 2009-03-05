<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Avion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorAvionBD.class.php';

function cadenaTodosLosAviones () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>MATRICULA</th>';
    $resultado.= '<th>ASIENTOS</th>';
    $resultado.= '<th>VUELOS REALIZADOS</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $controlLogica = new controladorAvionBDclass();
    $recurso = $controlLogica->consultarAviones();
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[matricula]. '</td>';
        $resultado.= '<td>' . $row[asientos]. '</td>';
        $resultado.= '<td>' . $row[numero]. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_desplegarFormularioEditar(\''. $row[matricula] .'\')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodosLosAviones();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    return $objResponse;
}

function generarFormularioNuevoAvion () {
    $formulario ='<form id="formNuevoAvion">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVO AVION
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
      <td>Matricula</td>
      <td><label>
        <input type="text" name="matricula" id="matricula" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Numero de asientos</td>
      <td><label>
        <input type="text" name="asientos" id="asientos" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesar(xajax.getFormValues(\'formNuevoAvion\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioNuevoAvion () {
    $resultado = generarFormularioNuevoAvion();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function validarFormularioAvion ($datos) {
    $resultado = false;
    if (is_string($datos[matricula]) && $datos[matricula] != "")
    $resultado = true;
    else return false;
    if (is_numeric($datos[asientos]) && $datos[asientos] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesar ($datos) {
    $objResponse = new xajaxResponse();
    if (validarFormularioAvion($datos)) {
        $respuesta = "";
        $control = new controladorAvionBDclass();
        $avion = new Avionclass();
        $avion->setAsientos($datos[asientos]);
        $avion->setMatricula($datos[matricula]);
        $avion->setHabilitado(1);
        $resultado = $control->agregarAvion($avion);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nuevo AVION agregado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que la matricula no exista.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodosLosAviones();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        if ($resultado)
        $objResponse->addAssign("izq", "innerHTML", "");
        }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. El campo de asientos debe ser numerico
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function generarFormularioEditar ($matricula) {
    $control = new controladorAvionBDclass();
    $recurso = $control->consultarAvionesPorMatricula($matricula);
    $row = mysql_fetch_array($recurso);
    $formulario ='<form id="formNuevoAvion">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            EDITAR AVION
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
      <td>Matricula</td>
      <td><label>
        <input type="text" name="matricula" id="matricula" size="30" value= "'.$row[matricula].'" READONLY onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Numero de asientos</td>
      <td><label>
        <input type="text" name="asientos" value= "'.$row[asientos].'" id="asientos" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarEditar(xajax.getFormValues(\'formNuevoAvion\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioEditar ($matricula) {
    $resultado = generarFormularioEditar($matricula);
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
    if (validarFormularioAvion($datos)) {
        $respuesta = "";
        $control = new controladorAvionBDclass();
        $resultado = $control->actualizarAsientos($datos[matricula], $datos[asientos]);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Avion actualizado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que la matricula no exista.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodosLosAviones();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        if ($resultado)
        $objResponse->addAssign("izq", "innerHTML", "");
        }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. El campo de asientos debe ser numerico
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
