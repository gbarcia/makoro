<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorRutaBD.class.php';

$ruta = new Rutaclass();
$ruta->setId(6);
$ruta->setSitioSalida('MARACAIBO');
$ruta->setSitioLlegada('BOGOTA');
$ruta->setAbreviaturaSalida('MCB');
$ruta->setAbreviaturaLlegada('BOG');
$ruta->setTiempo(0.50);
$ruta->setGeneraIVA(0);

$controlPrueba = new controladorRutaBDclass();
//$result = $controlPrueba->agregarRuta($ruta);
//$result = $controlPrueba->editarRuta($ruta);
//$result = $controlPrueba->consultarRutas();
$result = $controlPrueba->consultarRutaID(3);


?>

<table border = "1">
<tr>
    <td>Id</td>
    <td>Sitio Salida</td>
    <td>Sitio Llegada</td>
    <td>Abreviatura Salida</td>
    <td>Abreviatura Llegada</td>
    <td>Tiempo</td>
    <td>Genera IVA</td>
</tr>
<?php
    while($array = mysql_fetch_array($result)){
        ?>
        <tr>
            <td><?php echo $array['id'] ?></td>
            <td><?php echo $array['sitioSalida'] ?></td>
            <td><?php echo $array['sitioLlegada'] ?></td>
            <td><?php echo $array['abreviaturaSalida'] ?></td>
            <td><?php echo $array['abreviaturaLlegada'] ?></td>
            <td><?php echo $array['tiempo'] ?></td>
            <td><?php echo $array['generaIVA'] ?></td>
        </tr>
        <?php
    }
?>
</table>

<?php
?>
