<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';

$encargadoPrueba = new Encargadoclass();

$encargadoPrueba = new Encargadoclass();
$encargadoPrueba->setCedula(17123333);
$encargadoPrueba->setNombre('GERARDO');
$encargadoPrueba->setApellido('BARCIA');
$encargadoPrueba->setCiudad('CARACAS');
$encargadoPrueba->setDireccion("AV DORMIR");
$encargadoPrueba->setEstado("MIRANDA");
$encargadoPrueba->setFechaNac("2000-12-01");
$encargadoPrueba->setHabilitado(1);
$encargadoPrueba->setLogin("GOMI");
$encargadoPrueba->setSexo("M");
$encargadoPrueba->setTelefono("12");
$encargadoPrueba->setTipo("V");
$encargadoPrueba->setSucursalDondeTrabaja(1);
$encargadoPrueba->setCorreo('gerardobarciap@gmail.com');
$encargadoPrueba->setClave("202cb962ac59075b964b07152d234b70");

$correoPrueba = "gerardobarciap@gmail.com";

$controlPrueba = new ControlSeguridadclass();

$resultado = $controlPrueba->editarEncargado($encargadoPrueba, "123","123");

echo $resultado;

?>
