<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlReservaLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Reserva.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/logica/ControlClienteParticularLogica.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/ClienteParticular.class.php';

$controlTest = new ControlReservaLogicaclass();
$sucursalTest = new Reservaclass();
$controlPrueba = new ControlClienteParticularLogicaclass();
$clienteTest = new ClienteParticularclass();

/**
 * Agregar reserva
 */
//$fecha = '2009-03-04';
//$estado = 'PP';
//$solicitud = 'AA12';
//$tipoServicioId = 2;
//$sucursalId = 1;
//$encargadoCedula = 17064051;
//$clienteParticularCedula = 19012345;
//$clienteAgenciaRif = 'J-345678';
//$PAGO_id = null;
//$pasajeroId = null;
//$posadaId = null;

/*
 * Datos del cliente
 */
//$nombre = 'Carmen';
//$apellido = 'Perez';
//$sexo = 'F';
//$fechaNacimiento = '1980-01-05';
//$telefono = '02123332112';
//$estado = 'Dtto Capital';
//$ciudad = 'Caracas';
//$direccion = 'La Candelaria';

//$resultadoInsert = $controlPrueba->nuevoClienteParticular($clienteParticularCedula, $nombre, $apellido, $sexo, $fechaNacimiento, $telefono, $estado, $ciudad, $direccion);
//$resultado = $controlTest->nuevaReserva($fecha, $estado, $solicitud, $tipoServicioId, $sucursalId, $encargadoCedula, null, $clienteAgenciaRif, null, null, null);
//echo 'Cliente: '+$resultadoInsert+', Reserva: '+$resultado;
//echo $resultado;

$controlTest->crearReserva(3, '2009-03-08', 1, 1, 17064051, 18310338, null, 'null');


?>