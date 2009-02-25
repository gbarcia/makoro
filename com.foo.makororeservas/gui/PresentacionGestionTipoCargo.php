<?php
require $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionTipoCargo.php';
$xajax = new xajax();
$xajax->registerFunction("consultarTodosLosTiposCargo");
$xajax->registerFunction("editarCargo");
$xajax->registerFunction("mostrarFormularioEditar");
$xajax->registerFunction("cerrarVentana");
$xajax->registerFunction("procesarCargo");
$xajax->registerFunction("agregarCargo");
$xajax->registerFunction("mostrarFormularioAgregar");
$xajax->processRequests();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Gestion Tipo Cargo</title>
        <?
        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");
        ?>
    </head>
    <body>
    	<div id="encabezado">IMAGEN ENCABEZADO</div>
        <div id="seccion"> DATOS DE SESSION</div>
        <div id="nuevoCargo">
        	<table width="558" border="0">
              <tr>
                <td width="447">CARGOS</td>
                <td width="101"> <input name="nuevoCargo" type="button" value="NUEVO CARGO" onClick="xajax_mostrarFormularioAgregar()"/> </td>
              </tr>
            </table>
    </div>
        <div class="tablaConsulta" id="gestionTipoCargo">
           <script type="text/javascript">
		   xajax_consultarTodosLosTiposCargo();
		   </script>
        </div>
        <div id="mensaje"></div>
        <div id="izquierda"></div>
        <div id="derecha"></div>
    </body>
</html>
