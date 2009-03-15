<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';

function generarFormBoleto($solicitud,$cliente) {
    $objResponse = new xajaxResponse();
    $formulario = ' <form id="formulario" name="formulario"><input type="hidden" name="solicitud" id="hiddenField" value="'.$solicitud.'" />
                              <input type="hidden" name="cliente" id="hiddenField" value="'.$cliente.'" /><input type="text" name="correo" id="correo" />
                   <input type="button" name="button" id="button" value="ENVIAR"
                onclick= "xajax_procesarCorreo(xajax.getFormValues(\'formulario\'))" />
                            </form>';
    $objResponse->addAssign("correo", "innerHTML", "$formulario");
    return $objResponse;
}

function procesarCorreo ($datos) {
    $objResponse = new xajaxResponse();
    $respuesta = "";
    if ($datos[correo] != "") {
    $direccion = $datos[solicitud] . autoGenerarCodigo();
    $cuerpo = "<font size='2' face='Arial'><P>Estimado Cliente(a) de Makoro:</P>";
    $cuerpo .= "<P>La siguiente direccion, es para obtener el boleto electrónico, deacuerdo a la solicitud
               número ".$datos[solicitud]." a nombre de ".$datos[cliente].":</P>";
    $cuerpo .= "Dirección Web : http://www.makoroenlinea.com/com.foo.makororeservas/gui/boletoConsultas.php?nsolicitud=".$direccion. "<br>";
    $cuerpo .= "<P>En caso de tener alguna consulta en referencia a ésta página por favor no dude en contactarnos.</P>";
    $cuerpo .= "<P>soporte@makoroenlinea.com</P>";
    $cuerpo .= "<P>Gracias por preferirnos</P>";
    $cuerpo .= "<P>Equipo WEB de Makoro</P>";
    $control = new ControlSeguridadclass();
    $resultado = $control->enviarMail($datos[correo], $cuerpo);
    if ($resultado)
    $respuesta = "Correo enviado con éxito";
    else
    $respuesta = "No se pudo enviar el correo, intente de nuevo más tarde";
    }
    else
    $respuesta = "Debe indicar alguna dirección de correo válida";
    $objResponse->addAssign("mensaje", "innerHTML", "$respuesta");
    return $objResponse;
}

 function autoGenerarCodigo () {
        $variableNumerica    = rand(0000,9999);
        $arreglo             = array('a','b','c','d','e','f','g','h','i','j','k');
        $variableNumericaDos = rand(0,10);
        $clave              = $arreglo[$variableNumericaDos].$variableNumerica;
        return $clave;
    }
?>
