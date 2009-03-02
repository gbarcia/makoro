<?php
session_start();
if (!(session_is_registered('EncargadoValido')) && !(session_is_registered('EncargadoTipo'))){
    die ('No puede entrar');
}
else {
    if ($_SESSION['EncargadoValido'] == true){
        print $_SESSION['EncargadoTipo'] .'<p></p>';
        print $_SESSION['EncargadoLogin'].'<p></p>' ;
        print $_SESSION['EncargadoCedula'] .'<p></p>';
        print $_SESSION['EncargadoMail'] .'<p></p>';
        print $_SESSION['EncargadoSucursal'] .'<p></p>';
        print $_SESSION['FechaActual'] .'<p></p>';
        print $_SESSION['EncargadoValido'] .'<p></p>';
    }
    else {
        die ('No puede entrar NO');
    }
}
?>
