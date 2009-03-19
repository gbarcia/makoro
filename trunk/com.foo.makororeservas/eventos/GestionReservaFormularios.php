<?php
function detalles($idVuelo){
    $controlVuelo = new ControlVueloLogicaclass();
    $recurso = $controlVuelo->consultarVuelosDetalles($idVuelo);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>&nbsp</th>';
    $resultado.= '<th>LOCALIZADOR</th>';
    $resultado.= '<th>CI/PASS</th>';
    $resultado.= '<th>PASAJERO</th>';
    $resultado.= '<th>TIPO</th>';
    $resultado.= '<th>SERV</th>';
    $resultado.= '<th>POSADA</th>';
    $resultado.= '<th>VENDEDOR</th>';
    $resultado.= '<th>SUCURSAL</th>';
    $resultado.= '<th>RETORNO</th>';
    $resultado.= '<th>CLIENTE</th>';
    $resultado.= '<th>P</th>';
    $resultado.= '<th>BANCO</th>';
    $resultado.= '<th>TRANSACCION</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    while ($row = mysql_fetch_array($recurso)){
        if ($row[estado] == "CO"){
            $resultado.= '<tr class="confirmado">';
        } else if ($row[estado] == "PP"){
            $resultado.= '<tr class="porPagar">';
        } else{
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td><input type="checkbox" name="" value="ON" /></td>';
        $resultado.= '<td>' . $row[solicitud] . '</td>';
        if ($row[cedulaPasaporte] != ''){
            $cedulaPasaporte = $row[cedulaPasaporte];
        } else {
            $cedulaPasaporte = '&nbsp';
        }
        $resultado.= '<td>' . $cedulaPasaporte . '</td>';
        $resultado.= '<td>' . $row[pasajero] . '</td>';
        if ($row[cedulaPasaporte] != ''){
            $tipoPasajero = $row[tipoPasajero];
        } else {
            $tipoPasajero = '&nbsp';
        }
        $resultado.= '<td>' . $tipoPasajero . '</td>';
        $resultado.= '<td>' . $row[servicio] . '</td>';
        if ($row[posada] != ''){
            $posada = $row[posada];
        } else {
            $posada = '&nbsp';
        }
        $resultado.= '<td>' . $posada . '</td>';
        $resultado.= '<td>' . $row[encargadoNombre] . '</td>';
        $resultado.= '<td>' . $row[sucursal] . '</td>';
        $resultado.= '<td>' . $row[vueloRetorno] . '</td>';
        $resultado.= '<td>' . $row[clienteNombre] . '</td>';
        $resultado.= '<td>' . $row[pago] . '</td>';
        $resultado.= '<td>' . $row[banco] . '</td>';
        $resultado.= '<td>' . $row[numeroTran] . '</td>';
        $resultado.= '</tr>';
    }
    return $resultado;
}

function generarFormularioNuevaReserva($idVuelo) {
    $contenido = "";
    $contenido .= '<form id="formNuevaReserva">
    <input name="idVuelo" value="' . $idVuelo . '" />
    <table class="formTable" cellspacing="0">
        <tr>
            <thead>
                <td colspan="3">
                    <div class="tituloBlanco1">
                        NUEVA RESERVA
                        <div class="botonCerrar">
                            <button name="boton" type="button" onclick="xajax_cerrarVentanaEditar()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
                        </div>
                    </div>
                </td>
            </thead>
        </tr>
        <tr class="r1">
            <td><input type="radio" name="grupo" value="juridico" checked="checked" />Juridico</td>
            <td>RIF</td>
            <td><input type="text" name="rif" id="rif"></td>
        </tr>
        <tr class="r0">
            <td><input type="radio" name="grupo" value="particular" />Particular</td>
            <td>Cedula</td>
            <td><input type="text" name="cedula" id="cedula"></td>
        </tr>
        <tr class="r1">
            <td colspan="3">
                <div align="center">
                    <input name="button" type="button" id="button" value="BUSCAR CLIENTE" onclick= "xajax_buscarCliente(xajax.getFormValues(\'formNuevaReserva\'))">
                </div>
            </td>
        </tr>
    </table>
<table class="formTable" cellspacing="0">
        <tr>
            <thead>
                <td colspan="3">
                    <div class="tituloBlanco1">
                        RESERVA EXISTENTE
                        <div class="botonCerrar">
                            <button name="boton" type="button" onclick="xajax_cerrarVentanaEditar()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
                        </div>
                    </div>
                </td>
            </thead>
        </tr>
        <tr class="r1">
            <td><input type="radio" name="grupo" value="juridico" checked="checked" /></td>
            <td>Localizador</td>
            <td><input type="text" name="rif" id="rif"></td>
        </tr>
        <tr class="r0">
            <td colspan="3">
                <div align="center">
                    <input name="button" type="button" id="button" value="BUSCAR CLIENTE" onclick= "xajax_buscarCliente(xajax.getFormValues(\'formNuevaReserva\'))">
                </div>
            </td>
        </tr>
    </table>
    </form>';
    return $contenido;
}

function generarFormularioConfirmarReserva($datos) {
    $contenido = "";
    $contenido .= '<form id="formConfirmarReserva">
    <input type="hidden" name="idVuelo" value="'.$datos[idVuelo].'" />
    <input type="hidden" name="tipoCliente" value="'.$datos[grupo].'" />
        <table class="formTable" cellspacing="0">
        <tr>
            <thead>
                <td colspan="3">
                    <div class="tituloBlanco1">
                        NUEVA RESERVA
                        <div class="botonCerrar">
                            <button name="boton" type="button" onclick="xajax_cerrarVentanaEditar()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
                        </div>
                    </div>
                </td>
            </thead>
        </tr>
        ';
    if ($datos[grupo] == 'juridico'){
        $nombre = buscarClienteJuridico($datos[rif]);
        $contenido .= '<input type="hidden" name="idCliente" value="'.$datos[rif].'" />
                       <tr class="r1">
                       <td>RIF</td>
                       <td>' . $datos[rif] . '</td>
                       </tr>';
    } else {
        $nombre = buscarClienteParticular($datos[cedula]);
        $contenido .= '<input type="hidden" name="idCliente" value="'.$datos[cedula].'" />
                       <tr class="r1">
                       <td>Cedula</td>
                       <td>' . $datos[cedula] . '</td>
                       </tr>';
    }

    $contenido .= '
        <tr class="r0">
            <td>Nombre</td>
            <td>'. $nombre .'</td>
        </tr>
        <tr class="r1">
            <td colspan="2">Introduzca la informacion de la reserva:</td>
        </tr>
        <tr class="r0">
            <td>Estado de la Reserva</td>
            <td>
                <select name="estado">
                <option value="PP">POR PAGAR</option>
                <option value="CO">CONFIRMADO</option>
                </select>
            </td>
        </tr>
        <tr class="r1">
            <td>Cantidad ADL/CHD</td>
            <td><input type="text" name="cantidadAdlChd" value="" /></td>
        </tr>
        <tr class="r0">
            <td>Cantidad INF</td>
            <td><input type="text" name="cantidadInf" value="" /></td>
        </tr>
        <tr class="r1">
            <td>Servicio</td>
            <td>' . generarComboBoxServicio() . '</td>
        </tr>
        <tr class="r0">
            <td>Posada</td>
            <td>' . generarComboBoxPosada() . '</td>
        </tr>
        <tr class="r1">
            <td colspan="2" align="center">
                <input name="button" type="button" id="button" value="AGREGAR RESERVA" onclick= "xajax_agregarReserva(xajax.getFormValues(\'formConfirmarReserva\'))">
            </td>
        </tr>
    </table>
    </form>';
    return $contenido;
}

function generarFormularioAgregarClienteJuridico($rif) {
    $contenido = '<form id="formNuevaAgencia">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVO CLIENTE JURIDICO
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">(*) Son campos obligatorios</td>
      </tr>
    <tr class="r0">
      <td>RIF</td>
      <td><label>
        <input type="text" name="rif" id="rif" readonly="readonly" value="' . $rif . '" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>(*) Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>(*) Telefono</td>
      <td><label>
        <input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>Estado</td>
      <td><input type="text" name="estado" id="estado" onkeyup="this.value=this.value.toUpperCase();" /></td>
    </tr>
    <tr class="r0">
      <td>Ciudad</td>
      <td><input type="text" name="ciudad" id="ciudad" onkeyup="this.value=this.value.toUpperCase();" /></td>
    </tr>
    <tr class="r1">
      <td>Direccion</td>
      <td><textarea name="direccion" id="direccion" cols="23" onkeyup="this.value=this.value.toUpperCase();"></textarea></td>
    </tr>
    <tr class="r0">
      <td>(*) Porcentaje de Comision</td>
      <td><input name="porcentaje" type="text" id="porcentaje" value="0.10"/></td>
    </tr>
    <tr class="r1">
      <td colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarAgencia(xajax.getFormValues(\'formNuevaAgencia\'))" />
      </div></td>
    </tr>
  </table></td>
    </tr>
</table>
</form>';
    return $contenido;
}

function generarFormularioAgregarClienteParticular($cedula) {
    $contenido = '<form id="formNuevoCliente">
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            NUEVO CLIENTE NATURAL
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">(*) Son campos obligatorios</td>
      </tr>
    <tr class="r0">
      <td>Cedula</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" value="'.$cedula.'" readonly="readonly"/>
      </label></td>
    </tr>
    <tr class="r1">
      <td>(*) Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>(*) Apellido</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td>(*) Telefono</td>
      <td><input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" /></td>
    </tr>
    <tr class="r0">
      <td>Estado</td>
      <td><input type="text" name="estado" id="estado" onkeyup="this.value=this.value.toUpperCase();" /></td>
    </tr>
    <tr class="r1">
      <td>Ciudad</td>
      <td><input type="text" name="ciudad" id="ciudad" onkeyup="this.value=this.value.toUpperCase();" /></td>
    </tr>
    <tr class="r0">
      <td>Direccion</td>
      <td><textarea name="direccion" id="direccion" cols="23" onkeyup="this.value=this.value.toUpperCase();"></textarea></td>
    </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="AGREGAR" onclick= "xajax_procesarCliente(xajax.getFormValues(\'formNuevoCliente\'))" />
      </div></td>
    </tr>
  </table></td>
    </tr>
</table>
</form>';
    return $contenido;
}

?>
