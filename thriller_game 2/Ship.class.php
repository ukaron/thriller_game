<?php

require_once('Weapon.class.php');

abstract class Ship
{
    private   $_ship_id;
    protected $pos_x;
    protected $pos_y;
    protected $angle;
    protected $color;
    protected $alive = true;
    protected $size_x = 1;
    protected $size_y = 1;
    protected $waepon;

    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }

    public function __construct($pos_x, $pos_y, $angle, $color)
    {
        $this->_ship_id = uniqid();
        $this->pos_x = $pos_x;
        $this->pos_y = $pos_y;
        $this->angle = $angle;
        $this->color = $color;
        $this->waepon = new Weapon();
    }

    public function getShipID()
    {
        return ($this->_ship_id);
    }

    public function getPosX()
    {
        return ($this->pos_x);
    }

    public function getPosY()
    {
        return ($this->pos_y);
    }

    public function getHealth()
    {
        if ($this->alive)
            return (100);
        return (0);
    }
    
    public function getAngle()
    {
        return ($this->angle);
    }

    public function put_on_canvas($canvas, $select)
    {
        if ($this->angle == 1)
            $char = 'v';
        else if ($this->angle == 2)
            $char = '<';
        else if ($this->angle == 3)
            $char = '^';
        else
            $char = '>';
        $pos_y = min([0, $this->size_y]);
        while ($pos_y < max([0, $this->size_y]))
        {
            $pos_x = min([0, $this->size_x]);
            while ($pos_x < max([0, $this->size_x]))
            {
                if ($this->alive)
                {
                    if ($select)
                        $canvas->put($this->pos_x + $pos_x, $this->pos_y + $pos_y, $char, "#fff");
                    else
                        $canvas->put($this->pos_x + $pos_x, $this->pos_y + $pos_y, $char, $this->color);
                }
                else
                    $canvas->put($this->pos_x + $pos_x, $this->pos_y + $pos_y, "*", "#800");
                $pos_x++;
            }
            $pos_y++;
        }
    }
    
    public function get_area()
    {
        return array(
            "pos_x0" => min($this->pos_x, $this->pos_x + $this->size_x + ($this->size_x < 0 ? 1 : -1)),
            "pos_x1" => max($this->pos_x, $this->pos_x + $this->size_x + ($this->size_x < 0 ? 1 : -1)),
            "pos_y0" => min($this->pos_y, $this->pos_y + $this->size_y + ($this->size_y < 0 ? 1 : -1)),
            "pos_y1" => max($this->pos_y, $this->pos_y + $this->size_y + ($this->size_y < 0 ? 1 : -1)),
        );
    }
    
    public function check_board($max_x, $max_y)
    {
        if ($this->alive)
        {
            $area = $this->get_area();
            if ($area["pos_x0"] < 0 or $area["pos_y0"] < 0 or $area["pos_x1"] >= $max_x or $area["pos_y1"] >= $max_y)
                $this->destroy();
        }
    }
    
    public function check_blocks($blocks)
    {
        if ($this->alive)
        {
            $area = $this->get_area();
            foreach ($blocks as $block)
            {
                if ($block->crash($area))
                {
                    $this->destroy();
                    return ;
                }
            }
        }
    }
    
    private function _check($pos_x, $pos_y)
    {
        return (
            $area["pos_x0"] <= $pos_x and
            $area["pos_y0"] <= $pos_y and
            $area["pos_x1"] >= $pos_x and
            $area["pos_y1"] >= $pos_y
        );
    }

    public function check_ships($p_ships)
    {
        $area = $this->get_area();
        if ($this->alive)
        {
            foreach ($p_ships as $ships)
            {
                foreach ($ships as $ship)
                {
                    if ($ship !== $this)
                    {
                        $ares2 = $ship->get_area();
                        $res = (
                            $area["pos_x0"] <= $ares2["pos_x0"] and
                            $area["pos_y0"] <= $ares2["pos_y0"] and
                            $area["pos_x1"] >= $ares2["pos_x0"] and
                            $area["pos_y1"] >= $ares2["pos_y0"]
                        ) or (
                            $area["pos_x0"] <= $ares2["pos_x1"] and
                            $area["pos_y0"] <= $ares2["pos_y1"] and
                            $area["pos_x1"] >= $ares2["pos_x1"] and
                            $area["pos_y1"] >= $ares2["pos_y1"]
                        );
                        if ($res)
                        {
                            $this->destroy();
                            $ship->destroy();
                        }
                    }
                }
            }
        }
    }

    public function check_bullet($bullet)
    {
        if ($this->alive)
        {
            $area = $this->get_area();
            if ($bullet->crash($area))
            {
                $this->destroy();
                return true;
            }
        }
        return false;
    }

    public function destroy()
    {
        $this->alive = false;
    }

    public function move()
    {
        if ($this->alive)
        {
            if ($this->angle % 2 == 0)
                $this->pos_x += 1 - $this->angle % 4;
            else
                $this->pos_y += 2 - $this->angle % 4;
        }
    }
    
    public function left()
    {
        if ($this->alive)
        {
            $this->angle = ($this->angle + 3) % 4;
            $temp = $this->size_y;
            $this->size_y = $this->size_x;
            $this->size_x = $temp;
        }
    }

    public function rigth()
    {
        if ($this->alive)
        {
            $this->angle = ($this->angle + 1) % 4;
            $temp = $this->size_x;
            $this->size_x = $this->size_y;
            $this->size_y = $temp;
        }
    }

    public function shoot($game)
    {
        if ($this->alive)
        {
            if ($this->waepon)
            {
                if ($this->angle == 0)
                    $this->waepon->shoot($this->pos_x + $this->size_x, $this->pos_y, $this->angle, $game);
                else
                    $this->waepon->shoot($this->pos_x, $this->pos_y, $this->angle, $game);
            }
        }
    }

}

?>