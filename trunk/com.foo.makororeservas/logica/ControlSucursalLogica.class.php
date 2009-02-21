<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSucursalBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Sucursal.class.php';
/**
 * Description of ControlSucursalLogicaclass
 * Manejo de la logica de la gestion de la sucursal
 * @author maya
 */
class ControlSucursalLogicaclass {

    private $controlBD;

    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->controlBD = new controladorSucursalBDclass();
    }

    /**
     * Metodo para agregar una sucursal en el sistema
     * @param <String> $nombre El nombre de la nueva sucursal
     * @param <String> $estado El estado donde se encuentra la nueva sucursal
     * @param <String> $ciudad La ciudad donde se encuentra la nueva sucursal
     * @param <String> $direccion La direccion donde se encuentra la nueva sucursal
     * @param <String> $telefono El telefono de la nueva sucursal
     * @param <boolean> $habilitado Indica si la sucursal esta habilitada o no
     * @return <boolean> El resultado de la operacion
     */
    function nuevaSucursal($nombre,$estado,$ciudad,$direccion,$telefono,$habilitado){
        $sucursal = new Sucursalclass();
        $sucursal->setNombre($nombre);
        $sucursal->setEstado($estado);
        $sucursal->setCiudad($ciudad);
        $sucursal->setDireccion($direccion);
        $sucursal->setTelefono($telefono);
        $sucursal->setHabilitado($habilitado);
        $resultado = $this->controlBD->agregarSucursal($sucursal);

        return ($resultado);
    }

    /**
     * Metodo para editar una sucursal en el sistema
     * @param <int> $id El identificador de la sucursal
     * @param <String> $nombre El nombre de la sucursal
     * @param <String> $estado El estado donde se encuentra la sucursal
     * @param <String> $ciudad La ciudad donde se encuentra la sucursal
     * @param <String> $direccion La direccion donde se encuentra la sucursal
     * @param <String> $telefono El telefono de la sucursal
     * @param <boolean> $habilitado Indica si la sucursal esta habilitada o no
     * @return <Coleccion>
     */
    function editarSucursal($id,$nombre,$estado,$ciudad,$direccion,$telefono,$habilitado){
        $sucursal = new Sucursalclass();
        $sucursal->setId($id);
        $sucursal->setNombre($nombre);
        $sucursal->setEstado($estado);
        $sucursal->setCiudad($ciudad);
        $sucursal->setDireccion($direccion);
        $sucursal->setTelefono($telefono);
        $sucursal->setHabilitado($habilitado);
        $resultado = $this->controlBD->editarSucursal($sucursal);

        return ($resultado);
    }

    /**
     * Metodo para consultar todas las sucursales del sistema
     * @return <Coleccion> Todas las sucursales del sistema
     */
    function consultarSucursales(){
        $recurso = $this->controlBD->consultarSucursales();
        return $recurso;
    }

    /**
     * Metodo para consultar todas las sucursales del sistema por id,nombre,
     * esta o ciudad
     * @param <String> $busqueda La busqueda a realizar
     * @return <recurso> Las sucursales de acuerdo a la busqueda realizada
     */
    function consultarSucursalIdNombreEstadoCiudad($busqueda){
        $recurso = $this->controlBD->consultarSucursalIdNombreEstadoCiudad($busqueda);
        return $recurso;
    }

    /**
     * Metodo para consultar los encargados que trabajan en una sucursal
     * @param <int> $idSucursal El identificador de la sucursal a consultar
     * @return <recurso> Los encargados que trabajan en la sucursal consultada
     */
    function consultarEncargadosSucursal($idSucursal){
        $recurso = $this->controlBD->consultarEncargadosSucursal($idSucursal);
        return $recurso;
    }

    /**
     * Metodo para consultar las ventas realizadas por una sucursal en el sistema
     * @param <int> $idSucursal El id de la sucursal a consultar
     * @param <Date> $fechaInicio La fecha de inicio a consultar
     * @param <Date> $fechaFin La fecha de fin a cosultar
     * @return <recurso> las ventas realizadas por una sucursal en el intervalo indicado
     */
    function consultarVentasSucursal($idSucursal,$fechaInicio,$fechaFin){
        $recurso = $this->controlBD->consultarVentasSucursal($idSucursal, $fechaInicio, $fechaFin);
        return $recurso;
    }
}
?>
