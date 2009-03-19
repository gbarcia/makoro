<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionReservaFormularios.php';
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

function buscarClienteJuridico($rif){
    $control = new ControlReservaLogicaclass();
    return $control->existeClienteAgencia($rif);
}

function buscarClienteParticular($cedula){
    $control = new ControlReservaLogicaclass();
    return $control->existeClienteParticular($cedula);
}

function buscarCliente($datos){
    $seleccion = $datos[grupo];
    if ($seleccion == 'juridico'){
        if ((buscarClienteJuridico($datos[rif])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            return desplegarFormularioAgregarClienteJuridico($datos[rif]);
        }
    } else {
        if ((buscarClienteParticular($datos[cedula])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            //agregar Cliente Particular
        }
    }
}

function desplegarConfirmarReserva($datos){
    $respuesta = generarFormularioConfirmarReserva($datos);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("derecha", "innerHTML", $respuesta);
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
            1, 17706708, $clienteParticularCedula, $clienteAgenciaRif, $datos[posada], '', $datos[estado]);

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

?>