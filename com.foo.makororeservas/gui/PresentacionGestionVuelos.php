<?phprequire $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionVuelos.php';$xajax = new xajax();$xajax->registerFunction("autoSugerir");$xajax->registerFunction("inicio");$xajax->registerFunction("desplegarFormularioNuevoVuelo");$xajax->registerFunction("editar");$xajax->registerFunction("procesarVuelo");$xajax->registerFunction("procesarEditarVuelo");$xajax->registerFunction("cerrarVentana");$xajax->registerFunction("borrarMensaje");$xajax->processRequests();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">    <head>        <style type="text/css">            @import url(ccs/styleMain.css);            @import url(ccs/styleTabla.css);            @import url(SpryAssets/SpryMenuBarHorizontal.css);            @import url(jscalendar/calendar-blue.css);        </style>        <script type="text/javascript" src="jscalendar/calendar.js"></script>        <script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>        <script type="text/javascript" src="jscalendar/calendar-setup.js"></script>        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />        <title>Gestion de Vuelos</title>        <?        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");        ?>        <script type="text/javascript">            function deseleccionar_todo(){                for (i=0;i<document.formBusqueda.elements.length;i++)                    if(document.formBusqueda.elements[i].type == "checkbox")                        document.formBusqueda.elements[i].checked=0            }            function suggest_over(div_value)            {                div_value.className = 'suggest_link_over';            }            function suggest_out(div_value)            {                div_value.className = 'suggest_link';            }            function set_search(value)            {                document.getElementById('txt_search').value = value;                document.getElementById('txt_result').innerHTML = '';                document.getElementById('txt_result').style.display = 'none';            }            function auto_suggest()            {                document.getElementById('txt_result').style.display = 'none';                xajax_autoSugerir(escape(document.getElementById('txt_search').value));            }        </script>        <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>    </head>    <body>        <div class="encabezado" id="encabezado">            <img src="imagenes/encabezado.png" width="900" height="65" alt="encabezado"/>        </div>        <div class="panelSesion">        <? echo $_SESSION['EncargadoLogin']; ?> | <? echo $_SESSION['FechaActual']; ?> | salir        </div>        <div id="sesion" class="cuerpo">            <?                include 'menu.php';            ?>        </div>        <div class="cuerpo">            <div class="izq2">                <div class="filtros">                    <div class="tituloNegro2">Filtrar Busqueda</div>                    <hr size="1" width="98%" color="#000000">                    <form class="textoNegro2" name="formBusqueda">                        <label>                            Busqueda:                            <input input="input" type="text" id="txt_search" name="txt_search" autocomplete="off" onkeyup="auto_suggest()" size="50"/>                        </label>                        <div id="txt_result"></div>                        <div id="check">                            <label></label>                        </div>                    </form>                </div>            </div>            <div class="der2">                <div class="panel">                    <div class="tituloNegro2">Operaciones</div>                    <hr width="98%" size="1" color="#067AC2">                    <div class="textoBlanco1"><input type="button" name="button" id="button" value="NUEVO VUELO" onclick="xajax_desplegarFormularioNuevoVuelo()"/>                    </div>                    </div>            </div>        </div>        <div class="cuerpo">            <div class="tableContainer" id="gestion"><script language="javaScript">xajax_inicio()</script></div>        </div>        <div class="cuerpo">            <div id="Mensaje">                <div class="mensaje">                  <div class="textoMensaje">Para agregar una nuevo vuelo presione el boton NUEVO VUELO</div><div class="botonCerrar"><input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()"></div></div>            </div>        </div>        <div class="cuerpo">            <div name id="izq"class="izq" align="center"></div>            <div id ="der" class="der" align="center"></div>        </div>        <div id = "foo"></div>    </body></html>