<?php

require_once('ImperialFrigate.class.php');
require_once('SideLaserBatteries.class.php');

class HonorableDuty extends ImperialFrigate {
    public function __construct() {
        parent::__construct();
        $this->_name        = "Honorable Duty";
        $this->_size        = [1, 4];
        $this->_hull_points = 5;
        $this->_pp          = 10;
        $this->_speed       = 15;
        $this->_handling    = 4;
        $this->_shield      = 0;
        $this->_weapons     = new SideLaserBatteries();
    }   
}

?>