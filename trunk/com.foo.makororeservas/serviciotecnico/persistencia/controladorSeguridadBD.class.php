<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/TransaccionBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';

/**
 * Description of controladorSeguridadBDclass
 * Clase responsable de interactuar con la base de datos
 * @author gerardobarcia
 */
class controladorSeguridadBDclass {

    private $transaccion;

    /**
     * Constructor de la clase
     */
    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }

/**
 * Metodo para agregar un encargado en la base de datos
 * @param <Encargado> $encargado objeto en Encargado
 * @return <boolean> resultado de la operacion
 */
    function agregarEncargado($encargado) {
        $resultado = false;
        $query = "INSERT INTO ENCARGADO (cedula, nombre, apellido, sexo,
                                         fechaNacimiento, tipo, login, password,
                                         estado, ciudad, direccion, telefono,
                                         habilitado, SUCURSAL_id,correo)
                                          VALUES (" .$encargado->getCedula().",
                                                  '".$encargado->getNombre()."',
                                                  '".$encargado->getApellido()."',
                                                  '".$encargado->getSexo()."',
                                                  '".$encargado->getFechaNac()."',
                                                  '".$encargado->getTipo()."',
                                                  '".$encargado->getLogin()."',
                                                  '".$encargado->getClave()."',
                                                  '".$encargado->getEstado()."',
                                                  '".$encargado->getCiudad()."',
                                                  '".$encargado->getDireccion()."',
                                                  '".$encargado->getTelefono()."',
                                                   ".$encargado->getHabilitado().",
                                                   ".$encargado->getSucursalDondeTrabaja().",
                                                  '".$encargado->getCorreo()."')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para editar un encargado en la base de datos
 * @param <Encargado> $encargado objeto Encargado a editar
 * @return <boolean> resultado de la operacion
 */
    function editarEncargado ($encargado) {
        $resultado = false;
        $query = "UPDATE ENCARGADO SET nombre = '".$encargado->getNombre()."',
                                     apellido = '".$encargado->getApellido()."',
                                     tipo     = '".$encargado->getTipo()."',
                                     login    = '".$encargado->getLogin()."',
                                     password = '".$encargado->getClave()."',
                                     estado   = '".$encargado->getEstado()."',
                                     ciudad   = '".$encargado->getCiudad()."',
                                    direccion = '".$encargado->getDireccion()."',
                                    telefono  = '".$encargado->getTelefono()."',
                                  SUCURSAL_id =  ".$encargado->getSucursalDondeTrabaja().",
                                       correo = '".$encargado->getCorreo()."',
                                 WHERE cedula =  ".$encargado->getCedula()."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para buscar un encargado en especifico en la base de datos
 * @param <Integer> $cedula la cedula del encargado a buscar
 * @return <Encargado> Objeto Enecargado con la informacion
 */
    function buscarEncargadoPorCedula ($cedula) {
        $encargado = null;
        $query = "SELECT e.cedula, e.nombre, e.apellido, e.sexo, e.fechaNacimiento,e.correo
                         e.tipo, e.login, e.password clave, e.estado,e.ciudad, e.direccion,
                         e.telefono,e.habilitado,s.nombre nSucursal, s.id idSucursal
                         FROM ENCARGADO e, SUCURSAL s
                         WHERE e.SUCURSAL_id = s.id
                         AND e.cedula = ".$cedula."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        $valido = mysql_num_rows($resultado);
        if ($valido > 0 ) {
            $row = mysql_fetch_array($resultado);
            $encargado = new Encargadoclass();
            $encargado->setApellido($row[apellido]);
            $encargado->setCedula($row[cedula]);
            $encargado->setCiudad($row[ciudad]);
            $encargado->setClave($row[clave]);
            $encargado->setDireccion($row[direccion]);
            $encargado->setEstado($row[estado]);
            $encargado->setFechaNac($row[fechaNacimiento]);
            $encargado->setHabilitado($row[habilitado]);
            $encargado->setLogin($row[login]);
            $encargado->setNombre($row[nombre]);
            $encargado->setSexo($row[sexo]);
            $encargado->setSucursalDondeTrabaja($row[idSucursal]);
            $encargado->setSucursalDondeTrabajaString($row[nSucursal]);
            $encargado->setTelefono($row[telefono]);
            $encargado->setTipo($row[tipo]);
        }
        return $encargado;
    }
/**
 * Metodo para obtener todos los empleados registrados en el sistema
 * @return <Recurso> recurso sql con la respuesta
 */
    function traerTodosLosEncargados () {
        $resultado = false;
        $query = "SELECT e.cedula, e.nombre, e.apellido, e.sexo, e.fechaNacimiento,e.correo
                         e.tipo, e.login, e.password clave, e.estado,e.ciudad,
                         e.direccion,e.telefono,e.habilitado,s.nombre nSucursal, s.id idSucursal
                         FROM ENCARGADO e, SUCURSAL s
                         WHERE e.SUCURSAL_id = s.id
                         GROUP BY e.cedula, s.id
                         ORDER BY e.apellido,e.nombre,s.id";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para buscar encargados en el sistema deacuerdo al motor de busqueda
 * @param <String> $busqueda la busqueda por cedula, nombre o apellido
 * @return <recurso> recurso mysql con el resultado de la busqueda
 */
    function busquedaEncargadoAutoSugerir($busqueda) {
        $resultado = false;
        $query = "SELECT e.cedula, e.nombre, e.apellido, e.sexo, e.fechaNacimiento,e.correo
                         e.tipo, e.login, e.password clave, e.estado,e.ciudad, e.direccion,
                         e.telefono,e.habilitado,s.nombre nSucursal, s.id idSucursal
                         FROM ENCARGADO e, SUCURSAL s
                         WHERE e.SUCURSAL_id = s.id
                         AND (e.nombre LIKE '".$busqueda."%' OR e.apellido LIKE '".$busqueda."%'
                         OR e.cedula LIKE '".$busqueda."%')";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }

/**
 * Metodo para inhabilitar un encargado en el sistema
 * @param <Integer> $cedula la cedula de la persona a borrar
 * @return <boolean> resultado de la operacion
 */
    function borrarEncargado ($cedula) {
        $resultado = false;
        $query = "UPDATE ENCARGADO SET habilitado = 0 WHERE cedula = ".$cedula."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
/**
 * Metodo para habilitar un encargado en el sistema
 * @param <Integer> $cedula la cedula del persona a habilitar
 * @return <boolean> resultado de la operacion
 */
    function rehabilitarEncargado ($cedula) {
        $resultado = false;
        $query = "UPDATE ENCARGADO SET habilitado = 1 WHERE cedula = ".$cedula."";
        $resultado = $this->transaccion->realizarTransaccion($query);
        return $resultado;
    }
}
?>
