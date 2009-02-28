<?php
require $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionTipoServicio.php';
$xajax = new xajax();
$xajax->registerFunction("generarTabla");
$xajax->registerFunction("procesarNuevoServicio");
$xajax->registerFunction("desplegarNuevoTipoServicio");
$xajax->registerFunction("generarNuevoTipoServicio");
$xajax->registerFunction("cerrarVentanaEditar");
$xajax->registerFunction("borrarMensaje");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
        <?
        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");
        ?>
    </head>

    <body>
        <div class="filtros">
            <form id="formulario" name="formulario">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="19%">&nbsp;</td>
                        <td width="57%"><div id="filtros">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="33%">              <span id="sprycheckbox1">
                                                <label>
                                                    <input type="checkbox" name="checkDeshabilitado" id="checkDeshabilitado" />
                                                </label>
                                        <span class="checkboxRequiredMsg"></span></span>Ver sólo deshabilitados</td>
                                        <td width="28%">&nbsp;</td>
                                        <td width="10%"><label>
                                                <input type="button" name="button" id="button" value="AGREGAR SERVICIO"  align="right" onclick="xajax_desplegarNuevoTipoServicio()" />
                                        </label></td>
                                    </tr>
                                </table>
                        </div></td>
                        <td width="24%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    <tr>

                    </tr>
                </table>
            </form>
        </div>
        <div id="gestionTipoServicio" align="center"><script language="javascript">xajax_generarTabla()</script></div>

        <div id="Mensaje">
            <div class="mensaje">Para agregar un nuevo servicio presione el boton AGREGAR SERVICIO<input name="button" type="button" id="button" value="X" onclick="xajax_borrarMensaje()"></div>
        </div>
        <div id = "foo"></div>
        <div name id="izq"class="izq" align="center"></div>
    </body>
</html>