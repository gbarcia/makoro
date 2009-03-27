<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/eventos/GestionReservaFormularios.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlRutaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTipoServicioLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPosadaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorReservaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorGestionVuelos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPasajeroBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlReservaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorMonedaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPasajeroBD.class.php';
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

function generarComboBoxMoneda(){
    $combo = '<select name="moneda">';
    $controladorMoneda = new controladorMonedaBDclass();
    $recurso = $controladorMoneda->consultarMonedas();
    while ($row = mysql_fetch_array($recurso)){
        $combo.= '<option value="' . $row[id] .'">' . $row[tipo] . '</option>';
    }
    $combo.= '</select>';
    return $combo;
}

function validarFiltros($datos){
    foreach ($datos as $valor) {
        if (!empty($valor)) return true ;
    }
    return false;
}

function desplegarBusqueda($datos){
    $objResponse = new xajaxResponse();
    $flag = validarFiltros($datos);
    if ($flag){
        $resultado = procesarFiltros($datos);
        $objResponse->addAssign("vuelos", "innerHTML", $resultado);
    }else{
        $objResponse->addAlert("Para utilizar esta opcion, Ud. debe especificar algun filtro.");
    }
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
    $resultado.= '<th>&nbsp</th>';
    $resultado.= '<th>NUMERO</th>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>ORIGEN</th>';
    $resultado.= '<th>DESTINO</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>ADL/CHD DISPONIBLES</th>';
    $resultado.= '<th>INF DISPONIBLES</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $resultado.= '<tbody>';
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
        if ($_SESSION['EncargadoTipo'] == 'AG'){
            $resultado.= '<td><a onclick=""><img src="iconos/detalles_gris.png" alt="EDITAR NO DISPONIBLE"/></a></td>';
        } else if ($controlVuelo->esFechaValida($recursoDetalles->getFecha(), date("Y-m-d"), $recursoDetalles->getHora(), date("H:i:s"))){
            $resultado.= '<td><a onclick="xajax_desplegarDetalles(' . $idVuelo . ')"><img src="iconos/detalles.png" alt="EDITAR"/></a></td>';
        } else {
            $resultado.= '<td><a onclick="xajax_desplegarDetalles(' . $idVuelo . ')"><img src="iconos/detalles_rojo.png" alt="EDITAR"/></a></td>';
        }
        $resultado.= '<td>' . $idVuelo. '</td>';
        $resultado.= '<td>' . $recursoDetalles->getFecha(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getHora(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
        $resultado.= '<td>' . $cantidadDisponible. '</td>';
        $resultado.= '<td>' . $cantidadDisponibleInfantes. '</td>';
        $resultado.= '<td>' . $piloto. '</td>';
        $resultado.= '<td>' . $copiloto. '</td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</tbody>';
    $resultado.= '</table>';
    $resultado.= '</form>';
    if ($recursoDetalles == "") {
        $resultado = '<table class="scrollTable" cellspacing="0">';
        $resultado.= '<thead>';
        $resultado.= '<tr>';
        $resultado.= '<th>&nbsp</th>';
        $resultado.= '<th>NUMERO</th>';
        $resultado.= '<th>FECHA</th>';
        $resultado.= '<th>HORA</th>';
        $resultado.= '<th>ORIGEN</th>';
        $resultado.= '<th>DESTINO</th>';
        $resultado.= '<th>AVION</th>';
        $resultado.= '<th>ADL/CHD DISPONIBLES</th>';
        $resultado.= '<th>INF DISPONIBLES</th>';
        $resultado.= '<th>PILOTO</th>';
        $resultado.= '<th>COPILOTO</th>';
        $resultado.= '</tr>';
        $resultado.= '</thead>';
        $resultado.= '<tbody>';
        $resultado.= '<tr><td align="center" colspan="11">No hay coincidencias con su busqueda. Ud. puede intentarlo nuevamente, utilizando otros filtros.</td></tr>';
        $resultado.= '</tbody>';
        $resultado.= '</table>';
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
    $resultado.= '<th>&nbsp</th>';
    $resultado.= '<th>NUMERO</th>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>ORIGEN</th>';
    $resultado.= '<th>DESTINO</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>ADL/CHD DISPONIBLES</th>';
    $resultado.= '<th>INF DISPONIBLES</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $resultado.= '<tbody>';
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
        if ($_SESSION['EncargadoTipo'] != 'AG'){
            $resultado.= '<td><a onclick="xajax_desplegarDetalles(' . $idVuelo . ')"><img src="iconos/detalles.png" alt="EDITAR"/></a></td>';
        } else {
            $resultado.= '<td><a onclick=""><img src="iconos/detalles_gris.png" alt="EDITAR NO DIPONIBLE"/></a></td>';
        }
        $resultado.= '<td>' . $idVuelo. '</td>';
        $resultado.= '<td>' . $recursoDetalles->getFecha(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getHora(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioSalida(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getRutaSitioLLegada(). '</td>';
        $resultado.= '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
        $resultado.= '<td>' . $cantidadDisponible. '</td>';
        $resultado.= '<td>' . $cantidadDisponibleInfantes. '</td>';
        $resultado.= '<td>' . $piloto. '</td>';
        $resultado.= '<td>' . $copiloto. '</td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</tbody>';
    $resultado.= '</table>';
    $resultado.= '</form>';
    if ($recursoDetalles == "") {
        $resultado = '<table class="scrollTable" cellspacing="0">';
        $resultado.= '<thead>';
        $resultado.= '<tr>';
        $resultado.= '<th>&nbsp</th>';
        $resultado.= '<th>NUMERO</th>';
        $resultado.= '<th>FECHA</th>';
        $resultado.= '<th>HORA</th>';
        $resultado.= '<th>ORIGEN</th>';
        $resultado.= '<th>DESTINO</th>';
        $resultado.= '<th>AVION</th>';
        $resultado.= '<th>ADL/CHD DISPONIBLES</th>';
        $resultado.= '<th>INF DISPONIBLES</th>';
        $resultado.= '<th>PILOTO</th>';
        $resultado.= '<th>COPILOTO</th>';
        $resultado.= '</tr>';
        $resultado.= '</thead>';
        $resultado.= '<tbody>';
        $resultado.= '<tr><td align="center" colspan="11">No hay vuelos planificados para la fecha actual. (' . date("d-m-Y") .')</td></tr>';
        $resultado.= '</tbody>';
        $resultado.= '</table>';
    }
    return $resultado;
}

function desplegarDetalles($idVuelo){
    $objResponse = new xajaxResponse();
    $detalles = detalles($idVuelo);
    $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
    $fichaVuelo = generarFichaVuelo($idVuelo);
    $objResponse->addAssign("fichaVuelo", "innerHTML", $fichaVuelo);
    $observaciones = generarObservaciones($idVuelo);
    $objResponse->addAssign("observaciones", "innerHTML", $observaciones);

    $controlVuelo = new ControlVueloLogicaclass();
    $controlGestion = new controladorGestionVuelos();
    $datosVuelo = $controlGestion->ConsultarVueloPorId($idVuelo);
    $row = mysql_fetch_array($datosVuelo);
    if ($controlVuelo->esFechaValida($row[fecha], date("Y-m-d"), $row[hora], date("H:i:s"))){
        $formulario = generarFormularioNuevaReserva($idVuelo);
        $objResponse->addAssign("izquierda", "innerHTML", $formulario);
        $panel = generarPanelOperaciones();
        $objResponse->addAssign("panelOperaciones", "innerHTML", $panel);
        $respuesta = generarFormularioCambiarEstado($idVuelo);
        $objResponse->addAssign("cambiarEstado", "innerHTML", $respuesta);
        $generarBoleto = generarFormularioBoleto();
        $objResponse->addAssign("generarBoleto", "innerHTML", $generarBoleto);
    } else {
        $objResponse->addClear("izquierda", "innerHTML");
        $objResponse->addClear("panelOperaciones", "innerHTML");
        $objResponse->addClear("cambiarEstado", "innerHTML");
        $objResponse->addClear("generarBoleto", "innerHTML");
    }
    $objResponse->addClear("asignarPasajero", "innerHTML");
    return $objResponse;
}

function desplegarFormularioNuevaReserva($idVuelo){
    $objResponse = new xajaxResponse();
    $formulario = generarFormularioNuevaReserva($idVuelo);
    $objResponse->addAssign("izquierda", "innerHTML", $formulario);
    return $objResponse;
}

function generarFichaVuelo($idVuelo){
    $controlVuelo = new ControlVueloLogicaclass();
    $datos = $controlVuelo->consultarInformacionVuelo($idVuelo);
    $row = mysql_fetch_array($datos);
    $resultado = '<table class="fichaTable" cellspacing="0">
        <thead><td colspan="2">DATOS DEL VUELO</td></thead>
        <tbody>
        <tr class="r1">
        <td>NUMERO</td>
        <td>'.$idVuelo.'</td>
        </tr>
        <tr class="r0">
        <td>FECHA</td>
        <td>'.$row[fecha].'</td>
        </tr>
        <tr class="r1">
        <td>HORA</td>
        <td>'.$row[hora].'</td>
        </tr>
        <tr class="r0">
        <td>RUTA</td>
        <td>'.$row[sitioSalida].' - '.$row[sitioLlegada].'</td>
        </tr>
        <tr class="r1">
        <td>AVION</td>
        <td>'.$row[matricula].'</td>
        </tr>
        <tr class="r0">
        <td colspan="2">DISPONIBILIDAD</td>
        </tr>
        <tr class="r1">
        <td>ADL/CHD</td>
        <td>'.$row[adlChlQuedan].' asientos disponibles</td>
        </tr>
        <tr class="r0">
        <td>INF</td>
        <td>'.$row[infQuedan].' asientos disponibles</td>
        </tr>
        </tbody>
        </table>';
    return $resultado;
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
        if ($datos[rif] == ''){
            $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          c
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
            $objResponse = new xajaxResponse();
            $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
            return $objResponse;
        } else if ((buscarClienteJuridico($datos[rif])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            return desplegarFormularioAgregarClienteJuridico($datos);
        }
    } else if ($seleccion == 'particular') {
        if (($datos[cedula] == '') || (!is_numeric($datos[cedula]))){
            $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          Para realizar esta operacion, Ud. debe indicar la cedula del cliente con un valor numerico.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
            $objResponse = new xajaxResponse();
            $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
            return $objResponse;
        } else if ((buscarClienteParticular($datos[cedula])) != ""){
            return desplegarConfirmarReserva($datos);
        } else {
            return desplegarFormularioAgregarClienteParticular($datos);
        }
    }
}

function desplegarConfirmarReserva($datos){
    $respuesta = generarFormularioConfirmarReserva($datos);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izquierda", "innerHTML", $respuesta);
    return $objResponse;
}

function agregarReserva($datos){
    $controlReserva = new ControlReservaLogicaclass();
    $controlVuelo = new ControlVueloLogicaclass();
    $objResponse = new xajaxResponse();
    if ($datos[cantidadAdlChd] == ''){
        $datos[cantidadAdlChd] = 0;
    }
    if ($datos[cantidadInf] == ''){
        $datos[cantidadInf] = 0;
    }
    if ($controlVuelo->existeReservaVuelo($datos[idVuelo], $datos[solicitud])){
        $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          Ya existe una reserva con este localizador en este vuelo.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
        return $objResponse;
    }else if (($datos[solicitud]!='')&&($datos[tipoVuelo]=='ida')){
        $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          El localizador ya existe. Para modificarlo debe crear una nueva reserva.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
        return $objResponse;
    } else if ((int_ok($datos[cantidadAdlChd])) && (int_ok($datos[cantidadInf]))) {
        if (($datos[cantidadAdlChd] <= 0) && ($datos[cantidadInf] <= 0)) {
            $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          Para realizar esta operacion, Ud. debe indicar la cantidad de pasajeros a viajar.
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
            if (($_SESSION['EncargadoValido']) == false){
                $objResponse->addAlert("La sesion ha caducado.");
                $objResponse->addRedirect("PresentacionSalida.php");
                return $objResponse;
            }
            $respuesta = $controlReserva->crearReserva($datos[tipoVuelo], $datos[idVuelo], $datos[cantidadAdlChd],
                $datos[cantidadInf], date("Y") . "-" . date("m") . '-' . date('d'), $datos[servicio],
                $_SESSION['EncargadoSucursal'], $_SESSION['EncargadoCedula'], $clienteParticularCedula, $clienteAgenciaRif, $datos[posada], $datos[solicitud], $datos[estado]);

            if ($respuesta != ''){
                $mensaje = '<div class="exito">
                          <div class="textoMensaje">
                          Se realizo la reserva satisfactoriamente. Cliente: '.$datos[nombre].'. Localizador: '. $respuesta .'. Cantidad ADL/CHD: '.$datos[cantidadAdlChd].'. Cantidad INF: '.$datos[cantidadInf].'.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
                $fichaVuelo = generarFichaVuelo($datos[idVuelo]);
                $objResponse->addAssign("fichaVuelo", "innerHTML", $fichaVuelo);
                $detalles = detalles($datos[idVuelo]);
                $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
            } else {
                $mensaje = '<div class="error">
                          <div class="textoMensaje">
                          No se pudo realizar la reserva. Verifique la disponibilidad de asientos y/o concordancia de reservas de salida y retorno.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
            }
            $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
            return $objResponse;
        }
    } else {
        $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          Para realizar esta operacion, Ud. debe indicar la cantidad de pasajeros a viajar con valores enteros.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAppend("mensaje", "innerHTML", $mensaje);
        return $objResponse;
    }
}

function borrarMensaje(){
    $objResponse = new xajaxResponse();
    $objResponse->addClear("mensaje", "innerHTML");
    return $objResponse;
}

function borrarFormPasajero(){
    $objResponse = new xajaxResponse();
    $objResponse->addClear("asignarPasajero", "innerHTML");
    return $objResponse;
}

function desplegarFormularioAgregarClienteJuridico($rif){
    $respuesta = generarFormularioAgregarClienteJuridico($rif);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izquierda", "innerHTML", $respuesta);
    return $objResponse;
}

function desplegarFormularioAgregarClienteParticular($cedula){
    $respuesta = generarFormularioAgregarClienteParticular($cedula);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("izquierda", "innerHTML", $respuesta);
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
            $objResponse->addAssign("izquierda", "innerHTML", $form);
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          Verifique el manual del usuario. Error PA'.$resultado.'.
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
        $resultado = $control->nuevoClienteParticular($datos[cedula], $datos[nombre], $datos[apellido], 'M', '0000-00-00', $datos[telefono], '', '', '');
        if ($resultado) {
            $respuesta .= '<div class="exito">
                          <div class="textoMensaje">
                          Cliente '.$datos[nombre] .' '. $datos[apellido]. ' agregado con exito.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
            $form = generarFormularioConfirmarReserva($datos);
            $objResponse->addAssign("izquierda", "innerHTML", $form);
        }
        else {
            $respuesta .= '<div class="error">
                          <div class="textoMensaje">
                          Verifique el manual del usuario. Error PC'.$resultado.'.
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

function validarPersona ($datos) {
    $resultado = false;
    if (is_numeric($datos[cedula]) && $datos[cedula] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[nombre]) && $datos[nombre] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[apellido]) && $datos[apellido] != "")
    $resultado = true;
    else return false;
    if (is_string($datos[telefono]) && $datos[telefono] != "")
    $resultado = true;
    else return false;
    return $resultado;
}

function int_ok($val){
    return ($val !== true) && ((string)(int) $val) === ((string) $val);
}

function buscarSolicitud($datos){
    $solicitud = $datos[solicitud];
    $control = new controladorReservaBDclass();
    $recurso = $control->consultarClienteReserva($solicitud);
    if (mysql_num_rows($recurso) > 0){
        $row = mysql_fetch_array($recurso);
        $row["idVuelo"] = $datos[idVuelo];
        $row["solicitud"] = $datos[solicitud];
        return buscarCliente($row);
    } else {
        $objResponse = new xajaxResponse();
        $respuesta ='<div class="error">
                          <div class="textoMensaje">
                          El localizador '.$solicitud.' no se ha encontrando. Por favor, verifiquelo e intentelo nuevamente.
                          </div>
                          <div class="botonCerrar">
                          <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
        return $objResponse;
    }
}

function desplegarFormularioCambiarEstado($idVuelo){
    $objResponse = new xajaxResponse();
    $respuesta = generarFormularioCambiarEstado($idVuelo);
    $objResponse->addAssign("cambiarEstado", "innerHTML", $respuesta);
    return $objResponse;
}

function desplegarFormularioCambiarEstado2($datos){
    $objResponse = new xajaxResponse();
    $respuesta = generarFormularioCambiarEstado2($datos);
    $objResponse->addAssign("cambiarEstado", "innerHTML", $respuesta);
    return $objResponse;
}

function cambiarEstado($datos){
    if ($datos[solicitud] == ''){
        $respuesta ='<div class="advertencia">
                            <div class="textoMensaje">
                            Para realizar esta operacion, Ud. debe indicar el localizador a editar.
                        </div>
                        <div class="botonCerrar">
                        <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                        </div>
                        </div>';
        $objResponse = new xajaxResponse();
        $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
        return $objResponse;
    } else if ($datos[estado] == 'PA'){
        return desplegarFormularioCambiarEstado2($datos);
    } else {
        $controlReserva = new ControlReservaLogicaclass();
        $resultado = $controlReserva->actualizarEstadoReserva($datos[solicitud], $datos[estado], '', '', '', '', '');

        if (($resultado == 1) || ($resultado == 2) || ($resultado == 3)){
            $respuesta ='<div class="exito">
                            <div class="textoMensaje">
                            Las reservas del localizador '.$datos[solicitud].' fueron cambiadas de estado exitosamente. Estado original: PP. Estado Actual: '.$datos[estado].'
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else if ($resultado == 4){
            $respuesta ='<div class="advertencia">
                            <div class="textoMensaje">
                            Las reservas del localizador '.$datos[solicitud].' ya se encuentran PAGADAS actualmente.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else if (($resultado == 5) || ($resultado == 6)){
            $respuesta ='<div class="exito">
                            <div class="textoMensaje">
                            Las reservas del localizador '.$datos[solicitud].' fueron cambiadas de estado exitosamente. Estado original: CO. Estado Actual: '.$datos[estado].'
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else if ($resultado == 7){
            $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            Las reservas del localizador'.$datos[solicitud].' se encuentran CONFIRMADAS. Este estado no puede ser alterado.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else if ($resultado == 17){
            $respuesta ='<div class="advertencia">
                            <div class="textoMensaje">
                            Las reservas del localizador '.$datos[solicitud].' ya se encuentra CONFIRMADAS actualmente.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else if (($resultado == 9) || ($resultado == 10) || ($resultado == 12)){
            $respuesta ='<div class="advertencia">
            <div class="textoMensaje">
            Las reservas del localizador'.$datos[solicitud].' se encuentran PAGADAS. Este estado no puede ser alterado.
            </div>
            <div class="botonCerrar">
            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
            </div>
            </div>';
        } else if ($resultado == 11){
            $respuesta ='<div class="advertencia">
            <div class="textoMensaje">
            Las reservas del localizador'.$datos[solicitud].' se han ANULADO. Recuerde que se debe hacer la devolucion pertinente al cliente involucarado.
            </div>
            <div class="botonCerrar">
            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
            </div>
            </div>';
        } else if(($resultado == 13) || ($resultado == 14) || ($resultado == 15) || ($resultado == 16)){
            $respuesta ='<div class="error">
            <div class="textoMensaje">
            Las reservas del localizador '.$datos[solicitud].' se encuentran CANCELADAS. Este estado no puede ser alterado.
            </div>
            <div class="botonCerrar">
            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
            </div>
            </div>';
        } else if ($resultado == 8){
            $respuesta ='<div class="error">
            <div class="textoMensaje">
            No se encontro la solicitud '.$datos[solicitud].'. Por favor, verifiquelo e intentelo de nuevo.
            </div>
            <div class="botonCerrar">
            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
            </div>
            </div>';
        } else {
            $respuesta ='<div class="error">
            <div class="textoMensaje">
            Verifique el manual de usuario. Error CEME'.$resultado.'.
            </div>
            <div class="botonCerrar">
            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
            </div>
            </div>';
        }

        $objResponse = new xajaxResponse();
        $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
        $detalles = detalles($datos[idVuelo]);
        $fichaVuelo = generarFichaVuelo($datos[idVuelo]);
        $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
        $objResponse->addAssign("fichaVuelo", "innerHTML", $fichaVuelo);
        return $objResponse;
    }
}

function procesarPago($datos){
    if (($datos[tipoPago] != 'EF') && (($datos[banco] == '') || ($datos[transaccion] == ''))) {
        $respuesta ='<div class="advertencia">
            <div class="textoMensaje">
            Debe indicar el banco y numero de la transaccion para operaciones bancarias. Tipo de pago: '. $datos[tipoPago] .'.
            </div>
            <div class="botonCerrar">
            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
            </div>
            </div>';
    } else if (($datos[tipoPago] == 'EF') && (($datos[banco] != '') || ($datos[transaccion] != ''))) {
        $respuesta ='<div class="advertencia">
            <div class="textoMensaje">
            Si el pago se realizo en efectivo, Ud. no debe indicar el banco y/o numero de la transaccion para operaciones bancarias. Tipo de pago: '. $datos[tipoPago] .'.
            </div>
            <div class="botonCerrar">
            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
            </div>
            </div>';
    } else {
        $controlReserva = new ControlReservaLogicaclass();
        $resultado = $controlReserva->actualizarEstadoReserva($datos[solicitud], $datos[estado], $datos[tipoPago], 0, $datos[banco], $datos[transaccion], 1);
        if (($resultado == 2) || ($resultado == 5)){
            $respuesta ='<div class="exito">
                            <div class="textoMensaje">
                            Se registro el pago para las reservas del localizador '.$datos[solicitud].'
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else if ($resultado == 12){
            $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            Las reserva de la solicitud '.$datos[solicitud].' ya esta PAGADAS.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else if ($resultado == 15){
            $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            Las reservas de la solicitud '.$datos[solicitud].' estan ANULADAS. Este estado no puede ser alterado.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else {
            $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            Verifique el manual de usuario. Error PPME'.$resultado.'.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        }
    }
    $objResponse = new xajaxResponse();
    $detalles = detalles($datos[idVuelo]);
    $fichaVuelo = generarFichaVuelo($datos[idVuelo]);
    $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
    $objResponse->addAssign("fichaVuelo", "innerHTML", $fichaVuelo);
    $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function desplegarFormularioAsignarPasajero($idVuelo, $idReserva){
    $respuesta = generarFormularioAsignarPasajero($idVuelo, $idReserva);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("asignarPasajero", "innerHTML", $respuesta);
    return $objResponse;
}

function desplegarObservaciones($idVuelo){
    $respuesta = generarObservaciones($idVuelo);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("observaciones", "innerHTML", $respuesta);
    return $objResponse;
}

function guardarObservaciones($datos){
    $observaciones = $datos[observaciones];
    $idVuelo = $datos[idVuelo];
    $controlVuelo = new controladorGestionVuelos();
    $resultado = $controlVuelo->actualizarObservacionesVuelo($observaciones, $idVuelo);
    if ($resultado){
        $respuesta ='<div class="exito">
                            <div class="textoMensaje">
                            Las notas han sido actualizadas con exito.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
    } else {
        $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            Error guardando las notas. Intentelo de nuevo.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
    }
    $objResponse = new xajaxResponse();
    $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function buscarPasajero($datos){
    $id = $datos[idPasajero];
    $controlPasajero = new controladorPasajeroBDclass();
    $recurso = $controlPasajero->consultarPasajeroPorId($id);
    $row = mysql_fetch_array($recurso);
    $row["idReserva"] = $datos[idReserva];
    $row["idVuelo"] = $datos[idVuelo];

    if(is_numeric($id)){
        $row["cedula"] = $id;
        $row["pasaporte"] = '';
    } else {
        $row["cedula"] = '';
        $row["pasaporte"] = $id;
    }

    if (mysql_num_rows($recurso) <= 0){
        return desplegarFormularioCrearPasajero($row);
    } else {
        return desplegarFormularioAsignarPasajero2($row);
    }
}

function desplegarFormularioAsignarPasajero2($datos){
    $respuesta = generarFormularioAsignarPasajero2($datos);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("asignarPasajero", "innerHTML", $respuesta);
    return $objResponse;
}

function desplegarFormularioCrearPasajero($datos){
    $respuesta = generarFormularioCrearPasajero($datos);
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("asignarPasajero", "innerHTML", $respuesta);
    return $objResponse;
}

function asignarPasajero($datos){
    $control = new ControlReservaLogicaclass();
    $resultado = $control->actualizarPasajeroReserva($datos[idVuelo],'', '', '', $datos[cedula], $datos[pasaporte], '', '', $datos[idReserva]);
    if ($resultado){
        $respuesta ='<div class="exito">
                            <div class="textoMensaje">
                            El pasajero ha sido asignado a la reserva '.$datos[idReserva].'.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
    } else {
        $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            Error al asignar el pasajero a la reserva. Verifique que el pasajero no este registrado en el vuelo.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
    }
    $objResponse = new xajaxResponse();
    $detalles = detalles($datos[idVuelo]);
    $fichaVuelo = generarFichaVuelo($datos[idVuelo]);
    $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
    $objResponse->addAssign("fichaVuelo", "innerHTML", $fichaVuelo);
    $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function crearPasajero($datos){
    $control = new ControlReservaLogicaclass();
    $controlVuelo = new controladorPasajeroBDclass();
    if ($datos[cedula] != ''){
        $id = $datos[cedula];
        $recurso = $controlVuelo->consultarPasajeroPorId($id);
    } else if ($datos[pasaporte] != ''){
        $id = $datos[pasaporte];
        $recurso = $controlVuelo->consultarPasajeroPorId($id);
    }
    if ($control->existePasajero($datos[cedula], $datos[pasaporte]) != ''){
        $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            El pasajero ya se encuentra registrado el el sistema.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
    } else {
        $resultado = $control->actualizarPasajeroReserva($datos[idVuelo], $datos[nombre], $datos[apellido], 'M', $datos[cedula], $datos[pasaporte], '', $datos[tipo], $datos[idReserva]);
        if ($resultado){
            $respuesta ='<div class="exito">
                            <div class="textoMensaje">
                            El pasajero ha sido asignado a la reserva '.$datos[idReserva].'.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        } else {
            $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            Error al asignar el pasajero a la reserva. Error CP'.$resultado.'.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        }
    }
    $objResponse = new xajaxResponse();
    $detalles = detalles($datos[idVuelo]);
    $fichaVuelo = generarFichaVuelo($datos[idVuelo]);
    $objResponse->addAssign("pasajeros", "innerHTML", $detalles);
    $objResponse->addAssign("fichaVuelo", "innerHTML", $fichaVuelo);
    $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function generarBoletoGui($datos){
    $valido = false;
    $control = new controladorBoletoBDclass();
    $valido = $control->validoBoleto($datos[solicitud]);
    $objResponse = new xajaxResponse();
    if ($valido) {
        $url = "boleto.php?nsolicitud=" . $datos[solicitud];
        $objResponse->addScript('window.open("'.$url.'", "Boleto", "resizable=1, scrollbars=1, width=640, height=480")');
    } else {
        $respuesta ='<div class="error">
                            <div class="textoMensaje">
                            El boleto no ha podido ser generado. Verifique que las reservas esten pagas y/o que los pasajeros esten asignados.
                            </div>
                            <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                            </div>
                            </div>';
        $objResponse->addAppend("mensaje", "innerHTML", $respuesta);
    }
    return $objResponse;
}
?>