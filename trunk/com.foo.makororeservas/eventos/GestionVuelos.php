<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/AsientosDisponiblesVueloTripulacion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorAvionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorRutaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTripulanteBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorGestionVuelos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloPersonalBD.class.php';


function limpiar ($cadena) {
    $nueva_cadena = ereg_replace('%20', " ", $cadena);
    return $nueva_cadena;
}

function autoSugerir($busqueda){
    $busqueda = limpiar ($busqueda);
    $activado = false;
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new controladorVueloBDclass();
    $recurso = $controlLogica->consultarTodosVuelosPorFechaRutas($busqueda);
    $numFilas = mysql_num_rows($recurso);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>IDENTIFICADOR</th>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>SITIO DE SALIDA</th>';
    $resultado.= '<th>SITIO DE LLEGADA</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>OPCIONES</th>';
    $resultado.= '<th>ANULAR</th>';
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
                $controlTripulacion = new controladorVueloPersonalBDclass();
                $recursoPiloto = $controlTripulacion->consultarVueloPersonalPiloto($row[id]);
                $recursoCopiloto = $controlTripulacion->consultarVueloPersonalCopiloto($row[id]);
                $rowPiloto = mysql_fetch_array($recursoPiloto);
                $rowCopiloto = mysql_fetch_array($recursoCopiloto);
                if ($rowPiloto == "" || $rowPiloto == NULL)
                $pilotoMostrar = 'POR ASIGNAR';
                else
                $pilotoMostrar = $rowPiloto[tripulante];
                if ($rowCopiloto == "" || $rowCopiloto == NULL)
                $copilotoMostrar = 'POR ASIGNAR';
                else
                $copilotoMostrar = $rowCopiloto[tripulante];
                if ($row[matricula] == "" || $row[matricula] == NULL)
                $matricula = 'POR ASIGNAR';
                else
                $matricula = $row[matricula];
                $resultado.= '<td>' . $row[id]. '</td>';
                $resultado.= '<td>' . $row[fecha]. '</td>';
                $resultado.= '<td>' . $row[hora]. '</td>';
                $resultado.= '<td>' . $row[rutaSalida]. '</td>';
                $resultado.= '<td>' . $row[rutaLlegada] . '</td>';
                $resultado.= '<td>' . $matricula. '</td>';
                $resultado.= '<td>' . $pilotoMostrar. '</td>';
                $resultado.= '<td>' . $copilotoMostrar. '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
                $resultado.= '<td><input type="button" value="ANULAR" onclick="xajax_anular('.$row[id].')"/></td>';
                $resultado.= '</tr>';
                $color = !$color;
            }
        }
        else { // si no hay coincidencias
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else { // retorno o borrar datos
        $recurso = $controlLogica->consultarTodosVuelosPorFechaRutas("");
        $color = false;
        while ($row = mysql_fetch_array($recurso)) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $resultado.= '<td>' . $row[id]. '</td>';
            $resultado.= '<td>' . $row[fecha]. '</td>';
            $resultado.= '<td>' . $row[hora]. '</td>';
            $resultado.= '<td>' . $row[rutaSalida]. '</td>';
            $resultado.= '<td>' . $row[rutaLlegada] . '</td>';
            $resultado.= '<td>' . $matricula. '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
            $resultado.= '<td><input type="button" value="ANULAR" onclick="xajax_anular('.$row[id].')"/></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestion", "innerHTML", "$resultado");

    return $objResponse;
}

function cadenaTodosLosVuelos () {
    $resultado = "";
    $control = new controladorVueloBDclass();
    $recurso = $control->consultarTodosVuelosPorFechaRutas("");
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>IDENTIFICADOR</th>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>SITIO DE SALIDA</th>';
    $resultado.= '<th>SITIO DE LLEGADA</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>OPCIONES</th>';
    $resultado.= '<th>ANULAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $controlTripulacion = new controladorVueloPersonalBDclass();
        $recursoPiloto = $controlTripulacion->consultarVueloPersonalPiloto($row[id]);
        $recursoCopiloto = $controlTripulacion->consultarVueloPersonalCopiloto($row[id]);
        $rowPiloto = mysql_fetch_array($recursoPiloto);
        $rowCopiloto = mysql_fetch_array($recursoCopiloto);
        if ($rowPiloto == "" || $rowPiloto == NULL)
        $pilotoMostrar = 'POR ASIGNAR';
        else
        $pilotoMostrar = $rowPiloto[tripulante];
        if ($rowCopiloto == "" || $rowCopiloto == NULL)
        $copilotoMostrar = 'POR ASIGNAR';
        else
        $copilotoMostrar = $rowCopiloto[tripulante];
        if ($row[matricula] == "" || $row[matricula] == NULL)
        $matricula = 'POR ASIGNAR';
        else
        $matricula = $row[matricula];
        $resultado.= '<td>' . $row[id]. '</td>';
        $resultado.= '<td>' . $row[fecha]. '</td>';
        $resultado.= '<td>' . $row[hora]. '</td>';
        $resultado.= '<td>' . $row[rutaSalida]. '</td>';
        $resultado.= '<td>' . $row[rutaLlegada] . '</td>';
        $resultado.= '<td>' . $matricula. '</td>';
        $resultado.= '<td>' . $pilotoMostrar. '</td>';
        $resultado.= '<td>' . $copilotoMostrar. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[id].')"/></td>';
        $resultado.= '<td><input type="button" value="ANULAR" onclick="xajax_anular('.$row[id].')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodosLosVuelos();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    return $objResponse;
}

function formularioNuevoVuelo () {
    $controlMatricula = new controladorAvionBDclass();
    $recursoMatricula = $controlMatricula->consultarAviones();
    $controlRuta = new controladorRutaBDclass();
    $recursoRuta = $controlRuta->consultarRutas();
    $controlPiloto = new controladorTripulanteBDclass();
    $recursoPiloto = $controlPiloto->consultarPilotos();
    $recursoCopiloto = $controlPiloto->consultarCopilotos();
    $formulario = '<form id="formNuevoVuelo">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">REGISTRAR NUEVO VUELO
          <div class="botonCerrar">
            <button name="boton" type="button" onClick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">(*) Son campos requeridos</td>
      </tr>
    <tr class="r0">
      <td>*Fecha</td>
      <td><label>
        <input type="text" name="fecha" id="f_date_c" readonly="1" size="15" /><img src="jscalendar/img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector"
</td>
      </label></td>
    </tr>
    <tr class="r1">
      <td>*Hora</td>
      <td><label>
      <input type="text" name="hora" id="hora" size="8" />
      (hh:mm:ss)</label></td>
    </tr>
    <tr class="r0">
      <td>Matricula del avion</td>
      <td><label>
        <select name="matricula" id="matricula">
          <option value="NULL">POR ASIGNAR</option>';
    while ($rowMatricula = mysql_fetch_array($recursoMatricula)){
        $formulario .= '<option value = "'.$rowMatricula[matricula].'">'.$rowMatricula[matricula].'</option>';
    }
    $formulario .= '</select>
      </label></td>
    </tr>
    <tr class="r1">
      <td>* Ruta</td>
      <td><select name="ruta" id="ruta">';
    while ($rowRuta = mysql_fetch_array($recursoRuta)) {
        $formulario .= '<option value="'.$rowRuta[sitioSalida].'-'.$rowRuta[sitioLlegada].'"> '.$rowRuta[abreviaturaSalida].' - '.$rowRuta[abreviaturaLlegada].'</option>';
    }
    $formulario.='</select></td>
    </tr>
    <tr class="r0">
      <td>Piloto</td>
      <td><select name="piloto" id="piloto">
        <option value="NULL">POR ASIGNAR</option>';
    while ($rowPiloto = mysql_fetch_array($recursoPiloto)){
        $formulario .= '<option value = '.$rowPiloto[cedula].'>'.$rowPiloto[apellido].', '.$rowPiloto[nombre].'</option>';
    }
    $formulario .='</select></td>
    </tr>
    <tr class="r0">
      <td>Copiloto</td>
      <td><select name="copiloto" id="copiloto">
        <option value="NULL">POR ASIGNAR</option>';
    while ($rowCopiloto = mysql_fetch_array($recursoCopiloto)){
        $formulario .= '<option value = '.$rowCopiloto[cedula].'>'.$rowCopiloto[apellido].', '.$rowCopiloto[nombre].'</option>';
    }
    $formulario.= '</select></td>
    </tr>
    <tr class="r1">    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="REGISTRAR" onclick= "xajax_procesarVuelo(xajax.getFormValues(\'formNuevoVuelo\'))" />
      </div></td>
    </tr>
  </table>
   <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioNuevoVuelo () {
    $resultado = formularioNuevoVuelo();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
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

function formularioEditarVuelo ($id) {
    $controlMatricula = new controladorAvionBDclass();
    $recursoMatricula = $controlMatricula->consultarAviones();
    $controlRuta = new controladorRutaBDclass();
    $recursoRuta = $controlRuta->consultarRutas();
    $controlPiloto = new controladorTripulanteBDclass();
    $recursoPiloto = $controlPiloto->consultarPilotos();
    $recursoCopiloto = $controlPiloto->consultarCopilotos();
    $controlVuelo = new controladorGestionVuelos();
    $recursoVuelo = $controlVuelo->ConsultarVueloPorId($id);
    $rowVuelo = mysql_fetch_array($recursoVuelo);
    $controlVueloPersonal = new controladorVueloPersonalBDclass();
    $recursoPilotoVueloActual = $controlVueloPersonal->consultarVueloPersonalPiloto($id);
    $rowPilotoActual = mysql_fetch_array($recursoPilotoVueloActual);
    $recursoCopilotoActual = $controlVueloPersonal->consultarVueloPersonalCopiloto($id);
    $rowCopilotoActual = mysql_fetch_array($recursoCopilotoActual);
    $formulario = '<form id="formNuevoVuelo">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">EDITAR VUELO<input type="hidden" name="id" id="id" value ="'.$rowVuelo[id].'">
          <div class="botonCerrar">
            <button name="boton" type="button" onClick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">(*) Son campos requeridos</td>
      </tr>
    <tr class="r0">
      <td>*Fecha</td>
      <td><label>
        <input type="text" value ="'.$rowVuelo[fecha].'" name="fecha" id="f_date_c" readonly="1" size="15" />
</td>
      </label></td>
    </tr>
    <tr class="r1">
      <td>*Hora</td>
      <td><label>
      <input type="text" name="hora" id="f_date_c4" value ="'.$rowVuelo[hora].'"readonly="1" size="8" />
      (hh:mm:ss)</label></td>
    </tr>
    <tr class="r0">
      <td>Matricula del avion</td>
      <td><label>
        <select name="matricula" id="matricula">
          <option value="NULL">POR ASIGNAR</option>';
    while ($rowMatricula = mysql_fetch_array($recursoMatricula)){
        $formulario .= '<option value = "'.$rowMatricula[matricula];
        if ($rowVuelo['matricula'] == $rowMatricula['matricula'])
        $formulario .= '"selected';
        $formulario .= '">'.$rowMatricula[matricula].'</option>';
    }
    $formulario .= '</select>
      </label></td>
    <tr class="r1">
      <td>Ruta</td>
      <td><label>
        <input type="text" value ="'.$rowVuelo[salida].' - '.$rowVuelo[llegada].'"" name="" id="" readonly="1" size="25" />
</td>
      </label></td>
    </tr>
    </tr>
    <tr class="r0">
      <td>Piloto</td>
      <td><select name="piloto" id="piloto">
        <option value="NULL">POR ASIGNAR</option>';
    while ($rowPiloto = mysql_fetch_array($recursoPiloto)){
        $formulario .= '<option value = "'.$rowPiloto[cedula].'"';
        if ($rowPilotoActual['cedula'] == $rowPiloto['cedula'])
        $formulario .= 'selected';
        $formulario .= '>'.$rowPiloto[apellido].', '.$rowPiloto[nombre].'</option>';
    }
    $formulario .='</select></td>
    </tr>
    <tr class="r0">
      <td>Copiloto</td>
      <td><select name="copiloto" id="copiloto">
        <option value="NULL">POR ASIGNAR</option>';
    while ($rowCopiloto = mysql_fetch_array($recursoCopiloto)){
        $formulario .= '<option value = "'.$rowCopiloto[cedula].'"';
        if ($rowCopilotoActual['cedula'] == $rowCopiloto['cedula'])
        $formulario .= 'selected';
        $formulario .= '>'.$rowCopiloto[apellido].', '.$rowCopiloto[nombre].'</option>';
    }
    $formulario.= '</select></td>
    </tr>
    <tr class="r1">    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="EDITAR" onclick= "xajax_procesarEditarVuelo(xajax.getFormValues(\'formNuevoVuelo\'))" />
      </div></td>
    </tr>
  </table>
   <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function editar ($idVuelo) {
    $resultado = formularioEditarVuelo($idVuelo);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function validarHorario ($hora) {
    $resultado = false;
    if ($hora != "") {
        $arregloHora = split(':', $hora);
        if (count($arregloHora) == 3){
            if (is_numeric($arregloHora[0]) && is_numeric($arregloHora[1]) && is_numeric($arregloHora[2]) ) {
                if ($arregloHora[0] <= 23 && $arregloHora[1] <= 59 && $arregloHora[2] <= 59 &&
                    $arregloHora[0] >=0 && $arregloHora[1] >=0 && $arregloHora[2] >=0) {
                    $resultado = true;
                }
            }
        }
    }
    return $resultado;
}

function validarVuelo ($datos) {
    $resultado = false;
    if ($datos[fecha] != "")
    $resultado = true;
    else return false;
    if (validarHorario($datos[hora]))
    $resultado = true;
    else return false;
    if ($datos[piloto] == 'NULL') {
        if ($datos[copiloto] == 'NULL')
        $resultado = true;
        else return false;
    }
    if ($datos[copiloto] == 'NULL') {
        if ($datos[piloto] == 'NULL')
        $resultado = true;
        else return false;
    }

    return $resultado;
}

function procesarVuelo ($datos) {
    $objResponse = new xajaxResponse();
    if (validarVuelo($datos)) {
        $respuesta = "";
        $control = new controladorGestionVuelos();
        $arregloRuta = split('-', $datos[ruta]);
        $sitioSalida =$arregloRuta[0];
        $sitioLlegada =$arregloRuta[1];
        $resultado = $control->nuevoVuelo($datos[fecha], $datos[hora], $datos[matricula], $sitioSalida, $sitioLlegada, $datos[piloto], $datos[copiloto]);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nuevo VUELO agregado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Consulte el Manual de Ayuda. CODIGO ERROR: GV001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodosLosVuelos();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        $objResponse->addAssign("izq", "innerHTML", "");
    }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Los datos del formulario no son correctos. CODIGO ERROR GVF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function procesarEditarVuelo ($datos) {
    $objResponse = new xajaxResponse();
    if (validarVuelo($datos)) {
        $respuesta = "";
        $control = new controladorGestionVuelos();
        $arregloRuta = split('-', $datos[ruta]);
        $sitioSalida =$arregloRuta[0];
        $sitioLlegada =$arregloRuta[1];
        $resultado = $control->editarVuelo($datos[id], $datos[matricula], $datos[piloto], $datos[copiloto],$datos[fecha],$datos[hora]);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Vuelo actualizado exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Consulte el Manual de Ayuda. CODIGO ERROR: GV001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodosLosVuelos();
        $objResponse->addAssign("gestion", "innerHTML", $actualizarTablaPrincipalRespuesta);
        $objResponse->addAssign("izq", "innerHTML", "");
    }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Los datos del formulario no son correctos. CODIGO ERROR GVF001.
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

function anular ($idVuelo) {
    $objResponse = new xajaxResponse();
    $objResponse->addConfirmCommands(5, "Esta seguro que quiere eliminar el vuelo $idVuelo junto con todas sus reservas e informacion?. Esta operacion es irreversible");
    $mensaje = "";
    $accion = 0;
    echo "aca1" . $accion;
    $control = new controladorGestionVuelos();
    $accion = 1;
    if ($accion == 1) {
       echo "entro que bolas";
    $resultado = $control->deshacerDelSistemaUnVuelo($idVuelo);
    $mensaje = "El vuelo $idVuelo ha sido eliminado del sistema con exito junto con toda su información";
    $objResponse->addAssign("Mensaje", "innerHTML", $mensaje);
    return $objResponse;}
}

?>
