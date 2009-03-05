<?php
require $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionReserva.php';
$xajax = new xajax();
$xajax->registerFunction("generarComboBoxLugar");
$xajax->registerFunction("generarComboBoxSucursal");
$xajax->registerFunction("generarComboBoxEncargado");
$xajax->registerFunction("procesarFiltros");
$xajax->processRequests();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Gestion Reservas</title>
        <?
        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");
        ?>
        <script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
        <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
        <script type="text/javascript" src="jscalendar/calendar.js"></script>
        <script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
        <script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
        <style type="text/css">
            @import url(ccs/styleMain.css);
            @import url(ccs/styleTabla.css);
            @import url(SpryAssets/SpryMenuBarHorizontal.css);
            @import url(SpryAssets/SpryCollapsiblePanel.css);
            @import url(jscalendar/calendar-blue.css);
        </style>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div class="encabezado" id="encabezado">
            <img src="imagenes/encabezado.png" width="900" height="65" alt="encabezado"/>
        </div>
        <div class="panelSesion">
            <? echo $_SESSION['EncargadoLogin']; ?> | <? echo $_SESSION['FechaActual']; ?> | salir
        </div>
        <div id="sesion" class="cuerpo">
            <?
            include 'menu.php';
            ?>
        </div>
        <div class="cuerpo">
            <form id="filtros">
                <div id="PanelVuelos" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0">Por Vuelos</div>
                    <div class="CollapsiblePanelContent">
                        <table border="0" width="100">
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                        </table>







                        <div>Fecha de inicio: <input name="fechaInicio" type="text" id="f_date_c" size="15" readonly="readonly" /><img src="jscalendar/img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector" /></div>
                        <div>Fecha de fin: <input name="fechaFin" type="text" id="f_date_c2" size="15" readonly="readonly" /><img src="jscalendar/img.gif" id="f_trigger_c2" style="cursor: pointer; border: 1px solid red;" title="Date selector" /></div>
                        <div id="comboBoxRuta">
                            <script language="javascript">
                                xajax_generarComboBoxLugar();
                            </script>
                        </div>

                    </div>
                </div>

                <div id="PanelReservas" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0">Por Reservas</div>
                    <div class="CollapsiblePanelContent">
                        <div>Disponibilidad: <input type="text" name="" value="" /></div>
                        <div id="comboBoxSucursal">
                            <script language="javascript">
                                xajax_generarComboBoxSucursal();
                            </script>
                        </div>
                        <div id="comboBoxEncargado">
                            <script language="javascript">
                                xajax_generarComboBoxEncargado();
                            </script>
                        </div>
                        <div>Solicitud: <input type="text" name="" value="" /></div>
                        <div>Estado: <select name="estado">
                                <option value="">TODOS</option>
                                <option value="PA">PAGADO</option>
                                <option value="PP">POR PAGAR</option>
                                <option value="CO">CONFIRMADO</option>
                                <option value="CA">CANCELADO</option>
                        </select></div>
                    </div>
                </div>

                <div id="PanelClientes" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0">Clientes</div>
                    <div class="CollapsiblePanelContent">
                        <div>CI/RIF: <input type="text" name="" value="" /></div>
                        <div>Nombre: <input type="text" name="" value="" /></div>
                    </div>
                </div>

                <div id="PanelPasajeros" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0">Pasajeros</div>
                    <div class="CollapsiblePanelContent">
                        <div>CI/Pasaporte: <input type="text" name="" value="" /></div>
                        <div>Nombre: <input type="text" name="" value="" /></div>
                    </div>
                </div>
                <script type="text/javascript">
                    <!--
                    var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("PanelVuelos", {enableAnimation:false, contentIsOpen:true});
                    var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("PanelReservas", {enableAnimation:false, contentIsOpen:true});
                    var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("PanelClientes", {enableAnimation:false, contentIsOpen:false});
                    var CollapsiblePanel4 = new Spry.Widget.CollapsiblePanel("PanelPasajeros", {enableAnimation:false, contentIsOpen:false});
                    //-->
                    Calendar.setup({
                        inputField     :    "f_date_c",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "f_trigger_c",  // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
                        singleClick    :    true
                    });
                    Calendar.setup({
                        inputField     :    "f_date_c2",     // id of the input field
                        ifFormat       :    "%Y-%m-%d",      // format of the input field
                        button         :    "f_trigger_c2",  // trigger for the calendar (button ID)
                        align          :    "Tl",           // alignment (defaults to "Bl")
                        singleClick    :    true
                    });
                </script>
                <div class="textoNegro1" align="right"><input type="button" value="Filtrar" onclick="xajax_procesarFiltros(xajax.getFormValues('filtros'))"/></div>
            </form>
        </div>
        <div id="resultadoVuelos" class="cuerpo">
            <div class="tableContainer" id="gestionReserva">

            </div>
        </div>

    </body>
</html>
