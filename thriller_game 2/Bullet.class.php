<?php

class Bullet
{
    private   $_bullet_id;
    protected $pos_x;
    protected $pos_y;
    
    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }

    public function __construct($pos_x, $pos_y)
    {
        $this->_bullet_id = uniqid();
        $this->pos_x = $pos_x;
        $this->pos_y = $pos_y;
    }
    
    public function getBulletID()
    {
        return ($this->_bullet_id);
    }

    public function getPosX()
    {
        return ($this->pos_x);
    }

    public function getPosY()
    {
        return ($this->pos_y);
    }

    public function put_on_canvas($canvas)
    {
        $canvas->put($this->pos_x, $this->pos_y, ".", "#f88");
    }
    
    public function get_area()
    {
        return (array(
            "pos_x0" => $this->pos_x,
            "pos_x1" => $this->pos_x,
            "pos_y0" => $this->pos_y,
            "pos_y1" => $this->pos_y
        ));
    }

    public function crash($area)
    {
        return (
            $area["pos_x0"] <= $this->pos_x and
            $area["pos_y0"] <= $this->pos_y and
            $area["pos_x1"] >= $this->pos_x and
            $area["pos_y1"] >= $this->pos_y
        );
    }

}

?>