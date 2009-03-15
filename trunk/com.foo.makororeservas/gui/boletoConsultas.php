<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlBoletoLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Boleto.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/InformacionGeneralBoletoRecibo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/DetallesEmitirBoleto.class.php';

$controlBoleto = new ControlBoletoLogicaclass();
$boletoClass = new Boletoclass();

$numeroRecibido = $_GET[nsolicitud];
$numeroSolicitud = substr($numeroRecibido, 0, 4);
if (is_null($Coleccion))
die ("Numero de solicitud invalido");
$Coleccion = $controlBoleto->informacionGeneralReciboBoleto($numeroSolicitud);
foreach ($Coleccion as $var) {
    $agente = $var->getAgente();
    $solicitud = $var->getSolicitud();
    $fechaEmision = $var->getFechaEmision();
    $fechaIda = $var->getFechaIda();
    $horaIda = $var->getHoraIda();
    $fechaVuelta = $var->getFechaVuelta();
    $horaVuelta = $var->getHoraVuelta();
    $lugarSalida = $var->getSalida();
    $lugarLlegada = $var->getRetorno();
    $servicio = $var->getServicio();
    $cliente = $var->getCliente();
    $identificadorCliente = $var->getIdentificadorCliente();
}
$Coleccion = $controlBoleto->detallesEmitirBoleto($numeroSolicitud);
foreach ($Coleccion as $var) {
    $cantidadAdultos = $var->getCantidadAdultos();
    $cantidadNinos = $var->getCantidadNinos();
    $cantidadInfantes = $var->getCantidadInfantes();
    $cantidadPasajeros = $cantidadAdultos+$cantidadNinos+$cantidadInfantes;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Boleto</title>
        <style type="text/css">
            <!--
            .style1 {
                font-family: "Courier New", Courier, monospace;
                font-size: 12px;
            }
            .style2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 10px;
            }
            .style5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; padding:5px }
            .style6 {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                font-weight: bold;
                font-style: italic;
            }
            -->
        </style>
    </head>

    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top"><table width="600" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td><table width="600" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="199" rowspan="2"><img src="imagenes/logoBoleto.JPG" width="194" height="90" /></td>
                                        <td width="401" height="61" valign="bottom"><span class="style1">Parque Nacional Archipielago de Los Roques - Venezuela</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="style2">RIF: J-29629945-5</span></td>
                                    </tr>
                            </table></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><table width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                                    <tr>
                                        <td colspan="3"><table width="600" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="214"><span class="style5">VOUCHERS ELECTRONICOS:</span></td>
                                            <td colspan="2"><span class="style5">
                                              <?=$cantidadPasajeros?>
                                              Boletos OW
                                              <?=$cantidadAdultos?>
                                              ADL
                                              <?=$cantidadNinos?>
                                              CHD
                                              <?=$cantidadInfantes?>
                                              INF</span></td>
                                          </tr>
                                          <tr>
                                            <td class="style5">Ruta Salida:
                                              <?=$lugarSalida?></td>
                                          
                                            <td width="218" class="style5">VUELO DE
                                              <?=$cliente?></td>
                                            <td width="168"></td>
                                          </tr>
                                          <tr>
                                            <td valign="top" class="style5">Ruta Retorno:
                                              <?=$lugarLlegada?></td>
                                            <td class="style5">&nbsp;</td>
                                            <td class="style5"><div align="right" class="style5">
                                              <?='# '.$solicitud?>
                                            </div></td>
                                            <td><div align="right"></div></td>
                                          </tr>
                                        </table></td>
                              </tr>
                                    <tr>

                                        <td width="369" rowspan="2" align="center" valign="middle"><table width="100%" border="0">
                                                <tr>
                                                    <td><div align="center">
                                                            <?php
                                                            $ColeccionPasajeros = $controlBoleto->informacionGeneralReciboBoleto($numeroSolicitud);
                                                            foreach ($ColeccionPasajeros as $var) {
                                                                $recursoDetalles = $var->getColeccionPasajero();
                                                                echo '<tr><td align="center">'. $recursoDetalles->getNombre().' '. $recursoDetalles->getApellido(). '</td></tr>';

                                                            }
                                                            ?>
                                                    </div>                  </td>
                                                </tr>
                                            </table>
                                        <br /></td>
                                        <td width="115" class="style5"><div align="center"><br />
                                                FECHA IN:<br />
                                                HORA:<br />
                                                <br />
                                        </div></td>
                                        <td width="112" class="style5"><div align="center"><br />
                                                <?=$fechaIda?><br />
                                                <?=$horaIda?><br />
                                                <br />
                                        </div></td>
                                    </tr>
                                    <tr>
                                        <td class="style5"><div align="center"><br />
                                                FECHA OUT:<br />
                                                HORA:<br />
                                                <br />
                                        </div></td>
                                        <td class="style5"><div align="center"><br />
                                                <?=$fechaVuelta?><br />
                                                <?=$horaVuelta?><br />
                                                <br />
                                        </div></td>
                                    </tr>
                          </table></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><table width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                                    <tr>
                                        <td>Notas</td>
                                    </tr>
                            </table></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><table width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                                    <tr>
                                        <td width="164" class="style5"><div align="center">Fecha de Emisión:</div></td>
                                        <td width="160" class="style5"><div align="left"><?=$fechaEmision?></div></td>
                                        <td width="84" class="style5"><div align="center">Agente:</div></td>
                                        <td width="182" class="style5"><div align="left"><?=$agente?></div></td>
                                    </tr>
                            </table></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><div align="justify" class="style6">ES INDISPENSABLE LA PRESENTACION DE ESTE BOLETO PARA EL CHEQUEO DEL VUELO. SIN EL NO PODRÁ SER EMBARCADO EN EL AVION</div></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td><input type="button" name="button2" id="button2" value="IMPRIMIR" onclick="window.print();" />&nbsp;</td>
                        </tr>
              </table></td>
            </tr>
        </table>
    </body>
</html>
