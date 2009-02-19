<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlTripulanteLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/PagoNominaTripulacion.class.php';

$controlBD = new ControlTripulanteLogicaclass();

// $tripulanteprueba = new Tripulanteclass();
//
////$tripulanteprueba->setCedula(1);
////$tripulanteprueba->setNombre('DIANA');
////$tripulanteprueba->setApellido('URIBE');
////$tripulanteprueba->setSexo('F');
////$tripulanteprueba->setTelefono('12');
////$tripulanteprueba->setEstado('miranda');
////$tripulanteprueba->setCiudad('caracas');
////$tripulanteprueba->setDireccion('a');
////$tripulanteprueba->setCargo(1);
//
//$resultado = $controlBD->nuevoTripulante(1, 'diana', 'uribe', 'f', '1', 'MIRANDA', 'CARACAS', 'A', 1);
//echo "RESULTADO ->" . $resultado;
//
//$resultado = $controlBD->actualizarTripulante(1, 'diana', 'maria', 'm', '1123', 'MIRANDAs', 'CARACASo', 'b',0, 2);
//echo "RESULTADO ->" . $resultado;

//echo '<table border=1>';
//echo '<tr>';
//echo '<th>cedula</th>';
//echo '<th>nombre</th>';
//echo '<th>apellido</th>';
//echo '<th>sexo</th>';
//echo '<th>telefono Llegada</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '<th>habilitado</th>';
//echo '<th>cargo</th>';
//echo '<th>sueldo</th>';
//echo '</tr>';
////$resultado = $controlBD->consultarTodoPersonal();
////foreach ($resultado as $row) {
////    echo '<tr>';
////    echo '<td>' . $row->getCedula(). '</td>';
////    echo '<td>' . $row->getNombre(). '</td>';
////    echo '<td>' . $row->getApellido(). '</td>';
////    echo '<td>' . $row->getSexo(). '</td>';
////    echo '<td>' . $row->getTelefono() . '</td>';
////    echo '<td>' . $row->getEstado(). '</td>';
////    echo '<td>' . $row->getCiudad(). '</td>';
////    echo '<td>' . $row->getDireccion(). '</td>';
////    echo '<td>' . $row->getHabilitado(). '</td>';
////    echo '<td>' . $row->getCargo(). '</td>';
////    echo '<td>' . $row->getSueldo(). '</td>';
////    echo '</tr>';
////}
////
////echo '</table>';
//
//
//
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>cedula</th>';
//echo '<th>nombre</th>';
//echo '<th>apellido</th>';
//echo '<th>sitio salida</th>';
//echo '<th>sitio Llegada</th>';
//echo '<th>tiempo</th>';
//echo '<th>matricula</th>';
//echo '<th>cargo</th>';
//echo '</tr>';
//$result = $controlBD->consultarDetallePago('2009-02-01', '2009-03-31', 81212334);
//while ($row = mysql_fetch_array($result)) {
//    echo '<tr>';
//    echo '<td>' . $row['cedula']. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[apellido]. '</td>';
//    echo '<td>' . $row[sitioSalida]. '</td>';
//    echo '<td>' . $row[sitioLlegada] . '</td>';
//    echo '<td>' . $row[tiempo]. '</td>';
//    echo '<td>' . $row[AVION_matricula]. '</td>';
//    echo '<td>' . $row[cargo]. '</td>';
//    echo '</tr>';
//}
//
//echo '</table>';
//
//$total = $controlBD->consultarMontoTotal('2009-02-01', '2009-03-31', 81212334);
//
//echo round($total,2);


//echo '<table border=1>';
//echo '<tr>';
//echo '<th>cedula</th>';
//echo '<th>nombre</th>';
//echo '<th>apellido</th>';
//echo '<th>sexo</th>';
//echo '<th>telefono Llegada</th>';
//echo '<th>estado</th>';
//echo '<th>ciudad</th>';
//echo '<th>direccion</th>';
//echo '<th>habilitado</th>';
//echo '<th>cargo</th>';
//echo '<th>sueldo</th>';
//echo '</tr>';
//$resultado = $controlBD->consultarTripulanteCedulaNombreApellido('J');
//while ($row = mysql_fetch_array($resultado)) {
//    echo '<tr>';
//    echo '<td>' . $row['cedula']. '</td>';
//    echo '<td>' . $row[nombre]. '</td>';
//    echo '<td>' . $row[apellido]. '</td>';
//    echo '<td>' . $row[sexo]. '</td>';
//    echo '<td>' . $row[telefono]. '</td>';
//    echo '<td>' . $row[estado]. '</td>';
//    echo '<td>' . $row[ciudad]. '</td>';
//    echo '<td>' . $row[direccion]. '</td>';
//    echo '<td>' . $row[habilitado]. '</td>';
//    echo '<td>' . $row[cargo]. '</td>';
//    echo '<td>' . $row[sueldo]. '</td>';
//    echo '</tr>';
//}
//
//echo '</table>';


$Coleccion = $controlBD->consultarSueldoNominaTripulantesDetalles('2009-01-01', '2009-04-30');
foreach ($Coleccion as $variable) {
    $recursoDetalles = $variable->getColeccionDetalles();
    $total = $variable->getTotalPago();
    $tripulante = $variable->getTripulante();

    echo $tripulante->getNombre();
    echo "\n";
    echo '<table border=1>';
    echo '<tr>';
    echo '<th>cedula</th>';
    echo '<th>nombre</th>';
    echo '<th>apellido</th>';
    echo '<th>sitio salida</th>';
    echo '<th>sitio Llegada</th>';
    echo '<th>tiempo</th>';
    echo '<th>matricula</th>';
    echo '<th>cargo</th>';
    echo '</tr>';
    while ($row = mysql_fetch_array($recursoDetalles)) {
        echo '<tr>';
        echo '<td>' . $row['cedula']. '</td>';
        echo '<td>' . $row[nombre]. '</td>';
        echo '<td>' . $row[apellido]. '</td>';
        echo '<td>' . $row[sitioSalida]. '</td>';
        echo '<td>' . $row[sitioLlegada] . '</td>';
        echo '<td>' . $row[tiempo]. '</td>';
        echo '<td>' . $row[AVION_matricula]. '</td>';
        echo '<td>' . $row[cargo]. '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo $total;
}

?>
