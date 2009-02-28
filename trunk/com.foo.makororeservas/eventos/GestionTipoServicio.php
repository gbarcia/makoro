<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTipoServicioLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoServicio.class.php';

function generarTabla() {
    $objResponse = new xajaxResponse();
    $resultado = "";
    $controlLogica = new ControlTipoServicioLogicaclass();
    $Coleccion = $controlLogica->consultarServicios();

    $resultado.= '<form name="formularioEditar">';
    $resultado.= '<table border=1>';
    $resultado.= '<tr>';
    $resultado.= '<th>SERVICIO</th>';
    $resultado.= '<th>ABREVIATURA</th>';
    $resultado.= '<th>HABILITADO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '<th>MARCAR</th>';
    $resultado.= '</tr>';
    while ($row = mysql_fetch_array($Coleccion)) {
        $tipoServicio = new TipoServicioclass();
        $tipoServicio->setHabilitadoString($row[habilitado]);
        $resultado.= '<tr>';
        $resultado.= '<td>' . $row[nombre]. '</td>';
        $resultado.= '<td>' . $row[abreviatura]. '</td>';
        $resultado.= '<td>' . $tipoServicio->getHabilitado(). '</td>';
        $resultado.= '<td><input type="button" name="editar" id="editar" value="EDITAR" onclick="xajax_mostrarFormularioEditar(xajax.getFormValues('.$row[id].'))" /></td>';
        $resultado.= '<td><input type="checkbox" name="servicios[]" values=""/></td>';
        $resultado.= '</tr>';
        
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    
    $objResponse->addAssign("gestionTipoServicio", "innerHTML", $resultado);

    return $objResponse;
}



function generarNuevoTipoServicio() {
    $contenido.='<form id="formNuevoServicio" name="formNuevoServicio">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td>NUEVO SERVICIO</td>
      <td><div align="right">
        <label>
        <input type="button" name="cerrar" id="cerrar" value="X" onclick="xajax_cerrarVentanaEditar()" />
        </label>
      </div></td>
    </tr>
    <tr class="r1">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" onKeyUp="this.value=this.value.toUpperCase();" id="nombre" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Abreviatura</td>
      <td><label>
        <input type="text" name="abreviatura" onKeyUp="this.value=this.value.toUpperCase();" id="abreviatura" size="30">
      </label></td>
    </tr>
    <tr class="r1">
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center"><input name="button" type="button" id="button" value="AGREGAR" onclick="xajax_procesarNuevoServicio(xajax.getFormValues(\'formNuevoServicio\'))">
            </div>
      </label></td>
    </tr>
  </table>
</form>';
    return $contenido;
}

function desplegarNuevoTipoServicio(){
    $respuesta = generarNuevoTipoServicio();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $respuesta);
    return $objResponse;
}

function procesarNuevoServicio ($datos) {
    $control = new ControlTipoServicioLogicaclass();
    $resultado = $control->nuevoTipoServicio($datos[abreviatura],
                                             $datos[nombre]);
    if ($resultado==true){
        $mensaje = 'Servicio insertado con exito';
    }else{
        $mensaje = 'No se pudo insertar el servicio';
    }
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("Mensaje", "innerHTML", $mensaje);
    $actualizar = generarTabla();
    $objResponse->addAssign("gestionTipoServicio", "innerHTML", $actualizar);

    return $objResponse;
}

function borrarMensaje(){
    $respuesta = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function cerrarVentanaEditar() {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    $objResponse->addAssign("Mensaje", "innerHTML", $resultado);
    return $objResponse;
}
?>