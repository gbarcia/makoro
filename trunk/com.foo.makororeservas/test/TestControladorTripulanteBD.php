<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTripulanteBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';

//$tripulante = new Tripulanteclass();
//
//$tripulante->setCedula(111);
//$tripulante->setNombre('VICTOR');
//$tripulante->setApellido('Molina');
//$tripulante->setSexo('M');
//$tripulante->setTelefono(5554433);
//$tripulante->setEstado('Vargas');
//$tripulante->setCiudad('La Guaira');
//$tripulante->setDireccion('La Guairita');
//$tripulante->setHabilitado(true);
//$tripulante->setCargo(1);

$cedula = 11232444;
$fechaInicio = '2009-02-01';
$fechaFin = '2009-03-31';
$cargo = 1;
$tarifa = 100;

$controlPrueba = new controladorTripulanteBDclass();
//$resultado = $controlPrueba->agregarPersonal($tripulante);
//$resultado = $controlPrueba->editarPersonal($tripulante);
//$resultado = $controlPrueba->consultarTotalPagoPersonal($fechaInicio, $fechaFin, $cedula, $cargo, $tarifa);
//$resultado = $controlPrueba->consultarTotalPagoPersonal($fechaInicio, $fechaFin, $cedula, $cargo, $sueldo);

//$row = mysql_fetch_array($resultado);
//print $row[monto];

echo '<table>';
echo '<tr>';
echo '<th>cedula</th>';
echo '<th>nombre</th>';
echo '<th>apellido</th>';
echo '<th>sitio Salida</th>';
echo '<th>sitio Llegada</th>';
echo '<th>tiempo</th>';
echo '<th>matricula avion</th>';
echo '<th>cago</th>';
echo '</tr>';
$resultado = $controlPrueba->consultarDetallesPagoPersonal($fechaini, $fechafin, $cedula, $cargo, $sueldo);
    while (!($row = mysql_fetch_array($resultado))) {
    echo '<tr>';
    echo '<td>' . $row['cedula'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['apellido'] . '</td>';
    echo '<td>' . $row['sitioSalida'] . '</td>';
    echo '<td>' . $row['sitioLlegada'] . '</td>';
    echo '<td>' . $row['tiempo'] . '</td>';
    echo '<td>' . $row['AVION_matricula'] . '</td>';
    echo '<td>' . $row['cargo'] . '</td>';
    echo '</tr>';
}
mysql_free_result($resultado);
echo '</table>';
?>
