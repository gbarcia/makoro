<?phprequire $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionTripulantes.php';$xajax = new xajax();$xajax->registerFunction("autoSugerir");$xajax->registerFunction("mostrarEmpleados");$xajax->registerFunction("inabilitado");$xajax->registerFunction("editar");$xajax->processRequests();if (!isset($_GET['pag'])) $pag = 1;else $pag=$_GET['pag'];$tampag = 2;$reg1 = ($pag-1) * $tampag;?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">    <head>        <style type="text/css">            @import url(ccs/styleDisposicion.css);            @import url(ccs/styleTabla.css);        </style>        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />        <title>Gestion Tripulantes</title>        <?        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");        ?>        <script type="text/javascript">            function suggest_over(div_value)            {                div_value.className = 'suggest_link_over';            }            function suggest_out(div_value)            {                div_value.className = 'suggest_link';            }            function set_search(value)            {                document.getElementById('txt_search').value = value;                document.getElementById('txt_result').innerHTML = '';                document.getElementById('txt_result').style.display = 'none';            }            function auto_suggest()            {                document.getElementById('txt_result').style.display = 'none';                xajax_autoSugerir(escape(document.getElementById('txt_search').value));            }        </script>    </head>    <body>        <div class="filtros">            <form name="formBusqueda">                <div>                    <label>Cedula:                         <input input type="text" id="txt_search" name="txt_search" autocomplete="off" onkeyup="auto_suggest()" size="50" />                        <div id="txt_result"></div>                    </label>                </div>                <div><label>                        <input type="checkbox" name="desabilitado" value ="0" onClick="xajax_inabilitado(document.formBusqueda.desabilitado.checked)" />                </label><span class="styleLetras">Ver deshabilitados</span></div>            </form>        </div>        <div class="tablaResultado" id="gestionTripulante">            <?php autosugerirInicio($reg1,$tampag);            $totalRegistros = consultarNumeroTotalPersonal ();            echo paginar($pag, $totalRegistros, $tampag, "PresentacionGestionTripulantes.php?pag=");            ?>        </div>        <div name id="izq"class="izq">        </div>        <div class="der"></div>    </body></html>