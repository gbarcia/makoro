<?php
session_start();
session_register('EncargadoCedula');
session_register('EncargadoTipo');
session_register('EncargadoLogin');
session_register('EncargadoMail');
session_register('EncargadoSucursal');
session_register('EncargadoValido');
session_register('FechaActual');
$_SESSION['EncargadoTipo'] = "";
$_SESSION['EncargadoLogin'] = "";
$_SESSION['EncargadoCedula'] = "";
$_SESSION['EncargadoMail'] = "";
$_SESSION['EncargadoSucursal'] = "";
$_SESSION['EncargadoValido'] = FALSE;
$_SESSION['FechaActual'] = date ("Y") ."-".date ("m"). date ("d");
require $_SERVER['DOCUMENT_ROOT'] .'/com.foo.makororeservas/serviciotecnico/utilidades/xajax/xajax.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/InicioSession.php';
$xajax = new xajax();
$xajax->registerFunction("IniciarSession");
$xajax->processRequests();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Untitled Document</title>
        <?
        $xajax->printJavascript ("serviciotecnico/utilidades/xajax/");
        ?>
        <style type="text/css">
            <!--
            body {
                margin-left: 0px;
                margin-top: 0px;
                margin-right: 0px;
            }
            .style1 {
                font-size: 10px;
                font-family: Arial, Helvetica, sans-serif;
                color: #FFFFFF;
            }
            .style2 {color: #003399}
            .style3 {font-size: 11px}
            .style4 {font-size: 10px; font-family: Arial, Helvetica, sans-serif; color: #333333; }
            -->
        </style>
        <script type="text/javascript">
            function MM_preloadImages() {
                var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
                    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
                        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
                }
        </script>
    </head>

    <body>
    <form id= "formularioEntrada" name="formularioEntrada">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th height="124" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="124" valign="top" background="fondo_arriba_r1_c1.gif">&nbsp;</td>
                                    </tr>
                            </table></th>
                            <td width="900" rowspan="6" bgcolor="#FFFFFF"><table width="900" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td valign="top"><table width="900" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td><img src="gui/imagenes/login_r1_c1.gif" width="216" height="124" /></td>
                                                    <td><img src="gui/imagenes/login_r1_c2.gif" width="426" height="124" /></td>
                                                    <td><img src="gui/imagenes/login_r1_c6.gif" width="258" height="124" /></td>
                                                </tr>
                                        </table></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><table width="900" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><div align="center">
                                                            <table width="325" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td width="9" bgcolor="#25A5DE">&nbsp;</td>
                                                                    <td width="315" bgcolor="#003399"><span class="style1"><span class="style2">--</span> <span class="style3">Iniciar Sesión / Conectarse</span></span></td>
                                                                    <td width="8" rowspan="4">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="3">&nbsp;</td>
                                                                    <td bgcolor="#CCE3F2">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" bgcolor="#CCE3F2"><form id="form1" name="form1" method="post" action="">
                                                                            <table width="250" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td width="29">&nbsp;</td>
                                                                                    <td width="196" class="style4"><div align="center">Usuario:</div></td>
                                                                                    <td width="25">&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>&nbsp;</td>
                                                                                    <td class="style4"><div align="center">
                                                                                            <input type="text" name="login" id="login" />
                                                                                    </div></td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>&nbsp;</td>
                                                                                    <td class="style4"><div align="center">Contraseña:</div></td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>&nbsp;</td>
                                                                                    <td class="style4"><div align="center">
                                                                                            <input type="text" name="pass" id="pass" />
                                                                                    </div></td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>&nbsp;</td>
                                                                                    <td class="style4"><div align="center"></div></td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>&nbsp;</td>
                                                                                    <td class="style4"><div align="center">
                                                                                            <input type="button" name="button" id="button" value="ACCEDER" onclick="xajax_IniciarSession(xajax.getFormValues('formularioEntrada'))" />
                                                                                    </div></td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>&nbsp;</td>
                                                                                    <td class="style4">&nbsp;</td>
                                                                                    <td>&nbsp;</td>
                                                                                </tr>
                                                                            </table>
                                                                    </form>                          </td>
                                                                </tr>
                                                                <tr>
                                                                    <td bgcolor="#CCE3F2">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3"><div align="center"><img src="gui/imagenes/login_r3_c3.gif" width="332" height="21" /></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3"><div id="mensaje" align="center"></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="3">&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                    </div></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>

                                        </table></td>
                                    </tr>

                                </table>
                            <img src="gui/imagenes/login_r7_c1.gif" width="900" height="48" /></td>
                            <td height="124" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="124" background="fondo_arriba_r1_c1.gif">&nbsp;</td>
                                    </tr>
                            </table></td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                        </tr>
                        <tr>
                            <td valign="bottom" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="48" background="fondo_abajo_r2_c2.gif">&nbsp;</td>
                                    </tr>
                            </table></td>
                            <td valign="bottom" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="48" background="fondo_abajo_r2_c2.gif">&nbsp;</td>
                                    </tr>
                            </table></td>
                        </tr>

                </table></td>
            </tr>
        </table>
        </form>
    </body>
</html>
