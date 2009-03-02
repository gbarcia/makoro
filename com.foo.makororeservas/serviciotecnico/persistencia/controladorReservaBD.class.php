<?php
/**
 * Description of controladorReservaBDclass
 * Clase para manejar las reservas en la base de datos
 * @author Diana Uribe
 */
class controladorReservaBDclass {
    private $transaccion;

    function __construct() {
        $this->transaccion = new TransaccionBDclass();
    }
}
?>
