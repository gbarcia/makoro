<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoServicio.class.php';
/**
 * Description of controladorTipoServicioBDclass
 *
 * @author Diana Uribe
 */
class controladorTipoServicioBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agregar un nuevo tipo servicio
 * @param <String> $tipoServicio
 * @return <boolean> resultado de la operacion
 */
    function agregarTipoServicio($tipoServicio) {
        $resultado = false;
        $query = "INSERT INTO TIPO_SERVICIO (abreviatura,nombre)".
                 "VALUES ('" . $tipoServicio->getAbreviatura() . "',
                          '" . $tipoServicio->getNombre() . "')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para modificar un tipo servicio
 * @param <String> $tipoServicio
 * @return <boolean> resultado de la operacion
 */
    function editarTipoServicio($tipoServicio) {
        $resultado = false;
        $query = "UPDATE TIPO_SERVICIO t SET t.abreviatura = '".$tipoServicio->getAbreviatura()."',
                                             t.nombre = '".$tipoServicio->getNombre()."'
                  WHERE t.id = ".$tipoServicio->getId()."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }


/**
 * Metodo para consultar los tipos de servicio
 * @return <recurso> recurso con todos los servicios
 */
    function consultarTodosLosTipoServicio() {
        $resultado = false;
        $query = "SELECT * FROM TIPO_SERVICIO";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar un servicio en especifico
 * @param <Integer> $id
 * @return <recurso> recurso con el servicio solicitado
 */
    function consultarServicioId($id) {
        $resultado = false;
        $query = "SELECT id, abreviatura, nombre
                  FROM TIPO_SERVICIO
                  WHERE id = ".$id."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar un servicio seleccionado
 * @param <String> $busqueda
 * @return <recurso>
 */
    function consultarServicio($busqueda) {
        $resultado = false;
        $query = "SELECT id, abreviatura,nombre
                  FROM TIPO_SERVICIO
                  WHERE abreviatura LIKE '".$busqueda."%'
                  AND nombre LIKE '".$busqueda."%'";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar los servicios mas solicitados en orden descendente
 * @return <recurso> recurso que devuelve los servicios 
 */
    function consultarServiciosMasSolicitadosDescendente() {
        $resultado = false;
        $query = "SELECT SUM(r.TIPO_SERVICIO_id) cantidadTotal, t.id id, t.abreviatura abreviatura, t.nombre nombre
                  FROM RESERVA r, TIPO_SERVICIO t
                  WHERE t.id = r.TIPO_SERVICIO_id
                  GROUP BY t.id, t.abreviatura, t.nombre
                  ORDER BY (SUM(r.TIPO_SERVICIO_id)) DESC";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para consultar el servicio mas solicitado
 * @return <recurso> servicio mas reservado
 */
    function consultarServicioMasSolicitado() {
        $resultado = false;
        $query = "	SELECT t.id,t.abreviatura,t.nombre, COUNT(r.TIPO_SERVICIO_id) cantidad
                    FROM RESERVA r, TIPO_SERVICIO t
                    WHERE t.id = r.TIPO_SERVICIO_id
                    GROUP BY t.id
                    HAVING COUNT(r.TIPO_SERVICIO_id) = (SELECT MAX(a.cnt)
                                                        FROM (SELECT COUNT(TIPO_SERVICIO_id) as cnt
                                                              FROM RESERVA
                                                              GROUP BY (TIPO_SERVICIO_id))
                                                        as a)";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
