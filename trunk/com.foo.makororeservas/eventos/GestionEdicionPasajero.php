<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPasajeroBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';


function mostrarFormulario ($datos) {
    $respuesta = "";
    $controlBD = new controladorPasajeroBDclass();
    $recurso = $controlBD->consultarPasajeroPorId($datos[cedulaPas]);
    $cantidad = mysql_num_rows($recurso);
    if ($cantidad <= 0) {
        $respuesta = "No existen coincidencias con sus busqueda";
    }
    else {
        $respuesta = '';
    }
}
?>