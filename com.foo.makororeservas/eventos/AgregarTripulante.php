<?php
?>
<form name="form1" method="post" action="">
  <table cellpadding="2" cellspacing="1">
    <tr class="titulo">
      <td colspan="2">Agregar/Editar Tripulante</td>
    </tr>
    <tr class="r1">
      <td>Cedula</td>
      <td><label>
        <input type="text" name="cedula" id="cedula" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Nombre</td>
      <td><label>
        <input type="text" name="nombre" id="nombre" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Apellido</td>
      <td><label>
        <input type="text" name="apellido" id="apellido" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Sexo</td>
      <td><p>
        <label>
          <input type="radio" name="sexo" value="radio" id="sexo_0">
          Masculino</label>
        <br>
        <label>
          <input type="radio" name="sexo" value="radio" id="sexo_1">
          Femenino</label>
      </td>
    </tr>
    <tr class="r1">
      <td>Telefono</td>
      <td><label>
        <input type="text" name="telefono" id="telefono" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Estado de residencia</td>
      <td><label>
        <input type="text" name="estado" id="estado" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Ciudad de residencia</td>
      <td><label>
        <input type="text" name="ciudad" id="ciudad" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td>Direccion de residencia</td>
      <td><label>
        <textarea name="direccion" id="direccion" cols="23" rows="3"></textarea>
      </label></td>
    </tr>
    <tr class="r1">
      <td>Cargo</td>
      <td><label>
        <select name="cargo" id="cargo">
        </select>
      </label></td>
    </tr>
    <tr class="r0">
      <td>Sueldo</td>
      <td><label>
        <input type="text" name="sueldo" id="sueldo" size="30">
      </label></td>
    </tr>
    <tr class="r1">
      <td>Habilitado</td>
      <td><label>
        <input type="checkbox" name="habilitado" id="habilitado" size="30">
      </label></td>
    </tr>
    <tr class="r0">
      <td height="26" colspan="2"><label>
          <div align="center">
            <input type="submit" name="button" id="button" value="Submit">
              </div>
      </label></td>
    </tr>
  </table>
</form>
