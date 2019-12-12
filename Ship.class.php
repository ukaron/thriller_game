<?php

class Ship {
    private $_name;
    private $_size;
    private $_hull_points;
    private $_pp;
    private $_speed;
    private $_handling;
    private $_shield;
    private $_weapons;
    
    private $_x;
    private $_y;
    private $_size_x;
    private $_size_y;
    private $_angle;
    private $_color;

    public function __construct($x, $y, $color) {
        $this->_x = $x;
        $this->_y = $y;
        $this->_size_x = 1;
        $this->_size_y = 4;
        $this->_angle = 0;
        $this->_color = $color;
    }

    public function put_on_map($map)
    {
        if ($this->_angle == 1)
            $ch = 'v';
        else if ($this->_angle == 2)
            $ch = '<';
        else if ($this->_angle == 3)
            $ch = '^';
        else
            $ch = '>';

        $y = min([0, $this->_size_y]);
        while ($y < max([0, $this->_size_y]))
        {
            $x = min([0, $this->_size_x]);
            while ($x < max([0, $this->_size_x]))
            {
                $map->put($this->_x + $x, $this->_y + $y, $ch, $this->_color);
                $x++;
            }
            $y++;
        }
    }

    public function shoot($map) {
        if ($this->_angle == 1) {
            for ($i = 1; $i < 50; $i++) {
                $map->put($this->_x - 2, $this->_y + $i, '|', "#FF0000");
            }
        }
        else if ($this->_angle == 2){
            for ($i = 1; $i < 50; $i++) {
                $map->put($this->_x - $i, $this->_y + 1, '-', "#FF0000");
            }
        }
        else if ($this->_angle == 3){
            for ($i = 1; $i < 50; $i++) {
                $map->put($this->_x - 2, $this->_y - $i, '|', "#FF0000");
            }
        }
        else {
            for ($i = 1; $i < 50; $i++) {
                $map->put($this->_x + $i, $this->_y + 1, '-', "#FF0000");
            }
        }
    }

    public function rotate($k)
    {
        $this->_angle = ($this->_angle + $k) % 4;
        while ($k != 0)
        {
            if ($k > 0)
            {
                $temp = -$this->_size_y;
                $this->_size_y = $this->_size_x;
                $this->_size_x = $temp;
                $k--;
            }
            else if ($k < 0)
            {
                $temp = $this->_size_y;
                $this->_size_y = -$this->_size_x;
                $this->_size_x = $temp;
                $k++;
            }
        }
    }
    public function move()
    {
        if ($this->_angle % 2 == 0)
            $this->_x += 1 - $this->_angle % 4;
        else if ($this->_angle % 2 == 1)
            $this->_y += 2 - $this->_angle % 4;
        if ($this->_x < 0 or $this->_x >= 150 or $this->_y < 0 or $this->_y >= 100)
            echo "false!".PHP_EOL;
    }
}

?>