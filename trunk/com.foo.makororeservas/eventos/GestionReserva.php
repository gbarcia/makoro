<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlRutaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTipoServicioLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPosadaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlReservaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';

/**
 * Funcion que genera el Combo Box con las rutas de los vuelos
 * @return <xajaxResponse> Respuesta xajax
 */
function generarComboBoxLugar(){
    $objResponse = new xajaxResponse();
    $combo = '<select name="ruta"><option value="">TODAS</option>';
    $controladorRutas = new ControlRutaLogicaclass();
    $recurso = $controladorRutas->consultarTodasLasRutas();
    foreach ($recurso as $row) {
        $combo.= '<option value="' . $row->getSitioSalida() .'-'. $row->getSitioLlegada() . '">'
        . $row->getAbreviaturaSalida() .' - '. $row->getAbreviaturaLlegada() . '</option>';
    }
    $combo.= '</select>';
    $objResponse->addAssign("comboBoxRuta", "innerHTML", "$combo");
    return $objResponse;
}

function generarComboBoxServicio(){
    $combo = '<select name="servicio">';
    $controladorServicio = new ControlTipoServicioLogicaclass();
    $recurso = $controladorServicio->consultarServicios();
    while ($row = mysql_fetch_array($recurso)) {
        $combo.= '<option value="' . $row[id] .'">' . $row[nombre] . '</option>';
    }
    $combo.= '</select>';
    return $combo;
}

function generarComboBoxPosada(){
    $combo = '<select name="posada">';
    $controladorPosada = new controladorPosadaBDclass();
    $recurso = $controladorPosada->consultarPosadas();
    while ($row = mysql_fetch_array($recurso)){
        $combo.= '<option value="' . $row[id] .'">' . $row[nombrePosada] . '</option>';
    }
    $combo.= '</select>';
    return $combo;
}

function desplegarBusqueda($datos){
    $objResponse = new xajaxResponse();
    $resultado = procesarFiltros($datos);
    $objResponse->addAssign("vuelos", "innerHTML", $resultado);
    return $objResponse;
}

/**
 * Procesa la busqueda de vuelos dependidon del formulario
 * @param <coleccion> $datos los datos del formulario
 * @return <xajaxResponse> Respuesta xajax
 */
function procesarFiltros($datos){
    $arregloRuta = split("-", $datos[ruta]);
    if ($datos[disponibilidad] == ""){
        $capacidad = 0;
    } else {
        $capacidad = $datos[disponibilidad];
    }
    if ($datos[disponibilidadInfantes] == ""){
        $capacidadInfantes = 0;
    } else {
        $capacidadInfantes = $datos[disponibilidad];
    }
    $controlVuelo = new ControlVueloLogicaclass();
    $coleccionVuelo = $controlVuelo->vueloEspecificoConFiltro($datos[fechaInicio],
        $datos[fechaFin], '', '', $arregloRuta[0], $arregloRuta[1], $capacidad, 0,
        $datos[cedulaPasaportePasajero], $datos[nombrePasajero], $datos[apellidoPasajero],
        $datos[cedulaCliente], $datos[nombreParticular], $datos[apellidoParticular],
        $datos[rifCliente], $datos[nombreAgencia], $datos[solicitud], $datos[estado]);
    $resultado = "";
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>ORIGEN</th>';
    $resultado.= '<th>DESTINO</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>ADL/CHD DISPONIBLES</th>';
    $resultado.= '<th>INF DISPONIBLES</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>EDITAR</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    foreach ($coleccionVuelo as $var) {
        $recursoDetalles = $var->getColeccionVuelo();
        $cantidadDisponible = $var->getAsientosDisponibles();
        $cantidadDisponibleInfantes = $var->getCantinfantesquedan();
        $piloto = $var->getPiloto();
        $copiloto = $var->getCopiloto();
        $disponibilidadaAdulto = $var->getDisponibilidadadulto();
        $disponibilidadaInfante = $var->getDisponibilidadinfante();
        $idVuelo = $var->getIdvuelo();
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $recursoDetalles->getFecha(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getHora(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
        $resultado.= '<td>' . $cantidadDisponible. '</td>';
        $resultado.= '<td>' . $cantidadDisponibleInfantes. '</td>';
        $resultado.= '<td>' . $piloto. '</td>';
        $resultado.= '<td>' . $copiloto. '</td>';
        $resultado.= '<td><input type="button" value="DETALLES" onclick="xajax_desplegarDetalles(' . $idVuelo . ')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    if ($recursoDetalles == "") {
        $resultado = 'No hay coincidencias con su busqueda.';
    }
    return $resultado;
}

function desplegarInicio(){
    $objResponse = new xajaxResponse();
    $resultado = inicio();
    $objResponse->addAssign("vuelos", "innerHTML", "$resultado");
    return $objResponse;
}

function inicio(){
    $controlVuelo = new ControlVueloLogicaclass();
    $coleccionVuelo = $controlVuelo->vueloEspecificoSinFiltro(date("Y")."-".date("m").'-'.date('d'),
        date("Y")."-".date("m").'-'.date('d'));
    $resultado = "";
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>ORIGEN</th>';
    $resultado.= '<th>DESTINO</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>ADL/CHD DISPONIBLES</th>';
    $resultado.= '<th>INF DISPONIBLES</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>DETALLES</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    foreach ($coleccionVuelo as $var) {
        $recursoDetalles = $var->getColeccionVuelo();
        $cantidadDisponible = $var->getAsientosDisponibles();
        $cantidadDisponibleInfantes = $var->getCantinfantesquedan();
        $piloto = $var->getPiloto();
        $copiloto = $var->getCopiloto();
        $disponibilidadaAdulto = $var->getDisponibilidadadulto();
        $disponibilidadaInfante = $var->getDisponibilidadinfante();
        $idVuelo = $var->getIdvuelo();
        if ($color){
            $resultado.= '<tr class="r0">';
        } else {
            $resultado.= '<tr class="r1">';
        }
        $resultado.= '<td>' . $recursoDetalles->getFecha(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getHora(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
        $resultado.= '<td>' . $cantidadDisponible. '</td>';
        $resultado.= '<td>' . $cantidadDisponibleInfantes. '</td>';
        $resultado.= '<td>' . $piloto. '</td>';
        $resultado.= '<td>' . $copiloto. '</td>';
        $resultado.= '<td><input type="button" value="DETALLES" onclick="desplegarDetalles(' . $idVuelo . ')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    if ($recursoDetalles == "") {
        $resultado = 'No hay vuelos planificados para hoy (' . date("d") . "-" .
        date("m") . '-' . date('Y') . ')';
    }
    return $resultado;
}

function desplegarDetalles($idVuelo){
    $objResponse = new xajaxResponse();
    $detalles = detalles($idVuelo);
    $formulario = generarFormularioNuevaReserva($idVuelo);
    $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
    $objResponse->addAssign("izquierda", "innerHTML", $formulario);
    return $objResponse;
}

/**
 * Muestra los pasajeros y sus detalles de un vuelo
 * @param <int> $idVuelo
 * @return <xajaxResponse> Respuesta xajax
 */
function detalles($idVuelo){
    $controlVuelo = new ControlVueloLogicaclass();
    $recurso = $controlVuelo->consultarVuelosDetalles($idVuelo);
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>SOLICITUD</th>';
    $resultado.= '<th>CI/PASAPORTE</th>';
    $resultado.= '<th>NOMBRE</th>';
    $resultado.= '<th>TIPO</th>';
    $resultado.= '<th>SERVICIO</th>';
    $resultado.= '<th>POSADA</th>';
    $resultado.= '<th>VENDEDOR</th>';
    $resultado.= '<th>SUCURSAL</th>';
    $resultado.= '<th>RETORNO</th>';
    $resultado.= '<th>NOMBRE CLIENTE</th>';
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
        $resultado.= '<td>' . $row[solicitud] . '</td>';
        $resultado.= '<td>' . $row[cedulaPasaporte] . '</td>';
        $resultado.= '<td>' . $row[pasajero] . '</td>';
        $resultado.= '<td>' . $row[tipoPasajero] . '</td>';
        $resultado.= '<td>' . $row[servicio] . '</td>';
        $resultado.= '<td>' . $row[posada] . '</td>';
        $resultado.= '<td>' . $row[encargadoNombre] . '</td>';
        $resultado.= '<td>' . $row[sucursal] . '</td>';
        $resultado.= '<td>' . $row[vueloRetorno] . '</td>';
        $resultado.= '<td>' . $row[clienteNombre] . '</td>';
        $resultado.= '</tr>';
    }
    return $resultado;
}

/**
 * Genera el codigo html del formulario de una nueva reserva
 * @param <int> $idVuelo el id del vuelo al que agregaremos la reserva
 * @return <String> html del formulario
 */
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
    </form>';
    return $contenido;
}

function buscarClienteJuridico($rif){
    $control = new ControlReservaLogicaclass();
    return $control->existeClienteAgencia($rif);
}

function buscarClienteParticular($cedula){
    $control = new ControlReservaLogicaclass();
    return $control->existeClienteParticular($cedula);
}

/**
 * Busca el nombre de un cliente, dependiendo de su tipo
 * @param <form> $datos Formulario
 * @return <xajaxResponse> Respuesta xajax
 */
function buscarCliente($datos){
    $seleccion = $datos[grupo];
    if ($seleccion == 'juridico'){
        if ((buscarClienteJuridico($datos[rif])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            //agregar Cliente Juridico
        }
    } else {
        if ((buscarClienteParticular($datos[cedula])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            //agregar Cliente Particular
        }
    }
}

/**
 * Despliega el formulario de confirmar reserva
 * @param <form> $datos el formulario anterior
 * @return <xajaxResponse> Respuesta xajax
 */
function desplegarConfirmarReserva($datos){
    $respuesta = generarFormularioConfirmarReserva($datos);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", $respuesta);
    return $objResponse;
}

/**
 * Genera el codigo html del formulario de confirmar reserva
 * @param <form> $datos formulario anterior
 * @return <String> html del formulario
 */
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
            <td>Cantidad ADL/CHD</td>
            <td><input type="text" name="cantidadAdlChd" value="" /></td>
        </tr>
        <tr class="r1">
            <td>Cantidad INF</td>
            <td><input type="text" name="cantidadInf" value="" /></td>
        </tr>
        <tr class="r0">
            <td>Servicio</td>
            <td>' . generarComboBoxServicio() . '</td>
        </tr>
        <tr class="r1">
            <td>Posada</td>
            <td>' . generarComboBoxPosada() . '</td>
        </tr>
        <tr class="r0">
            <td colspan="2" align="center">
                <input name="button" type="button" id="button" value="AGREGAR RESERVA" onclick= "xajax_agregarReserva(xajax.getFormValues(\'formConfirmarReserva\'))">
            </td>
        </tr>
    </table>
    </form>';
    return $contenido;
}

function agregarReserva($datos){
    $controlReserva = new ControlReservaLogicaclass();

    if ($datos[tipoCliente] == 'juridico'){
        $clienteAgenciaRif = $datos[idCliente];
    } else {
        $clienteParticularCedula = $datos[idCliente];
    }

    $respuesta = $controlReserva->crearReserva($datos[idVuelo], $datos[cantidadAdlChd],
        $datos[cantidadInf], date("Y") . "-" . date("m") . '-' . date('d'), $datos[servicio],
        1, 17706708, $clienteParticularCedula, $clienteAgenciaRif, $datos[posada], '');

    if ($respuesta){
        $mensaje = '<div class="exito">
                          <div class="textoMensaje">
                          Se realizo la reserva satisfactoriamente.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    } else {
        $mensaje = '<div class="error">
                          <div class="textoMensaje">
                          No se pudo realizar la reserva.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("mensaje", "innerHTML", $mensaje);
    return $objResponse;
}

?>