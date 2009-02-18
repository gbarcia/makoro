<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Configuracion.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorConfiguracionBD.class.php';
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$configuracion = new Configuracionclass();
//$configuracion->setId(3);
//$configuracion->setSueldoPiloto(893.49);
//$configuracion->setSueldoCopiloto(659.04);
//$configuracion->setSobrecargo(1324.09);

//$controlPrueba = new controladorConfiguracionBDclass();
//$resultado = $controlPrueba->agregarConfiguracion($configuracion);

//$controlPrueba = new controladorConfiguracionBDclass();
//$resultado = $controlPrueba->editarConfiguracion($configuracion);

$controlPrueba = new controladorConfiguracionBDclass();
$resultado = $controlPrueba->consultarConfiguracion();

echo '<table border=1>';
echo '<tr>';
echo '<th>id</th>';
echo '<th>sueldoPiloto</th>';
echo '<th>sueldoCopiloto</th>';
echo '<th>sobrecargo</th>';
echo '</tr>';
while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['sueldoPiloto'] . '</td>';
    echo '<td>' . $row['sueldoCopiloto'] . '</td>';
    echo '<td>' . $row['sobrecargo'] . '</td>';
    echo '</tr>';
}
echo '</table>';
?>
