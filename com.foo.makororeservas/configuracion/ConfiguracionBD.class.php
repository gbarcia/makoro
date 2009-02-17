<?php
/**
 * Description of ConfiguracionBDclass
 * Clase para la configuración de los datos de la base de datos
 * @author gerardobarcia
 */
class ConfiguracionBDclass {

    private $databaseURL = "localhost";
    private $databaseUserName = "root";
    private $databasePWord = "admin";
    private $databaseName = "makoro";

    public function getDatabaseURL() {
        return $this->databaseURL;
    }

    public function getDatabaseUserName() {
        return $this->databaseUserName;
    }

    public function getDatabasePWord() {
        return $this->databasePWord;
    }

    public function getDatabaseName() {
        return $this->databaseName;
    }
}
?>
