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

//$cedula = 11232444;
//$fechaInicio = '2009-02-01';
//$fechaFin = '2009-03-31';
//$cargo = 1;
//$tarifa = 100;

$busqueda = 'J';

$controlPrueba = new controladorTripulanteBDclass();
//$resultado = $controlPrueba->agregarPersonal($tripulante);
//$resultado = $controlPrueba->editarPersonal($tripulante);
//$resultado = $controlPrueba->consultarTotalPagoPersonal($fechaInicio, $fechaFin, $cedula, $cargo, $tarifa);
//$resultado = $controlPrueba->consultarTotalPagoPersonal($fechaInicio, $fechaFin, $cedula, $cargo, $sueldo);

//$row = mysql_fetch_array($resultado);
//print $row[monto];

echo '<table border=1>';
echo '<tr>';
echo '<th>cedula</th>';
echo '<th>nombre</th>';
echo '<th>apellido</th>';
echo '<th>sexo</th>';
echo '<th>telefono Llegada</th>';
echo '<th>estado</th>';
echo '<th>ciudad</th>';
echo '<th>direccion</th>';
echo '<th>habilitado</th>';
echo '<th>cargo</th>';
echo '</tr>';
$resultado = $controlPrueba->consultarPersonaCedulaNombreApellido($busqueda);
    while (($row = mysql_fetch_array($resultado))) {
    echo '<tr>';
    echo '<td>' . $row['cedula'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['apellido'] . '</td>';
    echo '<td>' . $row['sexo'] . '</td>';
    echo '<td>' . $row['telefono'] . '</td>';
    echo '<td>' . $row['estado'] . '</td>';
    echo '<td>' . $row['ciudad'] . '</td>';
    echo '<td>' . $row['direccion'] . '</td>';
    echo '<td>' . $row['habilitado'] . '</td>';
    echo '<td>' . $row['cargo'] . '</td>';
    echo '</tr>';
}
echo '</table>';
?>
