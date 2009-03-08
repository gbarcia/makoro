<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlRutaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorRutaBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSucursalLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSucursalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlVueloLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';

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

function procesarFiltros($datos){
    $arregloRuta = split("-", $datos[ruta]);
    if ($datos[disponibilidad] == ""){
        $capacidad = 0;
    } else {
        $capacidad = $datos[disponibilidad];
    }
    $controlVuelo = new ControlVueloLogicaclass();
    $coleccionVuelo = $controlVuelo->vueloEspecificoConFiltro($datos[fechaInicio],
        $datos[fechaFin], '', '', $arregloRuta[0], $arregloRuta[1], $capacidad,
        $datos[cedulaPasaportePasajero], $datos[nombrePasajero], $datos[apellidoPasajero],
        $datos[cedulaCliente], $datos[nombreParticular], $datos[apellidoParticular],
        $datos[rifCliente], $datos[nombreAgencia], $datos[solicitud], $datos[estado]);
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>ORIGEN</th>';
    $resultado.= '<th>DESTINO</th>';
    $resultado.= '<th>ASIENTOS DISPONIBLES</th>';
    $resultado.= '<th>DISPONIBILIDAD</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>DETALLES</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    foreach ($coleccionVuelo as $var) {
        $recursoDetalles = $var->getColeccionVuelo();
        $cantidadDisponible = $var->getAsientosDisponibles();
        $piloto = $var->getPiloto();
        $copiloto = $var->getCopiloto();
        $disponibilidad = $var->getDisponibilidad();
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
        $resultado.= '<td>' . $cantidadDisponible. '</td>';
        $resultado.= '<td>' . $disponibilidad. '</td>';
        $resultado.= '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
        $resultado.= '<td>' . $piloto. '</td>';
        $resultado.= '<td>' . $copiloto. '</td>';
        $resultado.= '<td><input type="button" value="VER" onclick="xajax_verDetalles('.$idVuelo.')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    if ($recursoDetalles == "") {
        $resultado = 'No hay coincidencias con su busqueda.';
    }
    $objResponse->addAssign("gestionReserva", "innerHTML", "$resultado");
    return $objResponse;
}

function inicio(){
    $controlVuelo = new ControlVueloLogicaclass();
    $coleccionVuelo = $controlVuelo->vueloEspecificoSinFiltro(date("Y")."-".date("m").'-'.date('d'),
        date("Y")."-".date("m").'-'.date('d'));
    $resultado = "";
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>FECHA</th>';
    $resultado.= '<th>HORA</th>';
    $resultado.= '<th>ORIGEN</th>';
    $resultado.= '<th>DESTINO</th>';
    $resultado.= '<th>ASIENTOS DISPONIBLES</th>';
    $resultado.= '<th>DISPONIBILIDAD</th>';
    $resultado.= '<th>AVION</th>';
    $resultado.= '<th>PILOTO</th>';
    $resultado.= '<th>COPILOTO</th>';
    $resultado.= '<th>DETALLES</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
    foreach ($coleccionVuelo as $var) {
        $recursoDetalles = $var->getColeccionVuelo();
        $cantidadDisponible = $var->getAsientosDisponibles();
        $piloto = $var->getPiloto();
        $copiloto = $var->getCopiloto();
        $disponibilidad = $var->getDisponibilidad();
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
        $resultado.= '<td>' . $cantidadDisponible. '</td>';
        $resultado.= '<td>' . $disponibilidad. '</td>';
        $resultado.= '<td>' . $recursoDetalles->getAvionMatricula(). '</td>';
        $resultado.= '<td>' . $piloto. '</td>';
        $resultado.= '<td>' . $copiloto. '</td>';
        $resultado.= '<td><input type="button" value="VER" onclick="xajax_verDetalles('.$idVuelo.')"/></td>';
        $resultado.= '</tr>';
        $color = !$color;
    }
    $resultado.= '</table>';
    $resultado.= '</form>';
    if ($recursoDetalles == "") {
        $resultado = 'No hay vuelos planificados para hoy (' . date("d") . "-" .
        date("m") . '-' . date('Y') . ')';
    }
    $objResponse->addAssign("gestionReserva", "innerHTML", "$resultado");
    return $objResponse;
}

function verDetalles($idVuelo){
    $controlVuelo = new ControlVueloLogicaclass();
//    $recurso = $controlVuelo->consultarVuelosDetalles($idVuelo);
    $objResponse = new xajaxResponse();
    $resultado = '<form id="formularioEditarMarcar">';
    $resultado.= '<table class="scrollTable" cellspacing="0">';
    $resultado.= '<thead>';
    $resultado.= '<tr>';
    $resultado.= '<th>SOLICITUD</th>';
    $resultado.= '<th>PASAJERO</th>';
    $resultado.= '<th>TIPO</th>';
    $resultado.= '<th>SERVICIO</th>';
    $resultado.= '<th>POSADA</th>';
    $resultado.= '<th>VENDEDOR</th>';
    $resultado.= '<th>SUCURSAL</th>';
    $resultado.= '<th>RETORNO</th>';
    $resultado.= '<th>RIF CLIENTE</th>';
    $resultado.= '<th>CI CLIENTE</th>';
    $resultado.= '<th>NOMBRE CLIENTE</th>';
    $resultado.= '<th>TIPO PAGO</th>';
    $resultado.= '<th>BANCO</th>';
    $resultado.= '<th>TRANSFERENCIA</th>';
    $resultado.= '<th>MONTO</th>';
    $resultado.= '<th>BOLETO EMITIDO</th>';
    $resultado.= '</tr>';
    $resultado.= '</thead>';
    $color = false;
//    while ($row = mysql_fetch_array($recurso)){

//    }
    $objResponse->addAssign("gestionReservaPasajeros", "innerHTML", "$resultado");
    return $objResponse;
}



?>
