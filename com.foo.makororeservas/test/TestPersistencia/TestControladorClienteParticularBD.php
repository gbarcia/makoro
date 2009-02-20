<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteParticular.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorClienteParticularBD.class.php';

$clienteParticular = new ClienteParticularclass();
//
//$clienteParticular->setCedula(17064051);
//$clienteParticular->setNombre("Dianilla");
//$clienteParticular->setApellido("Uribe");
//$clienteParticular->setSexo("f");
//$clienteParticular->setFechanacimiento("1987-01-04");
//$clienteParticular->setTelefono("04160104011");
//$clienteParticular->setEstado("Dtto Capital");
//$clienteParticular->setCiudad("Caracas");
//$clienteParticular->setDireccion("El cafetal");
//
//$resultado = $controlPrueba->agregarClienteParticular($clienteParticular);
//echo $resultado;

//
//$clienteParticular->setCedula(18027622);
//$clienteParticular->setNombre("Mayis");
//$clienteParticular->setApellido("Uribee");
//$clienteParticular->setTelefono("04129513433");
//$clienteParticular->setEstado("DC");
//$clienteParticular->setCiudad("Bogota");
//$clienteParticular->setDireccion("Norte");
//
//$resultado = $controlPrueba->editarClienteParticular($clienteParticular);
//echo $resultado;
//

$controlPrueba = new controladorClienteParticularBDclass();
$busqueda = 'A';

echo '<table border=1>';
echo '<tr>';
echo '<th>cedula</th>';
echo '<th>nombre</th>';
echo '<th>apellido</th>';
echo '</tr>';
$resultado = $controlPrueba->consultarClienteParticularCedulaNombreApellido($busqueda);
    while ($row = mysql_fetch_array($resultado)) {
    echo '<tr>';
    echo '<td>' . $row['cedula'] . '</td>';
    echo '<td>' . $row['nombre'] . '</td>';
    echo '<td>' . $row['apellido'] . '</td>';
    echo '</tr>';
}
echo '</table>';

?>
