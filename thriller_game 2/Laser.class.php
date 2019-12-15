<?php

require_once('Weapon.class.php');

class Laser extends Weapon
{
    protected $length = 25;
    
    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }
   
}

?>