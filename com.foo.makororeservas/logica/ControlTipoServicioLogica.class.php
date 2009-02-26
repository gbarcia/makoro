<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorTipoServicioBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/TipoServicio.class.php';
/**
 * Description of ControlTipoServicioLogicaclass
 * Clase para manejar la logica de los tipos de servicio
 * @author Diana Uribe
 */
class ControlTipoServicioLogicaclass {
    private $controlBD;

    function __construct() {
        $this->controlBD = new controladorTipoServicioBDclass();
    }

/**
 * Metodo para agregar un nuevo servicio
 * @param <Integer> $id
 * @param <String> $tipo
 * @return <boolean>
 */
    function nuevoTipoServicio($abreviatura,$nombre) {
        $tipoServicio = new TipoServicioclass();
        $tipoServicio->setAbreviatura($abreviatura);
        $tipoServicio->setNombre($nombre);
        $resultado = $this->controlBD->agregarTipoServicio($tipoServicio);

        return ($resultado);
    }

/**
 * Metodo para editar un servicio
 * @param <Integer> $id
 * @param <String> $tipo
 * @return <boolean>
 */
    function actualizarTipoServicio($id,$abreviatura,$nombre) {
        $tipoServicio = new TipoServicioclass();
        $tipoServicio->setId($id);
        $tipoServicio->setAbreviatura($abreviatura);
        $tipoServicio->setNombre($nombre);
        $resultado = $this->controlBD->editarTipoServicio($tipoServicio);

        return ($resultado);
    }

/**
 * Metodo para consultar todos los servicios
 * @return <Coleccion> todos los servicios
 */
    function consultarServicios() {
        $recurso = false;
        $recurso = $this->controlBD->consultarTodosLosTipoServicio();
        return $recurso;
    }

/**
 * Metodo para consultar servicio seleccionado
 * @return <servicio>
 */
    function consultarInformacionServicio($busqueda) {
       $controlTipoServicio = new controladorTipoServicioBDclass();
       $id = $controlTipoServicio->consultarServicio($busqueda);
       $servicioInfo = $controlTipoServicio->consultarServicioId($id);

       return servicioInfo;
    }

    function consultarServicioMasSolicitado() {
        $recurso = false;
        $recurso = $this->controlBD->consultarServicioMasSolicitado();
        return $recurso;
    }

    function consultarServicioMasSolicitadoDesc() {
        $recurso = false;
        $recurso = $this->controlBD->consultarServiciosMasSolicitadosDescendente();
        return $recurso;
    }
}
?>
