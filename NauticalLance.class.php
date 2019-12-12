<?php

require_once('Weapons.class.php');

class NauticalLance extends Weapons {
    public function __construct() {
        parent::__construct();
        $this->_name            = "Nautical lance";
        $this->_charges         = 0;
        $this->_short_range     = [1, 30];
        $this->_middle_range    = [31, 60];
        $this->_long_range      = [61, 90];
    }
}

?>
