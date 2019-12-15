<?php

require_once('Ship.class.php');

class SwordOfAbsolution extends Ship
{

    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }

    public function __construct($pos_x, $pos_y, $angle, $color)
    {
        parent::__construct($pos_x, $pos_y, $angle, $color);
        $this->size_x = 3;
        $this->size_y = 1;
    }
   
}

?>