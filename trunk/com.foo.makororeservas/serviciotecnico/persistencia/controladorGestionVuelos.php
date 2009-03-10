<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorVueloPersonalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Vuelo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/VueloPersonal.class.php';

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

    function existeVuelo($fecha,$hora,$matricula,$sitioSalida,$sitioLlegada) {
        $resultado = false;
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula matricula, v.RUTA_sitioSalida salida,v.RUTA_sitioLlegada llegada
                  FROM vuelo v WHERE v.fecha= '".$fecha."'
                  AND v.hora= '".$hora."'
                  AND v.AVION_matricula = '".$matricula."'
                  AND v.RUTA_sitioSalida = '".$sitioSalida."'
                  AND v.RUTA_sitioLlegada = '".$sitioLlegada."'";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($recurso);
        if ($cantidad > 0) {
            $resultado = true;
        }
        return $resultado;
    }

    function nuevoVuelo ($fecha,$hora,$matricula,$sitioSalida,$sitioLlegada,$piloto,$copiloto) {
           $resultado = false;
           if (!$this->existeVuelo($fecha, $hora, $matricula, $sitioSalida, $sitioLlegada)) {
           $controlVuelo = new controladorVueloBDclass();
           $vuelo = new Vueloclass();
           $vuelo->setFecha($fecha);
           $vuelo->setHora($hora);
           $vuelo->setAvionMatricula($matricula);
           $vuelo->setRutaSitioSalida($sitioSalida);
           $vuelo->setRutaSitioLLegada($sitioLlegada);
           $idActual = $controlVuelo->agregarNuevoVuelo($vuelo);
           if ($idActual != 0 ) {
               if ($piloto !='NULL' && $copiloto !='NULL'){
           $controlVueloPersonal = new controladorVueloPersonalBDclass();
           $vueloPersonalPiloto = new VueloPersonalclass();
           $vueloPersonalPiloto->setPersonalCedula($piloto);
           $vueloPersonalPiloto->setCargo(1);
           $vueloPersonalPiloto->setVueloId($idActual);
           $vueloPersonalCopiloto = new VueloPersonalclass();
           $vueloPersonalCopiloto->setPersonalCedula($copiloto);
           $vueloPersonalCopiloto->setCargo(2);
           $vueloPersonalCopiloto->setVueloId($idActual);
           $resultadoPersona = $controlVueloPersonal->agregarVueloPersonal($vueloPersonalPiloto);
           if ($resultadoPersona)
           $resultado = $controlVueloPersonal->agregarVueloPersonal($vueloPersonalCopiloto);}
           else $resultado = true;
           }
           }
       return $resultado;
    }
}
?>
