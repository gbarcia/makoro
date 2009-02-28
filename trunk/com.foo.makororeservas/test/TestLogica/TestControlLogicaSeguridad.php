<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlSeguridad.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';

$encargadoPrueba = new Encargadoclass();

$encargadoPrueba = new Encargadoclass();
$encargadoPrueba->setCedula(17079794);
$encargadoPrueba->setNombre('GERARDO');
$encargadoPrueba->setApellido('BARCIA');
$encargadoPrueba->setCiudad('CARACAS');
$encargadoPrueba->setDireccion("AV DORMIR");
$encargadoPrueba->setEstado("MIRANDA");
$encargadoPrueba->setFechaNac("2000-12-01");
$encargadoPrueba->setHabilitado(1);
$encargadoPrueba->setLogin("GOMI");
$encargadoPrueba->setSexo("M");
$encargadoPrueba->setTelefono("234");
$encargadoPrueba->setTipo("V");
$encargadoPrueba->setSucursalDondeTrabaja(1);
$encargadoPrueba->setCorreo('gerardobarciap@gmail.com');

$correoPrueba = "gerardobarciap@gmail.com";

$controlPrueba = new ControlSeguridadclass();

$resultado = $controlPrueba->nuevoEncargado($encargadoPrueba, $correoPrueba);

print $resultado;

?>
