<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionReservaFormularios.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlRutaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTipoServicioLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPosadaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorGestionVuelos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlReservaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlClienteParticularLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlClienteAgenciaLogica.class.php';

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
    $combo = '<select name="posada"><option value="">NINGUNA</option>';
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
    $fichaVuelo = generarFichaVuelo($idVuelo);
    $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
    $objResponse->addAssign("izquierda", "innerHTML", $formulario);
    $objResponse->addAssign("fichaVuelo", "innerHTML", $fichaVuelo);
    return $objResponse;
}

function generarFichaVuelo($idVuelo){
    $controlVuelo = new controladorGestionVuelos();
    $datos = $controlVuelo->ConsultarVueloPorId($idVuelo);
    $row = mysql_fetch_array($datos);
    $resultado = '<table class="fichaTable" cellspacing="0">
        <thead><td colspan="2">DATOS DEL VUELO</td></thead>
        <tr class="r1">
        <td>FECHA</td>
        <td>'.$row[fecha].'</td>
        </tr>
        <tr class="r0">
        <td>HORA</td>
        <td>'.$row[hora].'</td>
        </tr>
        <tr class="r1">
        <td>RUTA</td>
        <td>'.$row[salida].' - '.$row[llegada].'</td>
        </tr>
        <tr class="r0">
        <td>AVION</td>
        <td>'.$row[matricula].'</td>
        </tr>
        </table>';
    return $resultado;
}

function buscarClienteJuridico($rif){
    $control = new ControlReservaLogicaclass();
    return $control->existeClienteAgencia($rif);
}

function buscarClienteParticular($cedula){
    $control = new ControlReservaLogicaclass();return desplegarConfirmarReserva($datos);
    return $control->existeClienteParticular($cedula);
}

function buscarCliente($datos){
    $seleccion = $datos[grupo];
    if ($seleccion == 'juridico'){
        if ((buscarClienteJuridico($datos[rif])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            return desplegarFormularioAgregarClienteJuridico($datos);
        }
    } else {
        if ((buscarClienteParticular($datos[cedula])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            return desplegarFormularioAgregarClienteParticular($datos[cedula]);
        }
    }
}

function desplegarConfirmarReserva($datos){
    $respuesta = generarFormularioConfirmarReserva($datos);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("tres", "innerHTML", $respuesta);
    return $objResponse;
}

function agregarReserva($datos){
    $controlReserva = new ControlReservaLogicaclass();
    $objResponse = new xajaxResponse();

    if ($datos[cantidadAdlChd] == ''){
        $datos[cantidadAdlChd] = 0;
    }
    if ($datos[cantidadInf] == ''){
        $datos[cantidadInf] = 0;
    }

    if (($datos[cantidadAdlChd] == '') && ($datos[cantidadInf] == '')) {
        $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          Debe indicar la cantidad de pasajeros.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
        return $objResponse;
    } else {
        if ($datos[tipoCliente] == 'juridico'){
            $clienteAgenciaRif = $datos[idCliente];
        } else {
            $clienteParticularCedula = $datos[idCliente];
        }

        $respuesta = $controlReserva->crearReserva($datos[idVuelo], $datos[cantidadAdlChd],
            $datos[cantidadInf], date("Y") . "-" . date("m") . '-' . date('d'), $datos[servicio],
            $_SESSION['EncargadoSucursal'], $_SESSION['EncargadoCedula'], $clienteParticularCedula, $clienteAgenciaRif, $datos[posada], '', $datos[estado]);

        if ($respuesta != ''){
            $mensaje = '<div class="exito">
                          <div class="textoMensaje">
                          Se realizo la reserva satisfactoriamente. Localizador: '. $respuesta .'
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
        $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
        return $objResponse;
    }
}

function borrarMensaje(){
    $objResponse = new xajaxResponse();
    $objResponse->addClear("mensaje", "innerHTML");
    return $objResponse;
}

function desplegarFormularioAgregarClienteJuridico($rif){
    $respuesta = generarFormularioAgregarClienteJuridico($rif);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", $respuesta);
    return $objResponse;
}

function desplegarFormularioAgregarClienteParticular($cedula){
    $respuesta = generarFormularioAgregarClienteParticular($cedula);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", $respuesta);
    return $objResponse;
}

function procesarAgencia($datos) {
    $objResponse = new xajaxResponse();
    $repuesta = "";
    if (validarAgencia($datos)) {
        $control = new ControlClienteAgenciaLogicaclass();
        $resultado = $control->nuevoClienteAgencia($datos[rif], $datos[nombre], $datos[telefono], '', '', '', 0);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Agencia '.$datos[nombre]. ' agregada con exito.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
            $form = generarFormularioConfirmarReserva($datos);
            $objResponse->addAssign("derecha", "innerHTML", $form);
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique el manual del usuario.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
    }
    else {
        $respuesta ='<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique que el formulario se ha llenado correctamente.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function procesarCliente($datos) {
    $repuesta = "";
    $objResponse = new xajaxResponse();
    if (validarPersona($datos)) {
        $control = new ControlClienteParticularLogicaclass();
        $resultado = $control->nuevoClienteParticular($datos[cedula], $datos[nombre], $datos[apellido], 'M', '0000-00-00', $datos[telefono], $datos[estado], $datos[ciudad], $datos[direccion]);
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Cliente '.$datos[nombre] .' '. $datos[apellido]. ' agregado con exito.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. Verifique el manual del usuario.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        }
    }
    else {
        $respuesta ='<div class="advertencia">
                          <div class="textoMensaje">
                          No se pudo completar la operacion. El formulario no es correcro. CODIGO GCPF001.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function validarAgencia ($datos) {
    $resultado = false;
    if (is_string($datos[rif]) && $datos[rif] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[nombre]) && $datos[nombre] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[telefono]) && $datos[telefono] != "")
    $resultado = true;
    else return false;
    return $resultado;
}


?>