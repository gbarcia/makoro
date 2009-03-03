<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlRutaLogica.class.php';

function cadenaTodasLasRutas () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>SITIO DE SALIDA</th>';
    $resultado.= '<th>CODIGO</th>';
    $resultado.= '<th>SITIO DE LLEGADA</th>';
    $resultado.= '<th>CODIGO</th>';
    $resultado.= '<th>TIEMPO</th>';
    $resultado.= '<th>COSTO</th>';
    $resultado.= '<th>GENERA IVA</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $controlLogica = new ControlRutaLogicaclass();
    $recurso = $controlLogica->consultarTodasLasRutas();
    $color = false;
    $row = new Rutaclass();
    foreach ($recurso as $row) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row->getSitioSalida(). '</td>';
        $resultado.= '<td>' . $row->getAbreviaturaSalida(). '</td>';
        $resultado.= '<td>' . $row->getSitioLlegada(). '</td>';
        $resultado.= '<td>' . $row->getAbreviaturaLlegada(). '</td>';
        $resultado.= '<td>' . $row->getTiempo(). '</td>';
        $resultado.= '<td>' . $row->getCosto(). ' BS'. '</td>';
        $resultado.= '<td>' . $row->getGeneraIVAString().'</td>';
        $resultado.= '<td><input type="button" value="EDITAR" onclick="xajax_editar(\'.$row->getSitioSalida().\',\'.$row->getAbreviaturaLlegada().\')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodasLasRutas();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestionRutas", "innerHTML", $resultado);
    return $objResponse;
}

function generarFormularioNuevaRuta () {
    $formulario ='<form id="formNuevaRuta">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVA RUTA
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentanaNuevoCargo()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">Todos los campos son requeridos</td>
      </tr>
    <tr class="r0">
      <td>Sitio de salida</td>
      <td><label>
        <input type="text" name="salida" id="salida" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Sitio de Llegada</td>
      <td><label>
        <input type="text" name="llegada" id="llegada" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>Adbreviatura Sitio de Salida</td>
      <td><label>
        <input type="text" name="salidaA" id="salidaA" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Adbreviatura Sitio de Llegada</td>
      <td><input type="text" name="llegadaA" id="llegadaA" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Tiempo de vuelo</td>
      <td><input type="text" name="tiempo" id="tiempo" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r1">
      <td>Costo del viaje</td>
      <td><input type="text" name="costo" id="costo" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Genera I.V.A</td>
      <td><select name="iva" id="iva">
        <option value="1" selected="selected">SI</option>
        <option value="0">No</option>
      </select>      </td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarRuta(xajax.getFormValues(\'formNuevaRuta\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioNuevaRuta () {
    $resultado = generarFormularioNuevaRuta();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function validarFormularioRuta ($datos) {
    $resultado = false;
    if (is_string($datos[salida]) && $datos[salida] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[llegada]) && $datos[llegada] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[salidaA]) && $datos[salidaA] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[llegadaA]) && $datos[llegadaA] != "")
    $resultado = true;
    else return false;
    if (is_numeric($datos[costo]) && $datos[costo] != "")
    $resultado = true;
    else return false;
    if (is_numeric($datos[tiempo]) && $datos[tiempo] != "")
    $resultado = true;
    else return false;
    if (is_numeric($datos[iva]) && $datos[iva] != "")
    $resultado = true;
    else return false;

    return $resultado;
}

function procesarRuta ($datos) {
    $objResponse = new xajaxResponse();
    if (validarFormularioRuta($datos)) {
        $respuesta = "";
        $controlRuta = new ControlRutaLogicaclass();
        $resultado = $controlRuta->nuevaRuta($datos[salida], $datos[llegada], $datos[tiempo], $datos[salidaA], $datos[llegadaA], $datos[iva],$datos[costo]);
        $objResponse = new xajaxResponse();
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nueva RUTA agregada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que la ruta no exista. GRBD001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLasRutas();
        $objResponse->addAssign("gestionRutas", "innerHTML", $actualizarTablaPrincipalRespuesta);}
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Los datos del formulario no son correctos. ERROR GRF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}

function generarFormularioEditar () {

}

?>
