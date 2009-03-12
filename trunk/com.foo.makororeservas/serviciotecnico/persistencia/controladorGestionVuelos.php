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

    function avionOcupado ($fecha,$hora,$matricula) {
        $resultado = false;
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula matricula
                  FROM vuelo v WHERE v.fecha= '".$fecha."'
                  AND v.hora= '".$hora."'
                  AND v.AVION_matricula = '".$matricula."'";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($recurso);
        if ($cantidad > 0) {
            $resultado = true;
        }
        return $resultado;
    }

    function personalNoDisponible ($cedula,$fecha,$hora) {
        $resultado = false;
        $query = "SELECT  p.cedula
                  FROM VUELO_PERSONAL vp, PERSONAL p, VUELO v
                  WHERE p.cedula = vp.PERSONAL_cedula
                  AND v.id = vp.VUELO_id
                  AND  p.cedula = $cedula
                  AND v.fecha = '".$fecha."'
                  AND v.hora  = '".$hora."'";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($recurso);
        if ($cantidad > 0) {
            $resultado = true;
        }
        return $resultado;
    }

    function existePersonal ($idVuelo,$cedula) {
        $resultado = false;
        $query = "vr.PERSONAL_cedula cedula
                  FROM VUELO_PERSONAL vr
                  WHERE vr.VUELO_id = $idVuelo AND vr.PERSONAL_cedula = $cedula";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($recurso);
        if ($cantidad > 0) {
            $resultado = true;
        }
        return $resultado;
    }

    function borrarPersonalVuelo ($idVuelo) {
        $resultado = false;
        $query = "DELETE FROM VUELO_PERSONAL WHERE VUELO_id = $idVuelo";
        $recurso = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

    function actualizarMatriculaAvion ($idVuelo, $matricula) {
        $resultado = false;
        $query = "UPDATE VUELO v SET AVION_matricula = 'YV 307T' WHERE id = 15";
    }

    function nuevoVuelo ($fecha,$hora,$matricula,$sitioSalida,$sitioLlegada,$piloto,$copiloto) {
        $resultado = false;
        if (!$this->existeVuelo($fecha, $hora, $matricula, $sitioSalida, $sitioLlegada)) {
            if (!$this->avionOcupado($fecha, $hora, $matricula)) {
                if (!$this->personalNoDisponible($piloto, $fecha, $hora) || $piloto == 'NULL') {
                    if (!$this->personalNoDisponible($copiloto, $fecha, $hora) || $copiloto == 'NULL') {
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
                                $resultado = $controlVueloPersonal->agregarVueloPersonal($vueloPersonalCopiloto);
                            }
                            else $resultado = true;
                        }
                    }
                }
            }
        }
        return $resultado;
    }
}
?>
