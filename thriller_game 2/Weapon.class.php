<?php

require_once('Bullet.class.php');

class Weapon
{
    protected $length = 5;

    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }
    
    public function shoot($pos_x, $pos_y, $angle, $game)
    {
        $length = $this->length;
        while ($length > 0)
        {
            if ($angle === 0)
                $pos_x++;
            if ($angle === 1)
                $pos_y++;
            if ($angle === 2)
                $pos_x--;
            if ($angle === 3)
                $pos_y--;
            $bullet = new Bullet($pos_x, $pos_y);
            if ($game->add_bullet($bullet))
                return true;
            $length--;
        }
        return false;
    }
}

?>