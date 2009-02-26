<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Avion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorAvionBD.class.php';

//$avion = new Avionclass();
//$avion->setMatricula('YV 333T');
//$avion->setAsientos(50);
//$avion->setHabilitado(1);
//
//$controlPrueba = new controladorAvionBDclass();
//$resultado = $controlPrueba->agregarAvion($avion);
//print("\$Agrego = ". $resultado);



//$avion = new Avionclass();
//$avion->setMatricula('YV 333T');
//$avion->setAsientos(33);
//$avion->setHabilitado(0);
//
//$controlPrueba = new controladorAvionBDclass();
//$resultado = $controlPrueba->editarAvion($avion);
//echo $resultado;



//$controlPrueba = new controladorAvionBDclass();
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>Matricula</th>';
//echo '<th>Asientos</th>';
//echo '<th>Habilitado</th>';
//echo '</tr>';
//$resultado = $controlPrueba->consultarAviones();
//    while (($row = mysql_fetch_array($resultado))) {
//    echo '<tr>';
//    echo '<td>' . $row['matricula'] . '</td>';
//    echo '<td>' . $row['asientos'] . '</td>';
//    echo '<td>' . $row['habilitado'] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';

$controlPrueba = new controladorAvionBDclass();
echo '<table border=1>';
echo '<tr>';
echo '<th>Matricula</th>';
echo '<th>Asientos</th>';
echo '<th>Habilitado</th>';
echo '</tr>';
$resultado = $controlPrueba->consultarAvionesHab(TRUE);
    while (($row = mysql_fetch_array($resultado))) {
    echo '<tr>';
    echo '<td>' . $row['matricula'] . '</td>';
    echo '<td>' . $row['asientos'] . '</td>';
    echo '<td>' . $row['habilitado'] . '</td>';
    echo '</tr>';
}
echo '</table>';
?>
