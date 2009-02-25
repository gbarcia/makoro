<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoCargoBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoCargo.class.php';

/**
 * Metodo para consultar todos los cargos registrados en el sistema
 * @return <type> objeto de respuesta xajax
 */
function consultarTodosLosTiposCargo() {
    $controlPersistencia = new controladorTipoCargoBDclass();
    $objResponse = new xajaxResponse();
    $resultado = "";
    $recurso = $controlPersistencia->obtenerTodosLosTiposCargo();
    $numFilas = mysql_num_rows($recurso);
    $resultado .= '<form id="formularioMostrarCargos">';
    $resultado.= '<table class="tabla">';
    $resultado.= '<tr class="titulo">';
    $resultado.= '<th>CARGO</th>';
    $resultado.= '<th>DESCRIPCION</th>';
    $resultado.= '<th>SUELDO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    while ($row = mysql_fetch_array($recurso)) {
        $resultado.= '<td>' . $row[cargo]. '</td>';
        $resultado.= '<td>' . $row[descripcion]. '</td>';
        $resultado.= '<td>' . $row[sueldo]. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_mostrarFormularioEditar('.$row[id].')"/></td>';
        $resultado.= '</tr>';
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    $objResponse->addAssign("gestionTipoCargo", "innerHTML", "$resultado");

    return $objResponse;
}

/**
 * Metodo para obtener todos los cargos del sistema
 * @return <type> Todos los cargos del sistema
 */
function obtenerCargos(){
    $controlPersistencia = new controladorTipoCargoBDclass();
    $recurso = $controlPersistencia->obtenerTodosLosTiposCargo();
    $numFilas = mysql_num_rows($recurso);
    $resultado .= '<form id="formularioMostrarCargos">';
    $resultado.= '<table class="tabla">';
    $resultado.= '<tr class="titulo">';
    $resultado.= '<th>CARGO</th>';
    $resultado.= '<th>DESCRIPCION</th>';
    $resultado.= '<th>SUELDO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    while ($row = mysql_fetch_array($recurso)) {
        $resultado.= '<td>' . $row[cargo]. '</td>';
        $resultado.= '<td>' . $row[descripcion]. '</td>';
        $resultado.= '<td>' . $row[sueldo]. '</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_mostrarFormularioEditar('.$row[id].')"/></td>';
        $resultado.= '</tr>';
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

/**
 * Metodo para construir el formulario para editar un cargo
 * @param <type> $idCargo El cargo a editar
 * @return <type> El formulario con los cargos del sistema
 */
function editarCargo($idCargo){
    $control = new controladorTipoCargoBDclass();
    $recurso = $control->obtenerCargoID($idCargo);
    $row = mysql_fetch_array($recurso);
    $contenido = '<form id="formularioEditar">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td>EDITAR SUELDO</td>
      <td><div align="right">
        <label>
        <input type="submit" name="cerrar" id="cerrar" value="X" onclick="xajax_cerrarVentana()" />
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td>Cargo</td>
      <td><label>
        <input type="text" name="cargo" id="cargo" size="30" readonly="readonly" value="'.$row[cargo].'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Sueldo</td>
      <td><label>
        <input type="text" name="sueldo" id="sueldo" size="30" value="'.$row[sueldo].'">
      </label></td>
    </tr>
    <tr class="r0">
      <td>&nbsp;</td>
      <td><label></label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" onclick="xajax_procesarCargo(xajax.getFormValues(\'formularioEditar\'),'.$row[id].')" value="EDITAR">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $contenido;
}

/**
 * Metodo para mostrar el formulario con los cargos
 * @param <type> $idCargo El cargo a editar
 * @return <type> xajax response
 */
function mostrarFormularioEditar($idCargo){
    $resultado = editarCargo($idCargo);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", "$resultado");
    return $objResponse;
}

/**
 * Metodo para cerrar la ventana de los formularios
 * @return <ajaxResponse> objeto de respuesta para modificar el div
 */
function cerrarVentana() {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", $resultado);
    return $objResponse;
}

/**
 * Metodo para editar un sueldo
 * @param <type> $datos Campos editados
 * @param <type> $idCargo El identificador del cargo que se quiere editar
 * @return <type> xajax response
 */
function procesarCargo($datos,$idCargo){
    $objResponse = new xajaxResponse();
    $objResponse->addConfirmCommands(10, "Esta seguro que desea modificar el sueldo?");
    $control = new controladorTipoCargoBDclass();
    $resultado = $control->actualizarSueldoTipoCargo($idCargo, $datos[sueldo]);
    if ($resultado==true){
        $mensaje = 'Sueldo actualizado con exito';
    }else{
        $mensaje = 'No se pudo actualizar el sueldo';
    }
    $objResponse->addAssign("mensaje", "innerHTML", $mensaje);
    $actualizar = obtenerCargos();
    $objResponse->addAssign("gestionTipoCargo", "innerHTML", $actualizar);

    return $objResponse;
}

function insertarNuevoCargo(){
    $contenido ='<form id="formularioAgregar">
                   <table cellpadding="2" cellspacing="1">
                     <tr class="titulo">
                       <td>AGREGAR CARGO</td>
                       <td><div align="right">
                         <label>
                         <input type="submit" name="cerrar" id="cerrar" value="X" accesskey="X" onclick=""xajax_cerrarVentana()"/>
                         </label>
                       </div></td>
                     </tr>
                     <tr class="r1">
                       <td>Cargo</td>
                       <td><label>
                         <input type="text" name="cargo" id="cargo" size="30" onKeyUp="this.value=this.value.toUpperCase();">
                       </label></td>
                     </tr>
                     <tr class="r0">
                       <td>Descripcion</td>
                       <td><label>
                         <input type="text" name="descripcion" id="descripcion" size="30" onKeyUp="this.value=this.value.toUpperCase();">
                       </label></td>
                     </tr>
                     <tr class="r1">
                       <td>Sueldo</td>
                       <td><label>
                         <input type="text" name="sueldo" id="sueldo" size="30">
                       </label></td>
                     </tr>
                     <tr class="r1">
                       <td>&nbsp;</td>
                       <td><label></label></td>
                     </tr>
                     <tr class="r0">
                       <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" onclick="xajax_agregarCargo(xajax.getFormValues(\'formularioAgregar\'))" value="AGREGAR">
                             </div>
                       </label></td>
                     </tr>
                   </table>
                 </form>';
    return $contenido;
}

function mostrarFormularioAgregar(){
    $resultado = insertarNuevoCargo();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izquierda", "innerHTML", "$resultado");
    return $objResponse;
}


function agregarCargo($datos){
    $control = new controladorTipoCargoBDclass();
    $tipoCargo = new TipoCargoclass();
    $tipoCargo->setCargo($datos[cargo]);
    $tipoCargo->setDescripcion($datos[descripcion]);
    $tipoCargo->setSueldo($datos[sueldo]);
    $resultado = $control->agregarTipoCargo($tipoCargo);
    if ($resultado==true){
        $mensaje = 'Cargo insertado con exito';
    }else{
        $mensaje = 'No se pudo insertar el cargo';
    }
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("mensaje", "innerHTML", $mensaje);
    $actualizar = obtenerCargos();
    $objResponse->addAssign("gestionTipoCargo", "innerHTML", $actualizar);

    return $objResponse;
}

?>
