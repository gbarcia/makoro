<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';

/**
 * Metodo para iniciar la session en el sistema
 * Verifica que los datos sean correctos y toma una desicion de interfaz
 * Si son correctos envia al usuario al sistema, de lo contrario muestra un
 * mensaje de fallo de autenticacion
 * @param <Array> $datos arreglo con los datos del login y la clave
 * @return <xAjaxResponse> respuesta del servidor
 */
function IniciarSession ($datos) {
    $objResponse = new xajaxResponse();
    $control = new ControlSeguridadclass();
    $resultado = $control->validarSession(strtolower($datos[login]), strtolower($datos[pass]));
    if ($resultado == true) {
        $objResponse->addScript("document.getElementById('formularioEntrada').reset();");
        $objResponse->addScript("window.open('gui/PresentacionGestionReserva.php','mywindow','menubar=0,resizable=yes,scrollbars=1,width=1280,height=800');void(0)");
    }
    else {
        $mensaje = "<span class='textoRojo'>Fallo de Atenticacion.No Autorizado</span>";
        $objResponse->addAssign("mensaje", "innerHTML", "$mensaje");
    }
    return $objResponse;
}
?>
