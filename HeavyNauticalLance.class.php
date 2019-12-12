<?php

require_once('Weapons.class.php');

class HeavyNauticalLance extends Weapons {
    public function __construct() {
        parent::__construct();
        $this->_name            = "Heavy nautical lance";
        $this->_charges         = 3;
        $this->_short_range     = [1, 30];
        $this->_middle_range    = [31, 60];
        $this->_long_range      = [61, 90];
    }
}

?>
