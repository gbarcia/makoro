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
    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para consultar un vuelo por su identificador determinado
 * @param <Integer> $idVuelo Identificador del vuelo
 * @return <recurso> vuelo especificado por la busqueda
 */
    function ConsultarVueloPorId ($idVuelo) {
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula matricula, v.RUTA_sitioSalida salida,v.RUTA_sitioLlegada llegada
                  FROM VUELO v WHERE id=$idVuelo";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar si el vuelo a insertar existe o no
 * @param <Date> $fecha Fecha del vuelo
 * @param <Time> $hora Hora del vuelo
 * @param <String> $matricula Matricula del avion
 * @param <String> $sitioSalida Lugar de salida
 * @param <String> $sitioLlegada Lugar de retorno
 * @return <boolean> resultado de la operacion true o false
 */
    function existeVuelo($fecha,$hora,$matricula,$sitioSalida,$sitioLlegada) {
        $resultado = false;
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula matricula, v.RUTA_sitioSalida salida,v.RUTA_sitioLlegada llegada
                  FROM VUELO v WHERE v.fecha= '".$fecha."'
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

/**
 * Metodo para consultar si un avion determinado esta ocupado para una fecha
 * y hora especifica
 * @param <Date> $fecha Fecha del vuelo
 * @param <Time> $hora Hora del vuelo
 * @param <String> $matricula Matricula del avion
 * @return <recurso>  cantidad de vuelos para ese vuelo
 */
    function avionOcupado ($fecha,$hora,$matricula) {
        $resultado = false;
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula matricula
                  FROM VUELO v WHERE v.fecha= '".$fecha."'
                  AND v.hora= '".$hora."'
                  AND v.AVION_matricula = '".$matricula."'";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($recurso);
        if ($cantidad > 0) {
            $resultado = true;
        }
        return $resultado;
    }

/**
 * Metodo para actualizar un avion determinado por la fecha, hora, matricula y
 * el identificador del vuelo
 * @param <Date> $fecha Fecha del vuelo
 * @param <Time> $hora Hora del vuelo
 * @param <String> $matricula Matricula del avion
 * @param <Integer> $idVuelo Identificador del vuelo
 * @return <boolean> resultado de la operacion true o false
 */
    function avionOcupadoEditar ($fecha,$hora,$matricula,$idVuelo) {
        $resultado = false;
        $query = "SELECT v.id,v.fecha,v.hora,v.AVION_matricula matricula
                  FROM VUELO v WHERE v.fecha= '".$fecha."'
                  AND v.hora= '".$hora."'
                  AND v.AVION_matricula = '".$matricula."'";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($recurso);
        $row = mysql_fetch_array($recurso);
        if ($cantidad > 0 && $idVuelo != $row[id]) {
            $resultado = true;
        }
        return $resultado;
    }

/**
 * Metodo para consultar un personal que no este disponible en un vuelo
 * @param <Integer> $cedula Cedula del personal
 * @param <Date> $fecha Fecha del vuelo
 * @param <Time> $hora Hora del vuelo
 * @return <boolean> resultado de la operacion true o false
 */
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

/**
 * Metodo para confirmar si existe un personal en la base de datos
 * @param <Integer> $idVuelo Identificador del vuelo
 * @param <Integer> $cedula Cedula del personal
 * @return <boolean> resultado de la operacion true o false
 */
    function existePersonal ($idVuelo,$cedula) {
        $resultado = false;
        $query = "SELECT vr.PERSONAL_cedula cedula
                  FROM VUELO_PERSONAL vr
                  WHERE vr.VUELO_id = $idVuelo AND vr.PERSONAL_cedula = $cedula";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $cantidad = mysql_num_rows($recurso);
        if ($cantidad > 0) {
            $resultado = true;
        }
        return $resultado;
    }

/**
 * Metodo para eliminar un tripulante en un vuelo
 * @param <Integer> $idVuelo Identificador del vuelo
 * @return <boolean> resultado de la operacion true o false
 */
    function borrarPersonalVuelo ($idVuelo) {
        $resultado = false;
        $query = "DELETE FROM VUELO_PERSONAL WHERE VUELO_id = $idVuelo";
        $recurso = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para actualizar la matricula del avion en el vuelo solo si ésta es
 * diferente de null, sino que la defina como null
 * @param <Integer> $idVuelo Identificador del vueo
 * @param <String> $matricula Matricula del avion
 * @return <boolean> resultado de la operacion true o false
 */

    function actualizarMatriculaAvion ($idVuelo, $matricula) {
        $resultado = false;
        if ($matricula != 'NULL')
        $query = "UPDATE VUELO SET AVION_matricula = '".$matricula."' WHERE id = $idVuelo";
        else
        $query = "UPDATE VUELO SET AVION_matricula = NULL WHERE id = $idVuelo";
        $recurso = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para actualizar los datos del vuelo
 * @param <Integer> $idVuelo Identificador del vuelo
 * @param <String> $matricula Matricula del avion
 * @param <String> $piloto Coleccion de datos del piloto
 * @param <String> $copiloto Coleccion de datos del copiloto
 * @param <Date> $fecha Fecha del vuelo
 * @param <Time> $hora Hora del vuelo
 * @return <boolean> resultado de la operacion true o false
 */
    function editarVuelo ($idVuelo,$matricula,$piloto,$copiloto,$fecha,$hora) {
        $resultado = false;
        if (!$this->avionOcupadoEditar($fecha, $hora, $matricula,$idVuelo)) {
            $resultado = $this->actualizarMatriculaAvion($idVuelo, $matricula);
            $this->borrarPersonalVuelo($idVuelo);

            if ($piloto !='NULL' && $copiloto !='NULL'){
                $controlVueloPersonal = new controladorVueloPersonalBDclass();
                $vueloPersonalPiloto = new VueloPersonalclass();
                $vueloPersonalPiloto->setPersonalCedula($piloto);
                $vueloPersonalPiloto->setCargo(1);
                $vueloPersonalPiloto->setVueloId($idVuelo);
                $vueloPersonalPiloto->setVueloId($idActual);
                $vueloPersonalCopiloto = new VueloPersonalclass();
                $vueloPersonalCopiloto->setPersonalCedula($copiloto);
                $vueloPersonalCopiloto->setVueloId($idVuelo);
                $vueloPersonalCopiloto->setCargo(2);
                $vueloPersonalCopiloto->setVueloId($idActual);
                $resultadoPersona = $controlVueloPersonal->agregarVueloPersonal($vueloPersonalPiloto);
                if ($resultadoPersona)
                $resultado = $controlVueloPersonal->agregarVueloPersonal($vueloPersonalCopiloto);
            } else $resultado = true;
        }
        return $resultado;
    }
/**
 * Metodo para anular un vuelo en el sistema junto con todos sus datos
 * @param <Inteer> $idVuelo el identificador del vuelo a anular
 * @return <boolean> resultado de la operacion
 */
    function deshacerDelSistemaUnVuelo ($idVuelo) {
        $resultadoOperacion = false;
        $queryVR = "DELETE FROM VUELO_RESERVA WHERE VUELO_id = $idVuelo";
        $resultadoVR = $this->transaccion->realizarTransaccion($queryVR);
        if ($resultadoVR){
            $queryV = "DELETE FROM VUELO WHERE id = $idVuelo";
            $resultadoV = $this->transaccion->realizarTransaccion($queryV);
            if ($resultadoV)
            $resultadoOperacion =true;
        }
        return $resultadoOperacion;
    }
/**
 * Metodo para obtener las observaciones de un vuelo
 * @param <Integer> $idVuelo id del vuelo
 * @return <String> cadena de caracteres con las observaciones del vuelo
 */
    function obtenerObservacionesVuelo ($idVuelo) {
        $query = "SELECT v.observaciones FROM VUELO v WHERE v.id = $idVuelo";
        $recurso = $this->transaccion->realizarTransaccion($query);
        $row = mysql_fetch_array($recurso);
        return $row[observaciones];
    }
/**
 * Metodo para actualizar las observaciones de un vuelo
 * @param <String> $obs observaciones a actualizar
 * @param <Integer> $idVuelo id del vuelo
 * @return <boolean> resultado de la operacion
 */
    function actualizarObservacionesVuelo ($obs,$idVuelo) {
        $resultado = false;
        $query = "UPDATE VUELO SET observaciones = '".$obs."' WHERE id = $idVuelo ";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para agregar un nuevo vuelo
 * @param <Date> $fecha Fecha del vuelo
 * @param <Time> $hora Hora del vuelo
 * @param <String> $matricula Matricula del avion
 * @param <String> $sitioSalida Lugar de salida
 * @param <String> $sitioLlegada Lugar de retorno
 * @param <Coleccion> $piloto Coleccion con los datos del piloto
 * @param <Coleccion> $copiloto Coleccion con los datos del copiloto
 * @return <boolean> resultado de la operacion true o false
 */
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
