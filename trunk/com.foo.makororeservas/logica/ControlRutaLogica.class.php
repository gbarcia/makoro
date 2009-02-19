<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorRBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Ruta.class.php';

/**
 * Description of ControlRutaLogicaclass
 * Clase para el manejo de la logica de la gestion de las rutas
 * @author jonathan, maya
 */
class ControlRutaLogicaclass {
    private $controlBD;

    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->controlBD = new controladorRutaBDclass();
    }

    /**
     * Metodo para agregar una ruta al sistema
     * @param <string> $sitioSalida el sito de salida de la ruta
     * @param <string> $sitioLlegada el sitio de llegada de la ruta
     * @param <float> $tiempo el tiempo de duracion de la ruta
     * @param <string> $abreviaturaSalida la abreviatura del sitio de salida de la ruta
     * @param <string> $abreviaturaLlegada la abreviatura del sitio de llegada de la ruta
     * @param <boolean> $generaIVA determina si la ruta genera IVA
     * @return <boolean> resultado de la operacion
     */
    function nuevaRuta($sitioSalida, $sitioLlegada, $tiempo, $abreviaturaSalida, $abreviaturaLlegada, $generaIVA){
        $ruta = new Rutaclass();
        $ruta->setSitioSalida($sitioSalida);
        $ruta->setSitioLlegada($sitioLlegada);
        $ruta->setTiempo($tiempo);
        $ruta->setAbreviaturaSalida($abreviaturaSalida);
        $ruta->setAbreviaturaLlegada($abreviaturaLlegada);
        $resultado = $this->controlBD->agregarRuta($ruta);
        return $resultado;
    }

    /**
     * Metodo para actualizar una ruta del sistema
     * @param <string> $sitioSalida el sito de salida de la ruta
     * @param <string> $sitioLlegada el sitio de llegada de la ruta
     * @param <float> $tiempo el tiempo de duracion de la ruta
     * @param <string> $abreviaturaSalida la abreviatura del sitio de salida de la ruta
     * @param <string> $abreviaturaLlegada la abreviatura del sitio de llegada de la ruta
     * @param <boolean> $generaIVA determina si la ruta genera IVA
     * @return <boolean> resultado de la operacion
     */
    function actualizarRuta($sitioSalida, $sitioLlegada, $tiempo, $abreviaturaSalida, $abreviaturaLlegada, $generaIVA){
        $ruta = new Rutaclass();
        $ruta->setSitioSalida($sitioSalida);
        $ruta->setSitioLlegada($sitioLlegada);
        $ruta->setTiempo($tiempo);
        $ruta->setAbreviaturaSalida($abreviaturaSalida);
        $ruta->setAbreviaturaLlegada($abreviaturaLlegada);
        $resultado = $this->controlBD->editarRuta($ruta);
        return $resultado;
    }

    /**
     * Metodo que retorna todas las rutas del sistema
     * @return <coleccion> todas las rutas del sistema
     */
    function consultarTodasLasRutas(){
        $resultado = new ArrayObject();
        $recurso = $this->controlBD->consultarRutas();
        while($row = mysql_fetch_array($recurso)){
            $ruta = new Rutaclass();
            $ruta->setSitioSalida($row['sitioSalida']);
            $ruta->setSitioLlegada($row['sitioLlegada']);
            $ruta->setTiempo($row['tiempo']);
            $ruta->setAbreviaturaSalida($row['abreviaturaSalida']);
            $ruta->setAbreviaturaLlegada($row['abreviaturaLlegada']);
            $ruta->setGeneraIVA($row['generaIVA']);

            $resultado->append($ruta);
        }
        return $resultado;
    }
}
?>
