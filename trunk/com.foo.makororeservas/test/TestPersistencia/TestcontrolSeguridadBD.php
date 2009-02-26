<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';
#AGREGAR NUEVO ENCARGADO#
//$encargadoPrueba = new Encargadoclass();
//$encargadoPrueba->setCedula(1);
//$encargadoPrueba->setNombre('GOMOSITO');
//$encargadoPrueba->setApellido('SUEÑO');
//$encargadoPrueba->setCiudad('CARACAS');
//$encargadoPrueba->setClave('A123');
//$encargadoPrueba->setDireccion("AV DORMIR");
//$encargadoPrueba->setEstado("MIRANDA");
//$encargadoPrueba->setFechaNac("2000-12-01");
//$encargadoPrueba->setHabilitado(1);
//$encargadoPrueba->setLogin("GOMI");
//$encargadoPrueba->setSexo("M");
//$encargadoPrueba->setTelefono("234");
//$encargadoPrueba->setTipo("V");
//$encargadoPrueba->setSucursalDondeTrabaja(1);
//
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//
//$reultadoPrueba = $controlPruebaSeguridad->agregarEncargado($encargadoPrueba);

//print "RESULTADO DEL TEST AGREGAR NUEVO ENCARGADO: " .$reultadoPrueba;

#EDITAR ENCARGADO#
//$encargadoPrueba = new Encargadoclass();
//$encargadoPrueba->setCedula(1);
//$encargadoPrueba->setNombre('GOMOSITOr');
//$encargadoPrueba->setApellido('SUEÑOrr');
//$encargadoPrueba->setCiudad('CARACASR');
//$encargadoPrueba->setClave('A123R');
//$encargadoPrueba->setDireccion("AV DORMIRR");
//$encargadoPrueba->setEstado("MIRANDAR");
//$encargadoPrueba->setFechaNac("2000-12-01");
//$encargadoPrueba->setLogin("GOMIR");
//$encargadoPrueba->setTelefono("234R");
//$encargadoPrueba->setTipo("A");
//$encargadoPrueba->setSucursalDondeTrabaja(2);
//
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//
//$reultadoPrueba = $controlPruebaSeguridad->editarEncargado($encargadoPrueba);
//
//print "RESULTADO DEL TEST AGREGAR NUEVO ENCARGADO: " .$reultadoPrueba;

#CONSULTAR ENCARGADO#
$controlPruebaSeguridad = new controladorSeguridadBDclass();
$encargadoPrueba = $controlPruebaSeguridad->buscarEncargadoPorCedula(1);

print "RESULTADO DEL TEST BUSCAR ENCARGADO: \n";
print "NOMBRE: ". $encargadoPrueba->getNombre();

?>
