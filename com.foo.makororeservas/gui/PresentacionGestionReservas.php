<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionReserva.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/CerrarSesion.php';
$xajax = new xajax();
$xajax->registerFunction("generarComboBoxLugar");
$xajax->registerFunction("desplegarInicio");
$xajax->registerFunction("desplegarBusqueda");
$xajax->registerFunction("desplegarDetalles");
$xajax->registerFunction("buscarCliente");
$xajax->registerFunction("agregarReserva");
$xajax->registerFunction("borrarMensaje");
$xajax->registerFunction("procesarAgencia");
$xajax->registerFunction("procesarCliente");
$xajax->registerFunction("buscarSolicitud");
$xajax->registerFunction("desplegarFormularioNuevaReserva");
$xajax->registerFunction("desplegarFormularioCambiarEstado");
$xajax->registerFunction("desplegarFormularioCambiarEstado2");
$xajax->registerFunction("cambiarEstado");
$xajax->registerFunction("procesarPago");
$xajax->registerFunction("desplegarEditarPasajero");
$xajax->registerFunction("desplegarFormularioAsignarPasajero");
$xajax->registerFunction("desplegarFormularioAsignarPasajero2");
$xajax->registerFunction("generarObservaciones");
$xajax->registerFunction("guardarObservaciones");
$xajax->registerFunction("buscarPasajero");
$xajax->registerFunction("borrarFormPasajero");
$xajax->registerFunction("asignarPasajero");
$xajax->registerFunction("crearPasajero");
$xajax->registerFunction("generarBoletoGui");
$xajax->registerFunction("salirDelSistema");
$xajax->processRequests();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Gestion de Reservas</title>
        <?
        $xajax->printJavascript ("../serviciotecnico/utilidades/xajax/");
        ?>
        <script type="text/javascript" src="SpryAssets/SpryCollapsiblePanel.js"></script>
        <script type="text/javascript" src="SpryAssets/SpryMenuBar.js"></script>
        <script type="text/javascript" src="jscalendar/calendar.js"></script>
        <script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
        <script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
        <script type="text/javascript" language="JavaScript">
            <!--
            var nav4 = window.Event ? true : false;
            function acceptNum(evt){
                // NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
                var key = nav4 ? evt.which : evt.keyCode;
                return (key <= 13 || (key >= 48 && key <= 57));
            }
            //-->
        </script>
        <style type="text/css">
            @import url(ccs/styleMain.css);
            @import url(ccs/styleTabla.css);
            @import url(SpryAssets/SpryMenuBarHorizontal.css);
            @import url(SpryAssets/SpryCollapsiblePanel.css);
            @import url(jscalendar/calendar-blue.css);
        </style>
    </head>
    <body>

        <div class="encabezado" id="encabezado">
            <img src="imagenes/encabezado.png" width="900" height="65" alt="encabezado"/>
        </div>
        <div class="panelSesion">
            <? echo $_SESSION['EncargadoLogin']; ?> | <? echo $_SESSION['FechaActual']; ?> | <input type="button" name="button2" id="button2" value="SALIR" onclick="xajax_salirDelSistema();" />
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
                        <table class="textoNegro2" cellpadding="5" cellspacing="0" border="0">
                            <tr>
                                <td>Fecha de inicio:</td>
                                <td><input name="fechaInicio" type="text" id="f_date_c" size="15" /><img src="jscalendar/img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector" alt="Seleccione una fecha"/></td>
                                <td>Ruta:</td>
                                <td><div id="comboBoxRuta">
                                        <script type="text/javascript">
                                            xajax_generarComboBoxLugar();
                                        </script>
                                </div></td>
                            </tr>
                            <tr>
                                <td>Fecha de fin:</td>
                                <td><input name="fechaFin" type="text" id="f_date_c2" size="15" /><img src="jscalendar/img.gif" id="f_trigger_c2" style="cursor: pointer; border: 1px solid red;" title="Date selector" alt="Seleccione una fecha"/></td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="PanelReservas" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0">Por Reservas</div>
                    <div class="CollapsiblePanelContent">
                        <table class="textoNegro2"  cellpadding="5" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td>Localizador:</td>
                                    <td><input name="solicitud" type="text" value="" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                                    <td>Asientos disponibles ADL/CHD:</td>
                                    <td><input name="disponibilidad" type="text" value="" onKeyPress="return acceptNum(event)"/></td>
                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td>
                                        <select name="estado">
                                            <option value="">TODOS</option>
                                            <option value="PA">PAGADO</option>
                                            <option value="PP">POR PAGAR</option>
                                            <option value="CO">CONFIRMADO</option>
                                            <option value="CA">ANULADO</option>
                                        </select>
                                    </td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="PanelClientes" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0">Por Clientes</div>
                    <div class="CollapsiblePanelContent">
                        <table class="textoNegro2"  cellpadding="5" cellspacing="0" border="0">
                            <tr>
                                <td colspan="2">Cliente Natural</td>
                                <td colspan="2">Cliente Juridico</td>
                            </tr>
                            <tr>
                                <td>CI: </td>
                                <td><input name="cedulaCliente" type="text" value="" onKeyPress="return acceptNum(event)"/></td>
                                <td>RIF: </td>
                                <td><input type="text" name="rifCliente" value="" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                            </tr>
                            <tr>
                                <td>Nombre:</td>
                                <td><input type="text" name="nombreParticular" value="" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                                <td>Nombre:</td>
                                <td><input type="text" name="nombreAgencia" value="" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                            </tr>
                            <tr>
                                <td>Apellido:</td>
                                <td><input type="text" name="apellidoParticular" value="" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="PanelPasajeros" class="CollapsiblePanel">
                    <div class="CollapsiblePanelTab" tabindex="0">Por Pasajeros</div>
                    <div class="CollapsiblePanelContent">
                        <table class="textoNegro2"  cellpadding="5" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td>CI/Pasaporte:</td>
                                    <td><input type="text" name="cedulaPasaportePasajero" value="" onKeyUp="this.value=this.value.toUpperCase();" /></td>
                                    <td>Nombre: </td>
                                    <td><input type="text" name="nombrePasajero" value="" onKeyUp="this.value=this.value.toUpperCase();"/></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Apellido: </td>
                                    <td><input type="text" name="apellidoPasajero" value="" onKeyUp="this.value=this.value.toUpperCase();" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="textoNegro1" align="center">
                    <input type="button" value="VUELOS PARA FECHA ACTUAL" onclick="xajax_desplegarInicio()"/>
                    <input type="reset" value="LIMPIAR FORMULARIO" />
                    <input type="button" value="ACTUALIZAR BUSQUEDA" onclick="xajax_desplegarBusqueda(xajax.getFormValues('filtros'))"/>
                </div>
            </form>
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

        <div class="cuerpo">
            <div class="tableContainer" id="vuelos">
                <script type="text/javascript">
                    xajax_desplegarInicio();
                </script>
            </div>
            <div align="right">
                <cite class="textoNegro1">Leyenda: Para ver detalles del vuelo haga click en su icono. -
                    <img src="iconos/detalles.png" width="16" height="16" alt="detalles"/> Vuelos actuales -
                    <img src="iconos/detalles_rojo.png" width="16" height="16" alt="detalles_rojo"/> Vuelos anteriores -
                    <hr width="98%" size="1" color="#067AC2">
                </cite>
            </div>
        </div>

        <div class="cuerpo">
            <div id="fichaVuelo"></div>
            <div id="pasajeros"></div>
            <div id="leyenda" align="right"></div>
        </div>

        <div id="mensaje" class="cuerpo"></div>

        <div id="asignarPasajero" class="cuerpo" align=center></div>

        <div class="cuerpo">
            <div class="izq">
                <div id="nuevaReserva"></div>
            </div>
            <div class="der">
                <div id="panelOperaciones"></div>
                <div id="observaciones"></div>
            </div>
        </div>

        <div id="goUp" class="cuerpo" align="center"><a href="#"><img src="iconos/subir.png" width="32" height="32" border="0" alt=""/><div class="textoNegro1">Ir al tope</div></a></div>

    </body>
</html>
