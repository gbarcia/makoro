<?phprequire $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionTripulantes.php';$xajax = new xajax();$xajax->registerFunction("autoSugerir");$xajax->registerFunction("mostrarEmpleados");$xajax->registerFunction("inabilitado");$xajax->registerFunction("editar");$xajax->registerFunction("cerrarVentanaEditar");$xajax->registerFunction("procesarUpdate");$xajax->registerFunction("eliminarTripulante");$xajax->registerFunction("habilitarTripulante");$xajax->processRequests();if (!isset($_GET['pag'])) $pag = 1;else $pag=$_GET['pag'];$tampag = 20;$reg1 = ($pag-1) * $tampag;?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">    <head>        <style type="text/css">            @import url(ccs/styleDisposicion.css);            @import url(ccs/styleTabla.css);        </style>        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />        <title>Gestion Tripulantes</title>        <?        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");        ?>        <script type="text/javascript">            function suggest_over(div_value)            {                div_value.className = 'suggest_link_over';            }            function suggest_out(div_value)            {                div_value.className = 'suggest_link';            }            function set_search(value)            {                document.getElementById('txt_search').value = value;                document.getElementById('txt_result').innerHTML = '';                document.getElementById('txt_result').style.display = 'none';            }            function auto_suggest()            {                document.getElementById('txt_result').style.display = 'none';                xajax_autoSugerir(escape(document.getElementById('txt_search').value));            }        </script>    </head>    <body>        <div class="filtros">            <form name="formBusqueda">                <div>                  <table width="100%" border="0" cellspacing="0" cellpadding="0">                    <tr>                      <td width="51%"><label>                        Cedula:</label>                      <input input="input" type="text" id="txt_search" name="txt_search" autocomplete="off" onkeyup="auto_suggest()" size="50"/></td>                      <td width="14%"><div align="center">                        <label>                        <input type="button" name="button" id="button" value="NUEVO TRIPULANTE" />                        </label>                      </div></td>                      <td width="17%"><div align="center">                        <input type="button" name="button2" id="button2" value="NUEVO CARGO" />                      </div></td>                      <td width="18%"><div id="BotonEliminar" align="center">                        <input type="button" name="button3" id="button3" value="INHABLITAR SELECCION" onclick="xajax_eliminarTripulante(xajax.getFormValues('formularioEditarMarcar'))" />                      </div></td>                    </tr>                  </table>                  <div id="txt_result"></div>                </div>                <div><label>                        <input type="checkbox" name="desabilitado" value ="0" onClick="xajax_inabilitado(document.formBusqueda.desabilitado.checked)" />                </label><span class="styleLetras">Ver deshabilitados</span></div>            </form>        </div>        <div class="tablaResultado" id="gestionTripulante">            <?php autosugerirInicio($reg1,$tampag);            $totalRegistros = consultarNumeroTotalPersonal ();            echo paginar($pag, $totalRegistros, $tampag, "PresentacionGestionTripulantes.php?pag=");            ?>        </div>         <div id="Mensaje"> </div><div id = "foo"></div>        <div name id="izq"class="izq">        </div>        <div class="der"></div>    </body></html>