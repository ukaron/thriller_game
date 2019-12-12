<?php

require_once('Weapons.class.php');

class SideLaserBatteries extends Weapons {
    public function __construct() {
        parent::__construct();
        $this->_name            = "Side laser batteries";
        $this->_charges         = 0;
        $this->_short_range     = [1, 10];
        $this->_middle_range    = [11, 20];
        $this->_long_range      = [21, 30];
    }
}

?>
