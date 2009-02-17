<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTripulanteBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Tripulante.class.php';

//$tripulante = new Tripulanteclass();
//
//$tripulante->setCedula(111);
//$tripulante->setNombre('VICTOR');
//$tripulante->setApellido('Molina');
//$tripulante->setSexo('M');
//$tripulante->setTelefono(5554433);
//$tripulante->setEstado('Vargas');
//$tripulante->setCiudad('La Guaira');
//$tripulante->setDireccion('La Guairita');
//$tripulante->setHabilitado(true);
//$tripulante->setCargo(1);

$cedula = 11232444;
$fechaInicio = '2009-02-01';
$fechaFin = '2009-03-31';
$cargo = 1;
$tarifa = 100;

$controlPrueba = new controladorTripulanteBDclass();
//$resultado = $controlPrueba->agregarPersonal($tripulante);
//$resultado = $controlPrueba->editarPersonal($tripulante);
$resultado = $controlPrueba->consultarTotalPagoPersonal($fechaInicio, $fechaFin, $cedula, $cargo, $tarifa);
$row = mysql_fetch_array($resultado);
print $row[monto];




?>
