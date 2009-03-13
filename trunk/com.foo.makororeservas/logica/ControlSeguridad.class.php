<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorSeguridadBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Encargado.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/utilidades/class.phpmailer.php';

/**
 * Description of ControlSeguridadclass
 * Clase para gestionar la seguridad del sistema
 * @author gerardobarcia
 */
class ControlSeguridadclass {

    private $controlPruebaSeguridad;

    function __construct() {
        $this->controlPruebaSeguridad = new controladorSeguridadBDclass();
    }
/**
 * Metodo para validar el acceso al sistema
 * Revisa los datos y de ser correctos asigna las respectivas variables de Session
 * @param <String> $login login del usuario
 * @param <String> $clave clave del usuario
 * @return <boolean> resultado de la operacion
 */
    public function validarSession ($login, $clave) {
        $resultado = false;
        $encargadoRecurso = $this->controlPruebaSeguridad->busquedaEncargadoPorLogin($login);
        $vacio = mysql_num_rows($encargadoRecurso);
        if ($vacio > 0) {
            $row = mysql_fetch_array($encargadoRecurso);
            if (md5($clave) == $row[password] && $row[habilitado] == 1) {
                $resultado = true;
                $_SESSION['EncargadoTipo'] = $row[tipo];
                $_SESSION['EncargadoLogin'] = $row[login];
                $_SESSION['EncargadoCedula'] = $row[cedula];
                $_SESSION['EncargadoMail'] = $row[correo];
                $_SESSION['EncargadoSucursal'] = $row[SUCURSAL_id];
                $_SESSION['EncargadoValido'] = TRUE;
            }
        }
        return $resultado;
    }
/**
 * Funcion para autogenerar una clave al azar
 * @return <String> la clave autogenerada
 */
    private function autoGenerarClave () {
        $variableNumerica    = rand(0000,9999);
        $arreglo             = array('A','B','C','D','E','F','G','H','I','J','K');
        $variableNumericaDos = rand(0,10);
        $clave              = $arreglo[$variableNumericaDos].$variableNumerica;
        return $clave;
    }
/**
 * Funciar para enviar un correo Electronico
 * @param <type> $correo direccion del correo a enviar
 */
    private function enviarMail($correo, $cuerpo)
    {
        $resultado = true;
        $mail = new PHPMailer();
        $mail->From = "soporte@makoroenlinea.com";
        $mail->FromName = "Sistema de Reservas Makoro";
        $mail->Subject    = "Registro en sistema de Reservas Makoro";
        $mail->MsgHTML($cuerpo);
        $mail->AddAddress($correo);
        if(!$mail->Send()) {
            print "mail no enviado";
            $resultado = false;
        }
        return $resultado;
    }
/**
 * Metodo para registrar un nuevo encargado en el sistema
 * @param <Encargado> $encargado objeto encargado a agregar
 * @param <String> $RepCorreo repeticion del correo del encargado
 * @return <boolean> resultado de la operacion
 */
    public function nuevoEncargado ($encargado, $RepCorreo) {
        $resultado = false;
        if ($encargado->getCorreo() == $RepCorreo) {
            $claveReal = $this->autoGenerarClave();
            $encargado->setClave(md5($claveReal));
            $resultado = $this->controlPruebaSeguridad->agregarEncargado($encargado);
            if ($resultado) {
                $cuerpo = "<font size='2' face='Arial'><P>Estimado: ". $encargado->getNombre(). "</P>";
                $cuerpo .= "<P>Lo siguiente, son los datos de acceso al Sistema:</P>";
                $cuerpo .= "Nombre de Usuario: ".$encargado->getNombre()." <br>";
                $cuerpo .= "Clave: ".$claveReal." <br>";
                $cuerpo .= "<P>La clave de Usuario es provisional y podrá ser cambiada una vez que ingrese al sistema. En caso de tener alguna consulta en referencia a ésta página por favor no dude en contactarnos.</P>";
                $cuerpo .= "Soporte@makoroenlinea.com";
                $resultadoAdministrador = $this->enviarMail('gerardobarciap@gmail.com', $cuerpo);
                if ($resultadoAdministrador)
                $resultado = $this->enviarMail($RepCorreo,$cuerpo);
            }
        }
        return $resultado;
    }
/**
 * Metodo para editar un encargado en el sistema
 * @param <Encargado> $encargado el objeto encargado a editar
 * @param <String> $nuevaClaveRep la repeticion de la nueva clave en caso de que se quiera modificar
 * @param <String> $claveVieja la clave anterior
 * @return <boolean> resultado de la operacion
 */
    public function editarEncargado ($encargado,$nuevaClaveRep,$claveVieja) {
        $resultado = false;
        if ($nuevaClaveRep != "" && $claveVieja != "") {
            $infoEncargado = $this->controlPruebaSeguridad->buscarEncargadoPorCedula($encargado->getCedula());
            if ($infoEncargado->getClave() == md5($claveVieja)) {
                if (md5($nuevaClaveRep) == $encargado->getClave()) {
                    $encargado->setClave(md5($nuevaClaveRep));
                    $resultado = $this->controlPruebaSeguridad->editarEncargado($encargado);
                    if ($resultado) {
                        $cuerpo = "<font size='2' face='Arial'><P>Estimado: ". $encargado->getNombre(). "</P>";
                        $cuerpo .= "<P>Lo siguiente, son los datos de acceso al Sistema:</P>";
                        $cuerpo .= "Nombre de Usuario: ".$encargado->getNombre()." <br>";
                        $cuerpo .= "Clave: ".$nuevaClaveRep." <br>";
                        $cuerpo .= "<P>La clave de Usuario es provisional y podrá ser cambiada una vez que ingrese al sistema. En caso de tener alguna consulta en referencia a ésta página por favor no dude en contactarnos.</P>";
                        $cuerpo .= "Soporte@makoroenlinea.com";
                        $resultado = $this->enviarMail($encargado->getCorreo(),$cuerpo);
                    }
                }
            }
        }
        else {
            $resultado = $this->controlPruebaSeguridad->editarEncargado($encargado);
        }
        return $resultado;
    }
}
?>
