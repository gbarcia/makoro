<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';

/**
 * Description of controladorGestionVuelos
 * Clase para la persistencia de la gestion de vuelos de programacion
 * @author gerardobarcia
 */
class controladorGestionVuelos {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

    function ConsultarVueloPorId ($idVuelo) {
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula matricula, v.RUTA_sitioSalida salida,v.RUTA_sitioLlegada llegada
                  FROM vuelo v WHERE id=$idVuelo";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function nuevoVuelo ($fecha,$hora,$matricula,$sitioSalida,$sitioLlegada,$piloto,$copiloto) {
           $controlVuelo = new controladorVueloBDclass();
           $vuelo = new Vueloclass();
           $vuelo->setFecha($fecha);
           $vuelo->setHora($hora);
           $vuelo->setAvionMatricula($matricula);
           $vuelo->setRutaSitioSalida($sitioSalida);
           $vuelo->setRutaSitioLLegada($sitioLlegada);
           $resultadoVuelo = $controlVuelo->agregarNuevoVuelo($vuelo);
           $controlVueloPersonal = new controladorVueloPersonalBDclass();
           $vueloPersonalPiloto = new VueloPersonalclass();
           $vueloPersonalPiloto->setPersonalCedula($piloto->getCedula);
           $vueloPersonalPiloto->setCargo($piloto->getCargo);
           $idActual = mysql_insert_id($controlVuelo->);
           $resultadoPersona = $controlVueloPersonal->agregarVueloPersonal($vueloPersonal);
    }
}
?>
