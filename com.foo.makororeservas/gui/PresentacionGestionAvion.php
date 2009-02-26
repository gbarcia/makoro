<?php
require $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionAvion.php';
$xajax = new xajax();
$xajax->registerFunction("autoSugerir");
$xajax->registerFunction("mostrarAviones");
$xajax->registerFunction("mostrarAvionesInhabilitados");
$xajax->registerFunction("mostrarFormularioAgregar");
$xajax->registerFunction("agregarAvion");
//$xajax->registerFunction("desplegarNuevoAvion");
$xajax->processRequests();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Gestion Avion</title>
        <?
        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");
        ?>
        <script type="text/javascript">
            function suggest_over(div_value)
            {
                div_value.className = 'suggest_link_over';
            }
            function suggest_out(div_value)
            {
                div_value.className = 'suggest_link';
            }
            function set_search(value)
            {
                document.getElementById('txt_search').value = value;
                document.getElementById('txt_result').innerHTML = '';
                document.getElementById('txt_result').style.display = 'none';
            }

            function auto_suggest()
            {
                document.getElementById('txt_result').style.display = 'none';
                xajax_autoSugerir(escape(document.getElementById('txt_search').value));
            }
        </script>
    </head>
    <body>
    	<div id="encabezado">IMAGEN ENCABEZADO</div>
        <div id="seccion"> DATOS DE SESSION</div>
        <div class="arriba">
        	<form id="busqueda" name="busqueda">
            	<div id="datos">
                	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                    	<tr>
                        	<td width="41%">
   	              <label>Matricula:</label>
                            	<input input="input" type="text" id="txt_search" name="txt_search" autocomplete="off" size="50"/>
                            </td>
                            
                      <td width="15%">
<div align="center">
                                    <label>
                                        <input type="button" name="button" id="button" value="NUEVO AVION" onClick="xajax_mostrarFormularioAgregar()"/>
                                    </label>
                                </div>
                            </td>
                            
              <td width="44%">
<div id="BotonEliminar" align="center">
                                        <div align="left">
                                          <input type="button" name="button3" id="button3" value="INHABLITAR SELECCION" />
                                                </div>
</div>
                          </td>
                      </tr>
                    </table>
                </div>
                
                <div id="check">
                	<label>
                        <input type="checkbox" name="deshabilitado" value ="0" onClick="xajax_mostrarAvionesInhabilitados(document.busqueda.deshabilitado.checked)"/>
                	</label>Ver solo deshabilitados
                </div>
            </form>
        </div>
        <div class="tablaResultado" id="gestionAvion">
           <script type="text/javascript">
		   xajax_mostrarAviones();
		   </script>
        </div>
        <div id="mensaje"></div>
        <div id="izquierda"></div>
        <div id="derecha"></div>
    </body>
</html>
