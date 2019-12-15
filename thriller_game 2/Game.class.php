<?php

require_once('Block.class.php');
require_once('Canvas.class.php');
require_once('HonorableDuty.class.php');
require_once('SwordOfAbsolution.class.php');
require_once('ImperatorDeus.class.php');

class Game
{
    const MAX_X = 150;
    const MAX_Y = 100;
    
    private $_filename;

    private $_current = 0;
    private $_number = 0;
    private $_blocks = [];
    private $_ships = [];
    private $_bullets = [];
    private $_step = 0;

    public static function doc()
    {
        return file_get_contents(get_called_class().'.doc.txt');
    }

    public function __construct($filename)
    {
        $this->_filename = $filename;
        $this->load();
    }

    public function load()
    {
        if (file_exists($this->_filename))
        {
            $data = unserialize(file_get_contents($this->_filename));
            $this->_current = $data["_current"];
            $this->_number = $data["_number"];
            $this->_blocks = $data["_blocks"];
            $this->_bullets = $data["_bullets"];
            $this->_ships = $data["_ships"];
            $this->_step  = $data["_step"];
        }
        else
            $this->_create_new_game();
    }

    public function save()
    {
        $data = array(            
            "_current" => $this->_current,
            "_number" => $this->_number,
            "_blocks" => $this->_blocks,
            "_bullets" => $this->_bullets,
            "_ships" => $this->_ships,
            "_step" => $this->_step,
        );
        file_put_contents($this->_filename, serialize($data));
    }
        
    private function _add_ship()
    {
        $pos_x = rand(5, self::MAX_X / 3);
        $pos_y = rand(5, self::MAX_Y - 5);
        if ($this->_current == 0)
            $this->_ships[0][] = new HonorableDuty($pos_x, $pos_y, 0, "#0f0");
        else
            $this->_ships[1][] = new HonorableDuty(self::MAX_X - $pos_x, $pos_y, 2, "#00f");
    }
    
    private function _add_blocks($count)
    {
        while ($count-- > 0)
            $this->_blocks[] = new Block(rand(0, self::MAX_X), rand(0, self::MAX_Y));
    }

    private function _create_new_game()
    {
        $this->_current = 0;
        $this->_number = 0;
        $this->_blocks = array();
        $this->_ships = array();        

        // Create random blocks
        $this->_add_blocks(20);

        // Create ship Player0
        $this->_ships[0][] = new HonorableDuty(10, 10, 0, "#0f0");
        $this->_ships[0][] = new SwordOfAbsolution(6, 60, 0, "#0f0");
        $this->_ships[0][] = new HonorableDuty(30, 10, 0, "#0f0");

        // Create ship Player1
        $this->_ships[1][] = new HonorableDuty(140, 23, 2, "#00f");
        $this->_ships[1][] = new SwordOfAbsolution(130, 35, 2, "#00f");
        $this->_ships[1][] = new ImperatorDeus(142, 56, 2, "#00f");
        
        $this->_step = rand(1, 6);
    }

    private function _next_ship()
    {
        $this->_number = ($this->_number + 1) % count($this->_ships[$this->_current]);
    }

    private function _move()
    {
        if ($this->_step > 0)
        {
            $this->_bullets = [];
            $ship = $this->_ships[$this->_current][$this->_number];
            $ship->move();
            $this->_step--;
        }
    }
    
    private function _left()
    {
        if ($this->_step > 0)
        {
            $this->_bullets = [];
            $ship = $this->_ships[$this->_current][$this->_number];
            $ship->left();
            $this->_step--;
        }
    }
    
    private function _rigth()
    {
        if ($this->_step > 0)
        {
            $this->_bullets = [];
            $ship = $this->_ships[$this->_current][$this->_number];
            $ship->rigth();
            $this->_step--;
        }            
    }
    
    public function add_bullet($bullet)
    {
        foreach ($this->_ships as $ships)
        {
            foreach ($ships as $ship)
            {
                $res = $ship->check_bullet($bullet);
                if ($res)
                    return true;
            }
        }
        $area = $bullet->get_area();
        foreach ($this->_blocks as $block)
        {
            $res = $block->crash($area);
            if ($res)
                return true;
        }
        $this->_bullets[] = $bullet;
        return false;
    }

    private function _shoot()
    {
        if ($this->_step > 0)
        {
            $this->_bullets = [];
            $ship = $this->_ships[$this->_current][$this->_number];
            $ship->shoot($this);
            $this->_step--;
        }       
    }    

    private function _next_player()
    {
        $this->_current = ($this->_current + 1) % 2;
        $this->_number = 0;
        $this->_step = rand(1, 6);
    }

    private function _check_crash()
    {
        foreach ($this->_ships as $player => $ships)
        {
            foreach ($ships as $ship)
            {
                $ship->check_board(self::MAX_X, self::MAX_Y);
                $ship->check_blocks($this->_blocks);
                $ship->check_ships($this->_ships);
            }
        }
    }

    public function handle_events($post)
    {
        if ($post["new_game"] === "NEW GAME")
        {
            $this->_create_new_game();
        }
        else if ($post["add_ship"] === "ADD SHIP")
        {
            $this->_add_ship();
        }
        else if ($post["add_block"] === "ADD BLOCK")
        {
            $this->_add_blocks(10);
        }
        else if ($post["next_ship"] === "NEXT SHIP")
        {
            $this->_next_ship();
        }
        else if ($post["move"] === "MOVE")
        {            
            $this->_move();
        }
        else if ($post["left"] === "LEFT")
        {
            $this->_left();
        }
        else if ($post["rigth"] === "RIGTH")
        {
            $this->_rigth();
        }
        else if ($post["shoot"] === "SHOOT")
        {
            $this->_shoot();
        }        
        else if ($post["next_player"] === "NEXT PLAYER")
        {
            $this->_next_player();
        }
        else if ($post["cheat"] === "CHEAT")
        {
            $this->_step = 9999;
        }
        $this->_check_crash();
    }    

    public function show_board()
    {
        $canvas = new Canvas(self::MAX_X, self::MAX_Y);
        foreach ($this->_ships as $current => $ships)
        {
            foreach ($ships as $number => $ship)
            {
                $select = ($current == $this->_current and $number == $this->_number);
                $ship->put_on_canvas($canvas, $select);
            }
        }
        foreach ($this->_blocks as $block)
        {
            $block->put_on_canvas($canvas);
        }
        foreach ($this->_bullets as $bullet)
        {
            $bullet->put_on_canvas($canvas);
        }
        $canvas->show();
    }

    public function get_board()
    {
        $res = [];
        foreach ($this->_ships as $current => $ships)
        {
            foreach ($ships as $number => $ship)
            {
                $res["ship"][] = array(
                    "ship_id" => $ship->getShipID(),
                    "user_id" => $this->_current,
                    "type_id" => 0,
                    "is_select" => ($current == $this->_current and $number == $this->_number),
                    "pos_x" => $ship->getPosX(),
                    "pos_y" => $ship->getPosY(),
                    "angle" => $ship->getAngle(),
                    "health" => $ship->getHealth(),
                );
            }
        }
        foreach ($this->_blocks as $block)
        {
            $res["blocks"][] = array(
                "block_id" => $block->getBlockID(),
                "pos_x" => $block->getPosX(),
                "pos_y" => $block->getPosY(),
            );
        }
        foreach ($this->_bullets as $bullet)
        {
            $res["bullets"][] = array(
                "bullet_id" => $bullet->getBulletID(),
                "pos_x" => $bullet->getPosX(),
                "pos_y" => $bullet->getPosY(),
            );
        }
        return ($res);
    }

    public function show_controler()
    {
?>
<div>Player: <?php echo $this->_current + 1 ?></div>
<div>Step: <?php echo $this->_step ?></div>

<div class="controler">
    <form action="index.php" method="POST">
        <input type="submit" name="new_game" value="NEW GAME"/>
        <input type="submit" name="add_ship" value="ADD SHIP"/>
        <input type="submit" name="add_block" value="ADD BLOCK"/>
        <input type="submit" name="next_player" value="NEXT PLAYER"/>        
        <input type="submit" name="next_ship" value="NEXT SHIP"/>
        <input type="submit" name="cheat" value="CHEAT"/>
        <input type="submit" name="move" value="MOVE"/>
        <input type="submit" name="left" value="LEFT"/>
        <input type="submit" name="rigth" value="RIGTH"/>        
        <input type="submit" name="shoot" value="SHOOT"/>
    </form>
</div>

<?php

    }
}

?>
