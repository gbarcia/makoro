<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';
#AGREGAR NUEVO ENCARGADO#
//$encargadoPrueba = new Encargadoclass();
//$encargadoPrueba->setCedula(2);
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
//$encargadoPrueba->setCorreo('ger@gmail.com');
//
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//
//$reultadoPrueba = $controlPruebaSeguridad->agregarEncargado($encargadoPrueba);
//
//print "RESULTADO DEL TEST AGREGAR NUEVO ENCARGADO: " .$reultadoPrueba;

#EDITAR ENCARGADO#
//$encargadoPrueba = new Encargadoclass();
//$encargadoPrueba->setCedula(2);
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
//$encargadoPrueba->setCorreo('gerrdobarciap@gmail.com');
//
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//
//$reultadoPrueba = $controlPruebaSeguridad->editarEncargado($encargadoPrueba);
//
//print "RESULTADO DEL TEST EDITAR ENCARGADO: " .$reultadoPrueba;

#CONSULTAR ENCARGADO#
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//$encargadoPrueba = $controlPruebaSeguridad->buscarEncargadoPorCedula(2);
////$encargadoPrueba = new Encargadoclass();
//
//print "RESULTADO DEL TEST BUSCAR ENCARGADO: \n" . "<p></p>";
//print "NOMBRE: ". $encargadoPrueba->getNombre() . "<p></p>";
//print "APELLIDO: ". $encargadoPrueba->getApellido(). "<p></p>";
//print "CEDULA: ". $encargadoPrueba->getCedula(). "<p></p>";
//print "LOGIN: ". $encargadoPrueba->getLogin(). "<p></p>";
//print "CLAVE: ". $encargadoPrueba->getClave() . "<p></p>";
//print "IDSUCURSAL: ". $encargadoPrueba->getSucursalDondeTrabaja(). "<p></p>";
//print "NOMBRESUCURSAL: ". $encargadoPrueba->getSucursalDondeTrabajaString(). "<p></p>";
//print "SEXO: ". $encargadoPrueba->getSexo(). "<p></p>";
//print "TELEFONO: ". $encargadoPrueba->getTelefono() . "<p></p>";
//print "ESTADO: ". $encargadoPrueba->getEstado(). "<p></p>";
//print "CIUDAD: ". $encargadoPrueba->getCiudad(). "<p></p>";
//print "FECHA NAC: ". $encargadoPrueba->getFechaNac(). "<p></p>";
//print "DIRECCION: ". $encargadoPrueba->getDireccion(). "<p></p>";
//print "TIPO: ". $encargadoPrueba->getTipo(). "<p></p>";
//print "HABILITADO: ". $encargadoPrueba->getHabilitado(). "<p></p>";
//print "CORREO: ". $encargadoPrueba->getCorreo(). "<p></p>";

#TRAER TODOS LOS ENCARGADOS#
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>CEDULA</th>';
//echo '<th>NOMBRE</th>';
//echo '<th>APELLIDO</th>';
//echo '<th>SEXO</th>';
//echo '<th>FECHA NACIMIENTO</th>';
//echo '<th>ESTADO</th>';
//echo '<th>CIUDAD</th>';
//echo '<th>DIRECCION</th>';
//echo '<th>LOGIN</th>';
//echo '<th>CLAVE</th>';
//echo '<th>HABILITADO</th>';
//echo '<th>SUCURSAL</th>';
//echo '<th>ID SUCURSAL</th>';
//echo '<th>CORREO</th>';
//echo '</tr>';
//$resultado = $controlPruebaSeguridad->traerTodosLosEncargados();
//    while (($row = mysql_fetch_array($resultado))) {
//    echo '<tr>';
//    echo '<td>' . $row[cedula] . '</td>';
//    echo '<td>' . $row[nombre] . '</td>';
//    echo '<td>' . $row[apellido] . '</td>';
//    echo '<td>' . $row[sexo] . '</td>';
//    echo '<td>' . $row[fechaNacimiento] . '</td>';
//    echo '<td>' . $row[estado] . '</td>';
//    echo '<td>' . $row[ciudad] . '</td>';
//    echo '<td>' . $row[direccion] . '</td>';
//    echo '<td>' . $row[login] . '</td>';
//    echo '<td>' . $row[clave] . '</td>';
//    echo '<td>' . $row[habilitado] . '</td>';
//    echo '<td>' . $row[nSucursal] . '</td>';
//    echo '<td>' . $row[idSucursal] . '</td>';
//    echo '<td>' . $row[correo] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
#TRAER TODOS LOS ENCARGADOS AUTOSUGERIR#
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//echo '<table border=1>';
//echo '<tr>';
//echo '<th>CEDULA</th>';
//echo '<th>NOMBRE</th>';
//echo '<th>APELLIDO</th>';
//echo '<th>SEXO</th>';
//echo '<th>FECHA NACIMIENTO</th>';
//echo '<th>ESTADO</th>';
//echo '<th>CIUDAD</th>';
//echo '<th>DIRECCION</th>';
//echo '<th>LOGIN</th>';
//echo '<th>CLAVE</th>';
//echo '<th>HABILITADO</th>';
//echo '<th>SUCURSAL</th>';
//echo '<th>ID SUCURSAL</th>';
//echo '<th>CORREO</th>';
//echo '</tr>';
//$resultado = $controlPruebaSeguridad->busquedaEncargadoAutoSugerir('g');
//    while (($row = mysql_fetch_array($resultado))) {
//    echo '<tr>';
//    echo '<td>' . $row[cedula] . '</td>';
//    echo '<td>' . $row[nombre] . '</td>';
//    echo '<td>' . $row[apellido] . '</td>';
//    echo '<td>' . $row[sexo] . '</td>';
//    echo '<td>' . $row[fechaNacimiento] . '</td>';
//    echo '<td>' . $row[estado] . '</td>';
//    echo '<td>' . $row[ciudad] . '</td>';
//    echo '<td>' . $row[direccion] . '</td>';
//    echo '<td>' . $row[login] . '</td>';
//    echo '<td>' . $row[clave] . '</td>';
//    echo '<td>' . $row[habilitado] . '</td>';
//    echo '<td>' . $row[nSucursal] . '</td>';
//    echo '<td>' . $row[idSucursal] . '</td>';
//    echo '<td>' . $row[correo] . '</td>';
//    echo '</tr>';
//}
//echo '</table>';
#INHABILITAR VENDEDOR Y HABILITARLO#
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//$resultadoPrueba = $controlPruebaSeguridad->rehabilitarEncargado(1);
//print $resultadoPrueba;
#INHABILITAR VENDEDOR Y HABILITARLO#
//$controlPruebaSeguridad = new controladorSeguridadBDclass();
//$resultadoPrueba = $controlPruebaSeguridad->busquedaEncargadoPorLogin("GOMIR");
//$row = mysql_fetch_array($resultadoPrueba);
//
//print $row[password];
//echo (md5('1234'));

?>
