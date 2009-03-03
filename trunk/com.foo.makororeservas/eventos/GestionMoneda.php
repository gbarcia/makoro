<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Moneda.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorMonedaBD.class.php';

function cadenaTodasLasMonedas () {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>ID</th>';
    $resultado.= '<th>NOMBRE DE LA MONEDA</th>';
    $resultado.= '<th>SITIO DE LLEGADA</th>';
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
    $objResponse->addAssign("gestionRutas", "innerHTML", $resultado);
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
      <td>Sitio de salida</td>
      <td><label>
        <input type="text" name="moneda" id="moneda" size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarMoneda(xajax.getFormValues(\'formNuevaRuta\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    return $formulario;
}

function desplegarFormularioNuevaMoneda () {
    $resultado =  generarFormularioNuevaMoneda();
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izq", "innerHTML", $resultado);
    return $objResponse;
}
?>
