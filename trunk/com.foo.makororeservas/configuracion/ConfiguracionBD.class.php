<?php
/**
 * Description of ConfiguracionBDclass
 * Clase para la configuración de los datos de la base de datos
 * @author gerardobarcia
 */
class ConfiguracionBDclass {

    private $databaseURL = "";
    private $databaseUserName = "";
    private $databasePWord = "";
    private $databaseName = "";

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
