<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteAgencia.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorClienteAgenciaBD.class.php';

$clienteAgencia = new ClienteAgenciaclass();
$controlPrueba = new controladorClienteAgenciaBDclass();

//
//$clienteAgencia->setRif("J-010101");
//$clienteAgencia->setNombre("Dianita company");
//$clienteAgencia->setTelefono("02120104012");
//$clienteAgencia->setDireccion("Av. petralca con calle el avestruz.");
//$clienteAgencia->setEstado("Distrito Capital");
//$clienteAgencia->setCiudad("Ccs");
//$clienteAgencia->setPorcentajeComision(10);
//$resultado = $controlPrueba->editarClienteAgencia($clienteAgencia);
//echo $resultado;

$busqueda = 'D';

echo '<table border=1>';
echo '<tr>';
echo '<th>rif</th>';
echo '<th>nombre</th>';
echo '</tr>';
$resultado = $controlPrueba->consultarClienteAgenciaRifNombre($busqueda);
    while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row['rif'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '</tr>';
}
echo '</table>';

?>
