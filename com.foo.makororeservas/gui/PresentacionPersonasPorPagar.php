<?phpsession_start();if (!(session_is_registered('EncargadoValido')) && !(session_is_registered('EncargadoTipo'))){    die ("<script>location.href='../index.php'</script>");}else {    if ($_SESSION['EncargadoValido'] == true && $_SESSION['EncargadoTipo'] == 'A'){require $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/PersonasPorPagar.php';require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/CerrarSesion.php';$xajax = new xajax();$xajax->registerFunction("PersonasPorPagar");$xajax->registerFunction("salirDelSistema");$xajax->processRequests();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">    <head>        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />        <title>Personas que faltan por pagar</title>        <link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-blue.css" title="win2k-cold-1" />        <link rel="stylesheet" type="text/css" media="all" href="SpryAssets/SpryMenuBarHorizontal.css" title="win2k-cold-1" />         <link rel="stylesheet" type="text/css" media="all" href="ccs/styleDisposicion.css" />         <link rel="stylesheet" type="text/css" media="all" href="ccs/styleTabla.css" />        <script type="text/javascript" src="jscalendar/calendar.js"></script>        <script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>        <script type="text/javascript" src="jscalendar/calendar-setup.js"></script>        <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>        <?        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");        ?>    </head>    <body>        <form id="formularioCalculo" name="formularioCalculo">        <div  class="cuerpo">            <table width="100%" border="0" cellspacing="0" cellpadding="0">                <tr>                    <td colspan="3"><img src="imagenes/encabezado.png" width="900" height="65" /></td>                </tr>                <tr>                    <td colspan="3"><? include('menu.php');?></td>                </tr>                <tr>                  <td colspan="3">&nbsp;</td>                </tr>                <tr>                    <td width="17%">&nbsp;</td>                    <td width="72%"><div id="filtros">                            <table width="106%" border="0" cellspacing="0" cellpadding="0">                                <tr>                                    <td width="47%">Fecha Inicio:                                    <input name="fechaInicio" type="text" id="f_date_c" size="15" readonly="readonly" /><img src="jscalendar/img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector" /></td>                                    <td width="40%">Fecha Fin:                                    <input name="fechaFin" type="text" id="f_date_c2" size="15" /><img src="jscalendar/img.gif" id="f_trigger_c2" style="cursor: pointer; border: 1px solid red;" title="Date selector" /></td>                                    <td width="13%"><label>                                            <input type="button" name="consultar" id="button" value="CALCULAR" onclick="xajax_PersonasPorPagar(xajax.getFormValues('formularioCalculo'))" />                                    </label></td>                                </tr>                            </table>                    </div></td>                    <td width="11%">&nbsp;</td>                </tr>                <tr>                    <td colspan="3">&nbsp;</td>                </tr>                <tr>                    <td colspan="3"><div id="ResultadoCa" class="tableContainer"></div></td>                </tr>                <tr>                    <td colspan="3">&nbsp;</td>                </tr>                <tr>                    <td colspan="3"><div id="totalGeneral"></div></td>                </tr>                <tr>                    <td colspan="3"><label>                            <input type="button" name="button2" id="button2" value="IMPRIMIR" onclick="window.print();" />                    </label></td>                </tr>            </table>            </div>    </form>        <script language="javascript">            Calendar.setup({                inputField     :    "f_date_c",     // id of the input field                ifFormat       :    "%Y-%m-%d",      // format of the input field                button         :    "f_trigger_c",  // trigger for the calendar (button ID)                align          :    "Tl",           // alignment (defaults to "Bl")                singleClick    :    true            });            Calendar.setup({                inputField     :    "f_date_c2",     // id of the input field                ifFormat       :    "%Y-%m-%d",      // format of the input field                button         :    "f_trigger_c2",  // trigger for the calendar (button ID)                align          :    "Tl",           // alignment (defaults to "Bl")                singleClick    :    true            });        </script>    </body></html><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Untitled Document</title></head><body></body></html><?php}else {die ("<script>location.href='../index.php'</script>");}}?>