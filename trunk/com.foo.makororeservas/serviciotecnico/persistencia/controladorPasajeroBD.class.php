<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';
/**
 * Description of controladorPasajeroBDclass
 * Clase para el manejo de la base de datos de los pasajeros
 * @author Diana Uribe
 */
class controladorPasajeroBDclass {
    private $transaccion;
    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }
/**
 * Metodo para agregar un nuevo pasajero
 * @param <PASAJERO> $pasajero
 * @return <boolean> resultado de la operacion
 */
    function agregarPasajero($pasajero){
        $resultado = false;
        $query = "INSERT INTO PASAJERO (nombre,apellido,sexo,cedula,pasaporte,
                                        nacionalidad,TIPO_PASAJERO_id)
                  VALUES ('".$pasajero->getNombre()."',
                          '".$pasajero->getApellido()."',
                          '".$pasajero->getSexo()."',
                           ".$pasajero->getCedula().",";
                          if($pasajero->getPasaporte() == ''){
                            $query .= " null,";
                          }else{
                            $query .= "'".$pasajero->getPasaporte()."',";
                          }
                          $query .= "'".$pasajero->getNacionalidad()."',
                          '".$pasajero->getTipoPasajeroId()."')";
        echo $query;
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para editar un pasajero en la base de datos
 * @param <PASAJERO> $pasajero
 * @return <boolean> resultado de la operacion
 */
    function editarPasajero($pasajero){
        $resultado = false;
        $query = "UPDATE PASAJERO p SET p.nombre = '".$pasajero->getNombre()."',
                                        p.apellido = '".$pasajero->getApellido()."',
                                        p.cedula = ".$pasajero->getCedula().",
                                        p.pasaporte = '".$pasajero->getPasaporte()."',
                                        p.nacionalidad = '".$pasajero->getNacionalidad()."',
                                        p.TIPO_PASAJERO_id = '".$pasajero->getTipoPasajeroId()."'

                  WHERE p.id = '".$pasajero->getId()."'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar los pasajeros de la base de datos
 * @return <Coleccion> coleccion de objeto pasajero
 */
    function consultarPasajeros() {
        $resultado = false;
        $query = "SELECT *
                  FROM PASAJERO";
        $resultado = $this->transaccion->realizarTransaccion($query);
        echo $query;
        return $resultado;
    }

/**
 * Metodo para consultar un pasajero segun la busqueda
 * @param <String> $busqueda
 * @return <recurso> recurso con todos los registros de los pasajeros
 */
    function consultarPasajeroNombreApellidoCedulaPasaporte($busqueda) {
        $resultado = false;
        $query = "SELECT CONCAT(p.cedula,' ',p.pasaporte,' ',p.nombre,' ',p.apellido,' '),
                                p.id idPasajero,p.cedula,p.pasaporte,p.nombre,p.apellido
                  FROM PASAJERO p
                  WHERE ( p.cedula LIKE '".$busqueda."%'
                  OR p.pasaporte LIKE '".$busqueda."%'
                  OR p.nombre LIKE '".$busqueda."%'
                  OR p.apellido LIKE '".$busqueda."%') LIMIT 0,5";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar pasajeros con viajes realizados
 * @param <Date> $fechaini
 * @param <Date> $fechafin
 * @return <recurso> registros de la busqueda
 */
    function consultarPasajerosConViajesRealizados($fechaini,$fechafin) {
        $resultado = false;
        $query = "SELECT r.id,p.cedula,p.pasaporte,p.nombre,p.apellido,vr.tipo,
                         v.fecha,v.hora,v.RUTA_sitioSalida,v.RUTA_sitioLlegada
                  FROM PASAJERO p,RESERVA r,VUELO_RESERVA vr,VUELO v
                  WHERE p.id = r.PASAJERO_id
                  AND r.id = vr.RESERVA_id
                  AND vr.VUELO_id = v.id
                  AND v.fecha BETWEEN '" . $fechaini . "' AND '" .$fechafin. "'
                  ORDER BY r.id ASC";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
