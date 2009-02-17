<?php

/**
 * Description of VueloPersonalclass
 *
 * @author Diana Uribe
 */
class VueloPersonalclass {
    private $vueloId;
    private $personalCedula;
    private $cargo;

    public function getVueloId() {
        return $this->vueloId;
    }

    public function setVueloId($vueloId) {
        if (is_numeric($vueloId)) {
            $this->vueloId = $vueloId;
        }
    }

    public function getPersonalCedula() {
        return $this->personalCedula;
    }

    public function setPersonalCedula($personalCedula) {
        if (is_numeric($personalCedula)) {
            $this->personalCedula = $personalCedula;
        }
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function setCargo($cargo) {
        if (is_numeric($cargo)) {
            $this->cargo = $cargo;
        }
    }
}
?>
