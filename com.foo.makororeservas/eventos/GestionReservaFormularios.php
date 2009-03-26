<?php
function detalles($idVuelo){
    $controlVuelo = new ControlVueloLogicaclass();
    $recurso = $controlVuelo->consultarVuelosDetalles($idVuelo);
    $resultado = '<div class="tableContainer">';
    $resultado.= '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>&nbsp</th>';
    $resultado.= '<th>ID</th>';
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
    $resultado.= '<tbody>';

    $cant = mysql_num_rows($recurso);
    if($cant == 0){
        $resultado = tablaVacia();
    }
    else{
        while ($row = mysql_fetch_array($recurso)){
            if ($row[estado] == "CO"){
                $resultado.= '<tr class="confirmado">';
            } else if ($row[estado] == "PP"){
                $resultado.= '<tr class="porPagar">';
            } else{
                $resultado.= '<tr class="r1">';
            }
            if (($row[tipoPasajero] == 'INF') || ($row[cedulaPasaporte] != '')){
                $boton = '<a onClick=""><img src="imagenes/editarPass_gris.png" alt="EDITAR NO DISPONIBLE"/></a>';
            } else {
                $boton = '<a onClick="xajax_desplegarFormularioAsignarPasajero('.$idVuelo.','.$row[id].')"><img src="imagenes/editarPass.png" alt="EDITAR"/></a>';
            }
            $resultado.= '<td>'.$boton.'</td>';
            $resultado.= '<td>' . $row[id] . '</td>';
            $resultado.= '<td>' . $row[solicitud] . '</td>';

            if ($row[cedulaPasaporte] != ''){
                $cedulaPasaporte = $row[cedulaPasaporte];
            } else {
                $cedulaPasaporte = '&nbsp';
            }
            $resultado.= '<td>' . $cedulaPasaporte . '</td>';

            if ($row[pasajero] != ''){
                $pasajero = $row[pasajero];
            } else {
                $pasajero = '&nbsp';
            }
            $resultado.= '<td>' . $pasajero . '</td>';

            if ($row[tipoPasajero] != ''){
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

            if ($row[banco] != ''){
                $banco = $row[banco];
            } else {
                $banco = '&nbsp';
            }
            $resultado.= '<td>' . $banco . '</td>';

            if ($row[numeroTran] != ''){
                $numeroTran = $row[numeroTran];
            } else {
                $numeroTran = '&nbsp';
            }
            $resultado.= '<td>' . $numeroTran . '</td>';
            $resultado.= '</tr>';
        }
    }
    $resultado.= '</tbody>';
    $resultado.= '</table>';
    $resultado.= '</form>';
    $resultado.= '</div>';
    return $resultado;
}

function generarFormularioNuevaReserva($idVuelo) {
    $contenido = "";
    $contenido .= '<form id="formNuevaReserva">
            <input type="hidden" name="idVuelo" value="' . $idVuelo . '" />
            <table class="formTable" cellspacing="0">
            <thead>
            <tr>
            <td colspan="3">
            <div class="tituloBlanco1">
            NUEVA RESERVA
            </div>
            </td>
            </tr>
            </thead>
            <tbody>
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
            <td colspan="3" align="center">
            <input name="button" type="button" id="button" value="BUSCAR CLIENTE" onclick= "xajax_buscarCliente(xajax.getFormValues(\'formNuevaReserva\'))">
            </td>
            </tr>
            </tbody>
            </table>
            </form>
            <form id="formSolicitudExistente">
            <input type="hidden" name="idVuelo" value="' . $idVuelo . '" />
            <table class="formTable" cellspacing="0">
            <thead>
            <tr>
            <td colspan="2">
            <div class="tituloBlanco1">
            LOCALIZADOR EXISTENTE
            </div>
            </td>
            </tr>
            </thead>
            <tbody>
            <tr class="r1">
            <td>Localizador</td>
            <td><input type="text" name="solicitud" id="solicitud" onkeyup="this.value=this.value.toUpperCase();"></td>
            </tr>
            <tr class="r0">
            <td colspan="2" align="center">
            <input name="button" type="button" id="button" value="BUSCAR LOCALIZADOR" onclick= "xajax_buscarSolicitud(xajax.getFormValues(\'formSolicitudExistente\'))">
            </td>
            </tr>
            </tbody>
            </table>
            </form>';
    return $contenido;
}

function generarFormularioConfirmarReserva($datos) {
    if ($datos[solicitud] != ''){
        $contenido.= '<form id="formConfirmarReserva"><input type="hidden" name="tipoVuelo" value="vuelta" />';
    } else {
        $contenido.= '<form id="formConfirmarReserva"><input type="hidden" name="tipoVuelo" value="ida" />';
    }
    $contenido .= '<input type="hidden" name="idVuelo" value="'.$datos[idVuelo].'" />
            <input type="hidden" name="tipoCliente" value="'.$datos[grupo].'" />
            <input type="hidden" name="solicitud" value="'.$datos[solicitud].'" />
            <table class="formTable" cellspacing="0">
            <thead>
            <tr>
            <td colspan="3">
            <div class="tituloBlanco1">
            NUEVA RESERVA
            </div>
            </td>
            </tr>
            </thead>
            <tbody>
        ';
    if ($datos[grupo] == 'juridico'){
        $nombre = buscarClienteJuridico($datos[rif]);
        $contenido .= '<input type="hidden" name="idCliente" value="'.$datos[rif].'" />
            <tr class="r1">
            <td>RIF</td>
            <td><input  name="rif" value="'.$datos[rif].'" readonly="readonly"/></td>
            </tr>';
    } else {
        $nombre = buscarClienteParticular($datos[cedula]);
        $contenido .= '<input type="hidden" name="idCliente" value="'.$datos[cedula].'" />
            <tr class="r1">
            <td>Cedula</td>
            <td><input  name="cedula" value="'.$datos[cedula].'" readonly="readonly"/></td>
            </tr>';
    }

    $contenido .= '
            <tr class="r0">
            <td>Nombre</td>
            <td><input  name="nombre" value="'.$nombre.'" readonly="readonly"/></td>
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
            <td><input type="text" name="cantidadAdlChd" value="" onKeyPress="return acceptNum(event)"/></td>
            </tr>
            <tr class="r0">
            <td>Cantidad INF</td>
            <td><input type="text" name="cantidadInf" value="" onKeyPress="return acceptNum(event)"/></td>
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
            <input name="button" type="button" id="button" value="VOLVER" onclick= "xajax_desplegarFormularioNuevaReserva('.$datos[idVuelo].')" />
            <input name="button" type="button" id="button" value="AGREGAR RESERVA" onclick= "xajax_agregarReserva(xajax.getFormValues(\'formConfirmarReserva\'))">
            </td>
            </tr>
            </tbody>
            </table>
            </form>';
    return $contenido;
}

function generarFormularioAgregarClienteJuridico($datos) {
    $contenido = '<form id="formNuevaAgencia">
            <input type="hidden" name="idVuelo" value="'.$datos[idVuelo].'" />
            <input type="hidden" name="grupo" value="'.$datos[grupo].'" />
            <table class="formTable" cellspacing="0">
            <thead>
            <tr>
            <td colspan="2">
            <div class="tituloBlanco1">
            NUEVO CLIENTE JURIDICO
            </div>
            </td>
            </tr>
            </thead>
            <tbody>
            <tr class="r1">
            <td colspan="2">Todos los campos son obligatorios</td>
            </tr>
            <tr class="r0">
            <td>RIF</td>
            <td><label>
            <input type="text" name="rif" id="rif" readonly="readonly" value="' . $datos[rif] . '" />
            </label></td>
            </tr>
            <tr class="r1">
            <td>Nombre</td>
            <td><label>
            <input type="text" name="nombre" id="nombre" onkeyup="this.value=this.value.toUpperCase();" />
            </label></td>
            </tr>
            <tr class="r0">
            <td>Telefono</td>
            <td><label>
            <input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" />
            </label></td>
            </tr>
            <tr class="r1">
            <td colspan="2" align="center">
            <input name="button" type="button" id="button" value="VOLVER" onclick= "xajax_desplegarFormularioNuevaReserva('.$datos[idVuelo].')" />
            <input name="button" type="button" id="button" value="CONTINUAR" onclick= "xajax_procesarAgencia(xajax.getFormValues(\'formNuevaAgencia\'))" />
            </td>
            </tr>
            </tbody>
            </table>
            </form>';
    return $contenido;
}

function generarFormularioAgregarClienteParticular($datos) {
    $contenido = '<form id="formNuevoCliente">
            <input type="hidden" name="idVuelo" value="'.$datos[idVuelo].'" />
            <input type="hidden" name="grupo" value="'.$datos[grupo].'" />
            <table class="formTable" cellspacing="0">
            <thead>
            <tr>
            <td colspan="2">
            <div class="tituloBlanco1">
            NUEVO CLIENTE NATURAL
            </div>
            </td>
            </tr>
            </thead>
            <tbody>
            <tr class="r1">
            <td colspan="2">Todos los campos son obligatorios</td>
            </tr>
            <tr class="r0">
            <td>Cedula</td>
            <td><label>
            <input type="text" name="cedula" id="cedula" value="'.$datos[cedula].'" readonly="readonly" onKeyPress="return acceptNum(event)"/>
            </label></td>
            </tr>
            <tr class="r1">
            <td>Nombre</td>
            <td><label>
            <input type="text" name="nombre" id="nombre" onkeyup="this.value=this.value.toUpperCase();" />
            </label></td>
            </tr>
            <tr class="r0">
            <td>Apellido</td>
            <td><label>
            <input type="text" name="apellido" id="apellido" onkeyup="this.value=this.value.toUpperCase();" />
            </label></td>
            </tr>
            <tr class="r1">
            <td>Telefono</td>
            <td><input type="text" name="telefono" id="telefono" onkeyup="this.value=this.value.toUpperCase();" /></td>
            </tr>
            <tr class="r0">
            <td colspan="2" align="center">
            <input name="button" type="button" id="button" value="VOLVER" onclick= "xajax_desplegarFormularioNuevaReserva('.$datos[idVuelo].')" />
            <input name="button" type="button" id="button" value="CONTINUAR" onclick= "xajax_procesarCliente(xajax.getFormValues(\'formNuevoCliente\'))" />
            </td>
            </tr>
            </tbody>
            </table>
            </form>';
    return $contenido;
}

function tablaVacia(){
    $resultado = '<table class="scrollTable" cellspacing="0">';
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
    $resultado.= '<tbody>';
    $resultado.= '<tr class="r1">';
    $resultado.= '<th colspan="14">NO HAY RESERVAS PARA ESTE VUELO</th>';
    $resultado.= '</tr>';
    $resultado.= '</tbody>';
    $resultado.= '</table>';
    return $resultado;
}

function generarFormularioCambiarEstado($idVuelo){
    $contenido = '<form id="formCambiarEstado">
            <input type="hidden" name="idVuelo" value="'.$idVuelo.'" />
            <table border="0">
            <tr>
            <td>Localizador</td>
            <td><input type="text" name="solicitud" value="" onkeyup="this.value=this.value.toUpperCase();"/></td>
            </tr>
            <tr>
            <td>Nuevo Estado</td>
            <td><select name="estado">
            <option value="PA">PAGADO</option>
            <option value="CO">CONFIRMADO</option>
            <option value="CA">ANULADO</option>
            </select></td>
            </tr>
            <tr>
            <td>&nbsp</td>
            <td>
            <input name="button" type="button" id="button" value="CONTINUAR" onclick= "xajax_cambiarEstado(xajax.getFormValues(\'formCambiarEstado\'))" />
            </td>
            </tr>
            </table>
            </form>';
    return $contenido;
}

function generarFormularioCambiarEstado2($datos){
    $contenido = '<form id="formCambiarEstado">
            <input type="hidden" name="idVuelo" value="'.$datos[idVuelo].'" />
            <input type="hidden" name="estado" value="PA" />
            <table border="0">
            <tr>
            <td>Localizador</td>
            <td><input type="text" name="solicitud" value="'.$datos[solicitud].'" readonly="readonly"/></td>
            </tr>
            <tr>
            <td>Forma de pago</td>
            <td><select name="tipoPago">
            <option value="EF">PAGO EN EFECTIVO</option>
            <option value="DE">DEPOSITO</option>
            <option value="CH">CHEQUE</option>
            <option value="TR">TRANSFERENCIA BANCARIA</option>
            </select></td>
            </tr>
            <tr>
            <td colspan="2">En caso de ser transaccion bancaria:</td>
            </tr>
            <tr>
            <td>Banco</td>
            <td><input type="text" name="banco" value="" onkeyup="this.value=this.value.toUpperCase();"/></td>
            </tr>
            <tr>
            <td>Nro Transaccion</td>
            <td><input type="text" name="transaccion" value="" onkeyup="this.value=this.value.toUpperCase();"/></td>
            </tr>
            <tr>
            <td colspan="2" align="center"><input name="button" type="button" id="button" value="VOLVER" onclick= "xajax_desplegarFormularioCambiarEstado('.$datos[idVuelo].')" />
            <input name="button" type="button" id="button" value="CAMBIAR ESTADO" onclick= "xajax_procesarPago(xajax.getFormValues(\'formCambiarEstado\'))" /></td>
            </tr>
            </table>
            </form>';
    return $contenido;
}

function generarFormularioAsignarPasajero($idVuelo, $idReserva) {
    $contenido = "";
    $contenido .= '<form id="formNuevoPasajero">
            <input type="hidden" name="idVuelo" value="' . $idVuelo . '" />
            <table class="formTable" cellspacing="0">
            <thead>
            <tr>
            <td colspan="2">
            <div class="tituloBlanco1">
            DATOS DEL PASAJERO
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_borrarFormPasajero()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
            </div>
            </td>
            </tr>
            </thead>
            <tbody>
            <tr class="r1">
            <td>ID Reserva</td>
            <td><input type="text" name="idReserva" id="idReserva" readonly="readonly" value="' . $idReserva . '"></td>
            </tr>
            <tr class="r0">
            <td>Cedula/Pasaporte</td>
            <td><input type="text" name="idPasajero" id="idPasajero"></td>
            </tr>
            <tr class="r1">
            <td colspan="2" align="center">
            <input name="button" type="button" id="button" value="BUSCAR PASAJERO" onclick= "xajax_buscarPasajero(xajax.getFormValues(\'formNuevoPasajero\'))">
            </td>
            </tr>
            </tbody>
            </table>
            </form>';
    return $contenido;
}

function generarFormularioAsignarPasajero2 ($datos) {
    $formulario = '<form id="formNuevoPasajero">
            <input type="hidden" name="idReserva" value="'.$datos[idReserva].'" />
            <input type="hidden" name="idVuelo" value="'.$datos[idVuelo].'" />
            <table class="formTable" cellspacing="0">
            <tr>
            <thead>
            <td colspan="2">
            <div class="tituloBlanco1">
            DATOS DEL PASAJERO
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_borrarFormPasajero()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
            </div>
            </div>
            </td>
            </thead>
            </tr>
            <tr class="r0">
            <td>Cedula</td>
            <td><label>
            <input type="text" name="cedula" id="cedula" value="'.$datos[cedula].'" readonly="readonly"/>
            </label></td>
            </tr>
            <tr class="r1">
            <td>Pasaporte</td>
            <td><label>
            <input type="text" name="pasaporte" id="pasaporte" value="'.$datos[pasaporte].'" readonly="readonly"/>
            </label></td>
            </tr>
            <tr class="r0">
            <td>Nombre</td>
            <td><label>
            <input type="text" name="nombre" id="nombre" value="'.$datos[nombre].'" readonly="readonly"/>
            </label></td>
            </tr>
            <tr class="r1">
            <td>Apellido</td>
            <td><label>
            <input type="text" name="apellido" id="apellido" value="'.$datos[apellido].'" readonly="readonly"/>
            </label></td>
            </tr>
            <tr class="r0">
            <td>Tipo de Pasajero</td>
            <td><input type="text" name="tipo" id="tipo" value="'.$datos[TIPO_PASAJERO_id].'" readonly="readonly"/>
            </td>
            </tr>
            <tr class="r1">
            <td colspan="2" align="center">
            <input name="button" type="button" id="button" value="VOLVER" onclick="xajax_desplegarFormularioAsignarPasajero('.$datos[idVuelo].','.$datos[idReserva].')" />
            <input name="button" type="button" id="button" value="ASIGNAR" onclick="xajax_asignarPasajero(xajax.getFormValues(\'formNuevoPasajero\'))" />
            </td>
            </tr>
            </table>
            </form>';
    return $formulario;
}

function generarFormularioCrearPasajero ($datos) {
    $formulario = '<form id="formNuevoPasajero">
            <input type="hidden" name="idReserva" value="'.$datos[idReserva].'" />
            <input type="hidden" name="idVuelo" value="'.$datos[idVuelo].'" />
            <table class="formTable" cellspacing="0">
            <tr>
            <thead>
            <td colspan="2">
            <div class="tituloBlanco1">
            DATOS DEL PASAJERO
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_borrarFormPasajero()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
            </div>
            </div>
            </td>
            </thead>
            </tr>
            <tr class="r0">
            <td colspan="2">Debe indicar la cedula o el pasaporte.<br>Los demas campos son obligatorios.</td>
            </tr>
            <tr class="r1">
            <td>Cedula</td>
            <td><label>
            <input type="text" name="cedula" id="cedula" value=""/>
            </label></td>
            </tr>
            <tr class="r0">
            <td>Pasaporte</td>
            <td><label>
            <input type="text" name="pasaporte" id="pasaporte" value=""/>
            </label></td>
            </tr>
            <tr class="r1">
            <td>Nombre</td>
            <td><label>
            <input type="text" name="nombre" id="nombre" value=""/>
            </label></td>
            </tr>
            <tr class="r0">
            <td>Apellido</td>
            <td><label>
            <input type="text" name="apellido" id="apellido" value=""/>
            </label></td>
            </tr>
            <tr class="r1">
            <td>Tipo de Pasajero</td>
            <td><select name="tipo">
            <option value="ADL">ADL</option>
            <option value="CHD">CHD</option>
            </select>
            </td>
            </tr>
            <tr class="r0">
            <td colspan="2" align="center">
            <input name="button" type="button" id="button" value="VOLVER" onclick="xajax_desplegarFormularioAsignarPasajero('.$datos[idVuelo].','.$datos[idReserva].')" />
            <input name="button" type="button" id="button" value="ASIGNAR PASAJERO" onclick="xajax_crearPasajero(xajax.getFormValues(\'formNuevoPasajero\'))" />
            </td>
            </tr>
            </table>
            </form>';
    return $formulario;
}

function generarObservaciones($idVuelo){
    $control = new controladorGestionVuelos();
    $obs = $control->obtenerObservacionesVuelo($idVuelo);
    $contenido = '<div align="center" class="nota">
                    <form id="formObservaciones">
                    <input type="hidden" name="idVuelo" value="'.$idVuelo.'" />
                    <table border="0">
                    <tr>
                    <td><div class="tituloNegro1">Notas</div></td>
                    </tr>
                    <tr>
                    <td><textarea class="nota" name="observaciones" rows="6" cols="40">'.$obs.'</textarea></td>
                    </tr>
                    <tr>
                    <td><input type="button" value="GUARDAR" onclick="xajax_guardarObservaciones(xajax.getFormValues(\'formObservaciones\'))"/></td>
                    </tr>
                    </table>
                    </form>
                  </div>';
    return $contenido;
}

function generarFormularioBoleto(){
    $contenido = '<form id="formGenerarBoleto">
            <table border="0">
            <tr>
            <td>Localizador</td>
            <td><input type="text" name="solicitud" value="" onkeyup="this.value=this.value.toUpperCase();"/></td>
            </tr>
            <tr>
            <td>&nbsp</td>
            <td>
            <input name="button" type="button" id="button" value="CONTINUAR" onclick="xajax_generarBoletoGui(xajax.getFormValues(\'formGenerarBoleto\'))" />
            </td>
            </tr>
            </table>
            </form>';
    return $contenido;
}

function generarPanelOperaciones(){
    $contenido = '<div class="panel">
                    <div class="tituloNegro2">OPERACIONES</div>
                    <hr width="98%" size="1" color="#067AC2">
                    <div class="tituloNegro1">CAMBIAR ESTADO DE LOCALIZADOR</div>
                    <div id="cambiarEstado" class="textoNegro1"></div>
                    <hr width="98%" size="1" color="#067AC2">
                    <div class="tituloNegro1">GENERAR BOLETO PARA UNA SOLICITUD</div>
                    <div id="generarBoleto"  class="textoNegro1"></div>
                </div>';
    return $contenido;
}

?>