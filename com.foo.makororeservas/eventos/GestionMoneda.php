<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Moneda.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorMonedaBD.class.php';

function cadenaTodasLasMonedas () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>ID</th>';
    $resultado.= '<th>NOMBRE DE LA MONEDA</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $controlLogica = new controladorMonedaBDclass();
    $recurso = $controlLogica->consultarMonedas();
    $color = false;
    while ($row = mysql_fetch_array($recurso)) {
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $row[id]. '</td>';
        $resultado.= '<td>' . $row[tipo]. '</td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    return $resultado;
}

function inicio () {
    $resultado = cadenaTodasLasMonedas();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestionMonedas", "innerHTML", $resultado);
    return $objResponse;
}

function generarFormularioNuevaMoneda() {
    $formulario ='<form id="formNuevaMoneda">
   <table class="formTable" cellspacing="0">
   <tr>
      <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVA MONEDA
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
      <td>Nombre de la moneda</td>
      <td><label>
        <input type="text" name="moneda" id="moneda" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarMoneda(xajax.getFormValues(\'formNuevaMoneda\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioNuevaMoneda() {
    $resultado = generarFormularioNuevaMoneda();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}

function validarFormularioMoneda ($datos) {
    $resultado = false;
    if (is_string($datos[moneda]) && $datos[moneda] != "")
    $resultado = true;

    return $resultado;
}

function procesarMoneda ($datos) {
    $objResponse = new xajaxResponse();
    if (validarFormularioMoneda($datos)) {
        $respuesta = "";
        $moneda = new Monedaclass();
        $moneda->setTipo($datos[moneda]);
        $controlMoneda = new controladorMonedaBDclass();
        $resultado =  $controlMoneda->agregarMoneda($moneda);
        if ($resultado){
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Nueva MONEDA agregada con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que la moneda no exista.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
        $actualizarTablaPrincipalRespuesta = cadenaTodasLasMonedas();
        $objResponse->addAssign("gestionMonedas", "innerHTML", $actualizarTablaPrincipalRespuesta);
        $objResponse->addAssign("izq", "innerHTML", "");
        }
    else {
        $respuesta .= '<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. No puede dejar el campo en blanco
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
