<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/serviciotecnico/persistencia/controladorPasajeroBD.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/com.foo.makororeservas/dominio/Pasajero.class.php';


function mostrarFormulario ($datos) {
    $objResponse = new xajaxResponse();
    $respuesta = "";
    $controlBD = new controladorPasajeroBDclass();
    $recurso = $controlBD->consultarPasajeroPorId($datos[cedulaPas]);
    $cantidad = mysql_num_rows($recurso);
    if ($cantidad <= 0) {
        $respuesta = "No existen coincidencias con sus busqueda";
    }
    else {
        $row = mysql_fetch_array($recurso);
        $respuesta = '<form id="formNuevoCliente">
        <input type="hidden" name="id" value="'.$row[id].'" />
  <table class="formTable" cellspacing="0">
    <tr>
        <thead>
        <td colspan="2">
        <div class="tituloBlanco1">
            EDITAR INFORMACION PASAJERO
            <div class="botonCerrar">
            <button name="boton" type="button" onclick="xajax_cerrarVentana()" style="margin:0px; background-color:transparent; border:none;"><img src="iconos/cerrar.png" alt="x"/></button>
        </div>
        </div>
        </td>
        </thead>
    </tr>
    <tr class="r1">
      <td colspan="2">(*) Cedula o pasaporte son campos requeridos</td>
      </tr>
    <tr class="r1">
      <td>* Cedula</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" value="'.$row[cedula].'"size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r0">
      <td>* Pasaporte</td>
      <td><label>
        <input type="text" name="pasaporte" id="pasporte" value="'.$row[pasaporte].'"  size="30" onkeyup="this.value=this.value.toUpperCase();" />
      </label></td>
    </tr>
    <tr class="r1">
      <td> Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" value="'.$row[nombre].'" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r0">
      <td> Apellido</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" value="'.$row[apellido].'" onkeyup="this.value=this.value.toUpperCase();" size="30" />
      </label></td>
    </tr>
    <tr class="r1">
      <td> Nacionalidad</td>
      <td><input type="text" name="nacionalidad" id="nacionalidad" value="'.$row[nacionalidad].'" onkeyup="this.value=this.value.toUpperCase();" size="30" /></td>
    </tr>
    <tr class="r0">
      <td>Categoria Edad</td>
      <td><select name="tipo">
          <option value="ADL">ADL</option>
          <option value="CHD">CHD</option>
          <option value="INF">INF</option>
           </select></td>
      </tr>
    <tr class="r1">
      <td height="26" colspan="2"><div align="center">
        <input name="button" type="button" id="button" value="GUARDAR" onclick= "xajax_procesarPas(xajax.getFormValues(\'formNuevoCliente\'))" />
      </div></td>
    </tr>
  </table>    <label></label></td>
    </tr>
</table>
</form>';
    }
    $objResponse->addAssign("gestion", "innerHTML", "$respuesta");
    return $objResponse;
}

function validarPas ($datos) {
    if ($datos[cedula] == "" && $datos[pasaporte] == "")
    return false;
    else
    return true;
}

function procesarPas ($datos) {
    $objResponse = new xajaxResponse();
    $mensaje = "";
    if (validarPas($datos)) {
        $control = new controladorPasajeroBDclass();
        $pasajeroEditar = new Pasajeroclass();
        $pasajeroEditar->setApellido($datos[apellido]);
        $pasajeroEditar->setCedula($datos[cedula]);
        $pasajeroEditar->setId($datos[id]);
        $pasajeroEditar->setNacionalidad($datos[nacionalidad]);
        $pasajeroEditar->setNombre($datos[nombre]);
        $pasajeroEditar->setPasaporte($datos[pasaporte]);
        $pasajeroEditar->setSexo('M');
        $pasajeroEditar->setTipoPasajeroId($datos[tipo]);
        $resultado = $control->editarPasajero($pasajeroEditar);
        if ($resultado)
        $mensaje = '<div class="exito">
                          <div class="textoMensaje">
                          Pasajero '.$datos[cedula]. ' actualizado con exito.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
        else
        $mensaje = '<div class="error">
                          <div class="textoMensaje">
                          No se pudo realizar la operacion. Verifique el manual de ayuda.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    else {
        $mensaje = '<div class="advertencia">
                          <div class="textoMensaje">
                          Debe especifica un numero de cedula o pasaporte.
                          </div>
                          <div class="botonCerrar">
                            <input type="image" src="iconos/cerrar.png" alt="x" onclick="xajax_borrarMensaje()">
                          </div>
                          </div>';
    }
    $objResponse->addAssign("Mensaje", "innerHTML", "$mensaje");
    return $objResponse;
}

function borrarMensaje(){
    $respuesta = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("Mensaje", "innerHTML", $respuesta);
    return $objResponse;
}

function cerrarVentana() {
    $resultado = "";
    $objResponse = new xajaxResponse();
    $objResponse->addAssign("gestion", "innerHTML", $resultado);
    $objResponse->addAssign("Mensaje", "innerHTML", $resultado);
    return $objResponse;
}
?>