<?php
session_start();

function salirDelSistema() {
    $objResponse = new xajaxResponse();
    $_SESSION = array();
    session_destroy();
    $objResponse->addRedirect('../index.php');
    return $objResponse;
}
?>
