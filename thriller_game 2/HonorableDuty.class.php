<?php

require_once('Ship.class.php');
require_once('Laser.class.php');

class HonorableDuty extends Ship
{

    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }

    public function __construct($pos_x, $pos_y, $angle, $color)
    {
        parent::__construct($pos_x, $pos_y, $angle, $color);
        $this->size_x = 1;
        $this->size_y = 4;
        $this->waepon = new Laser();
    }
   
}

?>