<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorRutaBD.class.php';

$ruta = new Rutaclass();
$ruta->setSitioSalida('MERIDA');
$ruta->setSitioLlegada('MAIQUETIA');
$ruta->setAbreviaturaSalida('MER');
$ruta->setAbreviaturaLlegada('MAI');
$ruta->setTiempo(1);
$ruta->setCosto(800.0);
$ruta->setGeneraIVA(1);

$controlPrueba = new controladorRutaBDclass();
//$result = $controlPrueba->agregarRuta($ruta);
//$result = $controlPrueba->editarRuta($ruta);
//$result = $controlPrueba->consultarRutas();
$result = $controlPrueba->consultarRutaID("LOS ROQUES","MAIQUETIA");
//echo $result;

?>
<table border = "1">
<tr>
    <td>Sitio Salida</td>
    <td>Sitio Llegada</td>
    <td>Abreviatura Salida</td>
    <td>Abreviatura Llegada</td>
    <td>Tiempo</td>
    <td>Costo</td>
    <td>Genera IVA</td>
</tr>
<?php
    while($array = mysql_fetch_array($result)){
        ?>
        <tr>
            <td><?php echo $array['sitioSalida'] ?></td>
            <td><?php echo $array['sitioLlegada'] ?></td>
            <td><?php echo $array['abreviaturaSalida'] ?></td>
            <td><?php echo $array['abreviaturaLlegada'] ?></td>
            <td><?php echo $array['tiempo'] ?></td>
            <td><?php echo $array['costo'] ?></td>
            <td><?php echo $array['generaIVA'] ?></td>
        </tr>
        <?php
    }
?>
</table>

<?php

?>
