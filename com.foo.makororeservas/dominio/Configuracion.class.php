<?php
/**
 * Description of Configuracionclass
 * Clase para manejar la informacion de la configuracion del sistema
 * @author jonathan
 */
class Configuracionclass {

    private $id;

    private $sueldoPiloto;

    private $sueldoCopiloto;

    private $sobrecargo;

    function __construct() {
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getSueldoPiloto() {
        return $this->sueldoPiloto;
    }

    public function setSueldoPiloto($sueldoPiloto) {
        if (is_numeric($sueldoPiloto))
        $this->sueldoPiloto = $sueldoPiloto;
    }

    public function getSueldoCopiloto() {
        return $this->sueldoCopiloto;
    }

    public function setSueldoCopiloto($sueldoCopiloto) {
        if (is_numeric($sueldoCopiloto))
        $this->sueldoCopiloto = $sueldoCopiloto;
    }

    public function getSobrecargo() {
        return $this->sobrecargo;
    }

    public function setSobrecargo($sobrecargo) {
        if (is_numeric($sobrecargo))
        $this->sobrecargo = $sobrecargo;
    }

}
?>
