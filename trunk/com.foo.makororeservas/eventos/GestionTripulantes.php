<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTripulanteBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoCargoBD.class.php';
/**
 * Metodo xajax para autosugerir un tipulante
 * @param <type> $busqueda la busqueda a realizar y comparar con el sistema
 * @return <type> objeto de respuesta xjax
 */
function autoSugerir($busqueda){
    $activado = false;
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlTripulanteLogicaclass();
    $recurso = $controlLogica->consultarTripulanteCedulaNombreApellido($busqueda);
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
    $resultado.= '<th>TARIFA/HORA</th>';
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
                $tripulanteMay = new Tripulanteclass();
                $tripulanteMay->setHabilitadoString($row[habilitado]);
                $resultado.= '<td>' . $row[cedula]. '</td>';
                $resultado.= '<td>' . $row[nombre]. '</td>';
                $resultado.= '<td>' . $row[apellido]. '</td>';
                $resultado.= '<td>' . $row[sexo]. '</td>';
                $resultado.= '<td>' . $row[telefono] . '</td>';
                $resultado.= '<td>' . $row[estado]. '</td>';
                $resultado.= '<td>' . $row[ciudad]. '</td>';
                $resultado.= '<td>' . $row[cargo]. '</td>';
                $resultado.= '<td>' . $row[sueldo]. " BS".'</td>';
                $resultado.= '<td>' . $tripulanteMay->getHabilitado(). '</td>';
                $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row[cedula].')"/></td>';
                $resultado.= '<td><input type="checkbox" name="tripulantes[]" value="'.$row[cedula].'"></td>';
                $resultado.= '</tr>';
                $color = !$color;
            }
        }
        else { // si no hay coincidencias
            $resultado = 'No hay coincidencias con su busqueda ';
        }
    }
    else { // retorno o borrar datos
        $recurso = $controlLogica->consultarTodoPersonal(TRUE);
        foreach ($recurso as $row) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $resultado.= '<td>' . $row->getCedula(). '</td>';
            $resultado.= '<td>' . $row->getNombre(). '</td>';
            $resultado.= '<td>' . $row->getApellido(). '</td>';
            $resultado.= '<td>' . $row->getSexo(). '</td>';
            $resultado.= '<td>' . $row->getTelefono() . '</td>';
            $resultado.= '<td>' . $row->getEstado(). '</td>';
            $resultado.= '<td>' . $row->getCiudad(). '</td>';
            $resultado.= '<td>' . $row->getDireccion(). '</td>';
            $resultado.= '<td>' . $row->getCargo(). '</td>';
            $resultado.= '<td>' . $row->getSueldo(). '</td>';
            $resultado.= '<td>' . $row->getHabilitadoString(). '</td>';
            $resultado.='<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row->getCedula().')"/></td>';
            $resultado.= '<td><input type="checkbox" name="tripulantes[]" value="'.$row->getCedula().'"></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestionTripulante", "innerHTML", "$resultado");

    return $objResponse;
}

/**
 * Metodo para el inicio de la pagina cargar todo el personal
 * @param <variable de paginacion> $reg1
 * @param <Integer> $tamPag resultados mostrados por pagina
 */
function autosugerirInicio ($reg1,$tamPag) {
    $controlLogica = new ControlTripulanteLogicaclass();
    echo '<form id="formularioEditarMarcar">';
    echo '<table class="tabla">';
    echo '<tr class="titulo">';
    echo '<th>CEDULA</th>';
    echo '<th>NOMBRE</th>';
    echo '<th>APELLIDO</th>';
    echo '<th>SEXO</th>';
    echo '<th>TELEFONO</th>';
    echo '<th>ESTADO</th>';
    echo '<th>CIUDAD</th>';
    echo '<th>CARGO</th>';
    echo '<th>TARIFA/HORA</th>';
    echo '<th>HABIITADO</th>';
    echo '<th>EDITAR</th>';
    echo '<th>MARCAR</th>';
    echo '</tr>';
    $resultado = $controlLogica->consultarTodoPersonal(TRUE);
    $tamanoArreglo = sizeof($resultado);
    $color = false;
    for ($i=$reg1; $i<min($reg1+$tamPag, $tamanoArreglo); $i++) {
        if ($color){
            echo '<tr class="r0">';
        } else {
            echo '<tr class="r1">';
        }
        echo '<td>' . $resultado[$i]->getCedula(). '</td>';
        echo '<td>' . $resultado[$i]->getNombre(). '</td>';
        echo '<td>' . $resultado[$i]->getApellido(). '</td>';
        echo '<td>' . $resultado[$i]->getSexo(). '</td>';
        echo '<td>' . $resultado[$i]->getTelefono() . '</td>';
        echo '<td>' . $resultado[$i]->getEstado(). '</td>';
        echo '<td>' . $resultado[$i]->getCiudad(). '</td>';
        echo '<td>' . $resultado[$i]->getCargo(). '</td>';
        echo '<td>' . $resultado[$i]->getSueldo(). ' BS'. '</td>';
        echo '<td>' . $resultado[$i]->getHabilitado(). '</td>';
        echo '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$resultado[$i]->getCedula().')"/></td>';
        echo '<td><input type="checkbox" name="tripulantes[]" value="'. $resultado[$i]->getCedula().'"></td>';
        echo '</tr>';
        $color = !$color;
    }
    echo '</form>';
    echo '</table>';
}

/**
 * Metodo para consultar el numero total de los empleados de vuelo registrados en el sistema
 * @return <Integer> el numero total de empleados
 */
function consultarNumeroTotalPersonal () {
    $controlLogica = new ControlTripulanteLogicaclass();
    $resultado = $controlLogica->consultarTodoPersonal(TRUE);
    $tamanoArreglo = sizeof($resultado);
    return $tamanoArreglo;
}

/**
 * Funcion pa mostrar los links de la paginacion
 * @param <type> $actual pagina actua
 * @param <type> $total total de datos a mostrar
 * @param <type> $por_pagina registros a mostrar por pagina
 * @param <type> $enlace el enlace a donde sera llevada la pagina
 * @return <String> texto con la paginacion
 */
function paginar($actual, $total, $por_pagina, $enlace) {
    $total_paginas = ceil($total/$por_pagina);
    $anterior = $actual - 1;
    $posterior = $actual + 1;
    if ($actual>1)
    $texto = "<a href=\"$enlace$anterior\">&laquo;</a> ";
    else
    $texto = "<b>&laquo;</b> ";
    for ($i=1; $i<$actual; $i++)
    $texto .= "<a href=\"$enlace$i\">$i</a> ";
    $texto .= "<b>$actual</b> ";
    for ($i=$actual+1; $i<=$total_paginas; $i++)
    $texto .= "<a href=\"$enlace$i\">$i</a> ";
    if ($actual<$total_paginas)
    $texto .= "<a href=\"$enlace$posterior\">&raquo;</a>";
    else
    $texto .= "<b>&raquo;</b>";
    return $texto;
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
        $resultado.= '<tr class = "titulo">';
        $resultado.= '<th>CEDULA</th>';
        $resultado.= '<th>NOMBRE</th>';
        $resultado.= '<th>APELLIDO</th>';
        $resultado.= '<th>SEXO</th>';
        $resultado.= '<th>TELEFONO</th>';
        $resultado.= '<th>ESTADO</th>';
        $resultado.= '<th>CIUDAD</th>';
        $resultado.= '<th>CARGO</th>';
        $resultado.= '<th>TARIFA/HORA</th>';
        $resultado.= '<th>HABILITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '</tr>';
        $controlLogica = new ControlTripulanteLogicaclass();
        $recurso = $controlLogica->consultarTodoPersonal(FALSE);
        $color = false;
        foreach ($recurso as $row) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $resultado.= '<td>' . $row->getCedula(). '</td>';
            $resultado.= '<td>' . $row->getNombre(). '</td>';
            $resultado.= '<td>' . $row->getApellido(). '</td>';
            $resultado.= '<td>' . $row->getSexo(). '</td>';
            $resultado.= '<td>' . $row->getTelefono() . '</td>';
            $resultado.= '<td>' . $row->getEstado(). '</td>';
            $resultado.= '<td>' . $row->getCiudad(). '</td>';
            $resultado.= '<td>' . $row->getCargo(). '</td>';
            $resultado.= '<td>' . $row->getSueldo(). ' BS'. '</td>';
            $resultado.= '<td>' . $row->getHabilitadoString(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row->getCedula().')"/></td>';
            $resultado.= '<td><input type="checkbox" name="tripulantes[]" value="'. $row->getCedula().'"></td>';

            $resultado.= '</tr>';
            $color = !$color;
        }
        $resultado.= '</table>';
        $boton = crearBotonHabilitarTripulante();
        $objResponse->addAssign("gestionTripulante", "innerHTML", $resultado);
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);

    }
    else  { // los habilitados
        $resultado = "";
        $objResponse = new xajaxResponse();
        $resultado = '<form id="formularioEditarMarcar">';
        $resultado.= '<table class="tabla">';
        $resultado.= '<tr class = "titulo">';
        $resultado.= '<th>CEDULA</th>';
        $resultado.= '<th>NOMBRE</th>';
        $resultado.= '<th>APELLIDO</th>';
        $resultado.= '<th>SEXO</th>';
        $resultado.= '<th>TELEFONO</th>';
        $resultado.= '<th>ESTADO</th>';
        $resultado.= '<th>CIUDAD</th>';
        $resultado.= '<th>CARGO</th>';
        $resultado.= '<th>TARIFA/HORA</th>';
        $resultado.= '<th>HABILITADO</th>';
        $resultado.= '<th>EDITAR</th>';
        $resultado.= '<th>MARCAR</th>';
        $resultado.= '</tr>';
        $controlLogica = new ControlTripulanteLogicaclass();
        $recurso = $controlLogica->consultarTodoPersonal(TRUE);
        $color = false;
        foreach ($recurso as $row) {
            if ($color){
                $resultado.= '<tr class="r0">';
            } else {
                $resultado.= '<tr class="r1">';
            }
            $resultado.= '<td>' . $row->getCedula(). '</td>';
            $resultado.= '<td>' . $row->getNombre(). '</td>';
            $resultado.= '<td>' . $row->getApellido(). '</td>';
            $resultado.= '<td>' . $row->getSexo(). '</td>';
            $resultado.= '<td>' . $row->getTelefono() . '</td>';
            $resultado.= '<td>' . $row->getEstado(). '</td>';
            $resultado.= '<td>' . $row->getCiudad(). '</td>';
            $resultado.= '<td>' . $row->getCargo(). '</td>';
            $resultado.= '<td>' . $row->getSueldo(). ' BS'. '</td>';
            $resultado.= '<td>' . $row->getHabilitado(). '</td>';
            $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row->getCedula().')"/></td>';
            $resultado.= '<td><input type="checkbox" name="tripulantes[]" value="'. $row->getCedula().'"></td>';
            $resultado.= '</tr>';
            $color = !$color;
        }
        $resultado.= '</table>';
        $resultado.= '</form>';
        $boton = crearBotonInhabilitarTripulante();
        $objResponse->addAssign("BotonEliminar", "innerHTML", $boton);
        $objResponse->addAssign("gestionTripulante", "innerHTML", $resultado);
    }
    return $objResponse;
}
/**
 * Metodo para cerrar la ventana de los formularios
 * @return <ajaxResponse> objeto de respuesta para modificar el div
 */
function cerrarVentanaEditar() {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    $objResponse->addAssign("Mensaje", "innerHTML", $resultado);
    return $objResponse;
}
/**
 * Metodo para construir el formulario de editar con los datos ya cargados del
 * tripulante seleccionado
 * @param <Integer> $cedula cedula del tripulante
 * @return <xjaxResponse>  respuesta del servidor
 */
function editar($cedula) {
    $base = new controladorTripulanteBDclass();
    $controlTipoCargo = new controladorTipoCargoBDclass();
    $recurso = $base->consultarPersonalCedula($cedula);
    $row = mysql_fetch_array($recurso);
    $recursoTipoCargo = $controlTipoCargo->obtenerTodosLosTiposCargo();
    $resultado = '<form id="formUpdate">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td>EDITAR TRIPULANTE</td>
      <td><div align="right">
        <label>
        <input type="button" name="botonCerrar" id="botonCerrar" value="X" onclick="xajax_cerrarVentanaEditar()">
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td>Cedula</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" READONLY size="30" value='.$row[cedula].'>
      </label></td>
    </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" onKeyUp="this.value=this.value.toUpperCase();" size="30" value='.$row[nombre].'>
      </label></td>
    </tr>
    <tr class="r1">
      <td>Apellido</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" onKeyUp="this.value=this.value.toUpperCase();" size="30" value="'.$row[apellido].'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Sexo</td>
      <td><p>
        <label>
          <input type="radio" name="sexo" value="M" id="sexo_0"';
    if($row[sexo] == 'M'){
        $resultado.= 'checked="checked"';
    }
    $resultado.= '>
          Masculino</label>
        <br>
        <label>
          <input type="radio" name="sexo" value="F" id="sexo_1"';
    if($row[sexo] == 'F'){
        $resultado.= 'checked="checked"';
    }
    $resultado.= '>
          Femenino</label>
      </td>
    </tr>
    <tr class="r1">
      <td>Telefono</td>
      <td><label>
        <input type="text" name="telefono" id="telefono" onKeyUp="this.value=this.value.toUpperCase();" size="30" value="'.$row[telefono].'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Estado de residencia</td>
      <td><label>
        <input type="text" name="estado" id="estado" size="30" value="'.$row[estado].'">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Ciudad de residencia</td>
      <td><label>
        <input type="text" name="ciudad" id="ciudad" size="30" value="'.$row[ciudad].'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Direccion de residencia</td>
      <td><label>
        <textarea name="direccion" id="direccion" cols="23" rows="3">'.$row[direccion].'</textarea>
      </label></td>
    </tr>
    <tr class="r1">
      <td>Cargo</td>
      <td><label>
        <select name="cargo" id="cargo">';
    while ($rowTP = mysql_fetch_array($recursoTipoCargo)) {
        $resultado .= '<option value="'.$rowTP[id].'"';
        if ($row[cargo] == $rowTP[cargo])
        $resultado .= 'selected="selected"';
        $resultado .= '>'.$rowTP[cargo].'</option>';
    }
    $resultado .='</select>
      </label></td>
    </tr>
    <tr class="r0">
      <td>Habilitado</td>
      <td><label>
        <input type="checkbox" name="habilitado" id="habilitado" size="30" value="'.$row[habilitado].'"';
    if ($row[habilitado] == 1) $resultado.= 'checked="checked"';
    $resultado .='>
      </label></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><label>
          <div align="center">
            <input type="button" name="button" id="button" value="EDITAR" onclick = "xajax_procesarUpdate(xajax.getFormValues(\'formUpdate\'))">
              </div>
      </label></td>
    </tr>
  </table>
</form>';
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}
/**
 * Metodo para actualizar la tabla principal
 * @return <String> respuesta en html para actualizar la tabla principal
 */
function actualizarTablaPrinicipal () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<table class="tabla">';
    $resultado.= '<tr class = "titulo">';
    $resultado.= '<th>CEDULA</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>APELLIDO</th>';
    $resultado.= '<th>SEXO</th>';
    $resultado.= '<th>TELEFONO</th>';
    $resultado.= '<th>ESTADO</th>';
    $resultado.= '<th>CIUDAD</th>';
    $resultado.= '<th>CARGO</th>';
    $resultado.= '<th>TARIFA/HORA</th>';
    $resultado.= '<th>HABILITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '</tr>';
    $controlLogica = new ControlTripulanteLogicaclass();
    $recurso = $controlLogica->consultarTodoPersonal(TRUE);
    $color = false;
    foreach ($recurso as $row) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row->getCedula(). '</td>';
        $resultado.= '<td>' . $row->getNombre(). '</td>';
        $resultado.= '<td>' . $row->getApellido(). '</td>';
        $resultado.= '<td>' . $row->getSexo(). '</td>';
        $resultado.= '<td>' . $row->getTelefono() . '</td>';
        $resultado.= '<td>' . $row->getEstado(). '</td>';
        $resultado.= '<td>' . $row->getCiudad(). '</td>';
        $resultado.= '<td>' . $row->getCargo(). '</td>';
        $resultado.= '<td>' . $row->getSueldo(). ' BS'. '</td>';
        $resultado.= '<td>' . $row->getHabilitado(). '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar('.$row->getCedula().')"/></td>';
        $resultado.= '<td><input type="checkbox" name="tripulantes[]" value="'. $row->getCedula().'"></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

/**
 * Metodo para procesar la edicion de un tripulante
 * @param <type> $datos datos del formulario con la informacion a editar
 * @return <xajaxResponse> respuesta del servidor
 */
function procesarUpdate ($datos) {
    $respuesta = "";
    $controlTripulante = new ControlTripulanteLogicaclass();
    $objResponse = new xajaxResponse();
    $objResponse->addConfirmCommands(6, "Esta seguro de editar ".$datos[cedula]." ?");
    $resultado = $controlTripulante->actualizarTripulante(  $datos['cedula'],
        $datos['nombre'],
        $datos['apellido'],
        $datos['sexo'],
        $datos['telefono'],
        $datos['estado'],
        $datos['ciudad'],
        $datos['direccion'],
        $datos['habilitado'],
        $datos['cargo']);
    if ($resultado) {
        $respuesta = "Tripulante ".$datos[cedula]." actualizado con exito";
    }
    else {
        $respuesta = "No se pudo realizar la operacion. Vuelva a intentarlo. ERROR 001";
    }
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $actualizarTablaPrincipalRespuesta = actualizarTablaPrinicipal();
    $objResponse->addAssign("gestionTripulante", "innerHTML", $actualizarTablaPrincipalRespuesta);
    return $objResponse;
}
/**
 * Metodo para inhabilitar uno o varios tripulante
 * @param <type> $listaTripulantes lista de cedulas de los tripulantes a inhabilitar
 * @return <xajaxResponse> la respuesta del servidor
 */
function eliminarTripulante($listaTripulantes) {
    $respuesta ="";
    $controlTripulante = new controladorTripulanteBDclass();
    $objResponse = new xajaxResponse();
    $objResponse->addConfirmCommands(6, "Esta seguro de inhabilitar la seleccion?");
    foreach ($listaTripulantes[tripulantes] as $trip) {
        $controlTripulante->inhabilitarHabilitarTripulante($trip, 0);
    }
    $respuesta ="Tripulante(s) inhabilitado(s) con exito";
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $actualizarTablaPrincipalRespuesta = actualizarTablaPrinicipal();
    $objResponse->addAssign("gestionTripulante", "innerHTML", $actualizarTablaPrincipalRespuesta);
    return $objResponse;
}
/**
 * Metodo para habilitar un tripulante ya borrado o inhabilitado
 * @param <Array> $listaTripulantes
 * @return <ajaxResponse> respuesta del servidor
 */
function habilitarTripulante($listaTripulantes) {
    $respuesta ="";
    $controlTripulante = new controladorTripulanteBDclass();
    $objResponse = new xajaxResponse();
    $objResponse->addConfirmCommands(6, "Esta seguro de habilitar la seleccion?");
    foreach ($listaTripulantes[tripulantes] as $trip) {
        $controlTripulante->inhabilitarHabilitarTripulante($trip, 1);
    }
    $respuesta ="Tripulante(s) habilitado(s) con exito";
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    $actualizarTablaPrincipalRespuesta = actualizarTablaPrinicipal();
    $objResponse->addAssign("gestionTripulante", "innerHTML", $actualizarTablaPrincipalRespuesta);
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
 * Meotodo para construir el formulario para agregar un tripulante
 * @return <String> html para generar el formulario
 */
function generarCrearNuevoTripulante () {
    $contenido = "";
    $contenido ='<form id="formNuevoTripulante">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td>NUEVO TRIPULANTE</td>
      <td><div align="right">
        <label>
        <input type="button" name="cerrar" id="cerrar" value="X" onclick="xajax_cerrarVentanaEditar()" />
        </label>
      </div></td>
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
        <input type="text" name="nombre" id="nombre" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Apellido</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" size="30">
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
        <input type="text" name="telefono" id="telefono" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Estado de residencia</td>
      <td><label>
        <input type="text" name="estado" id="estado" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Ciudad de residencia</td>
      <td><label>
        <input type="text" name="ciudad" id="ciudad" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Direccion de residencia</td>
      <td><label>
        <textarea name="direccion" id="direccion" cols="23" rows="3"></textarea>
      </label></td>
    </tr>
    <tr class="r1">
      <td>Cargo</td>
      <td><label>
        <select name="cargo" id="cargo">
        </select>
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" value="AGREGAR">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $contenido;
}
/**
 * Metodo para hacer aparecer al inicio el formulario para agregar un tripulate
 */
function nuevoTripulanteInicio() {
    $contenido = generarCrearNuevoTripulante();
    echo $contenido;
}

/**
 * Metodo para hacer aparacer el formulario de agregar nuevo tripulante
 * @return <xajaxResponse> respuesta del servidor
 */
function desplegarNuevoTripulante(){
    $respuesta = generarCrearNuevoTripulante();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}
/**
 * Metodo para generar un formulario para agregar un nuevo cargo
 * @return <String> html para crear el formulario
 */
function generarFormularioNuevoCargo(){
    $contenido = '<form name="form1" method="post" action="">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td>NUEVO CARGO</td>
      <td><div align="right">
        <label>
        <input type="submit" name="cerrar" id="cerrar" value="X" onclick="xajax_cerrarVentanaEditar()" />
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Descripcion</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Sueldo</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" value="AGREGAR">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $contenido;
}
/**
 * Metodo para presentar el formulario para agregar un nuevo cargo
 * @return <xajaxResponse> respuesta del servidor
 */
function desplegarNuevoCargo(){
    $respuesta = generarFormularioNuevoCargo();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("der", "innerHTML", $respuesta);
    return $objResponse;
}
?>
