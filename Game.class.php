<?php


require_once('Map.class.php');
require_once('Ship.class.php');



// $map = new Map();

// $game->data[[0]->put_on_map($map);
// $game->data[1]->put_on_map($map);

// $map->print_map();



// $ship = new Ship(5, 5, "#A0AF00");
// $ship->rotate(-2);
// $ship->put_on_map($map);

// $ship = new Ship(5, 5, "#008888");
// $ship->rotate(-3);
// $ship->put_on_map($map);


class Game {
    
    private $_filename;

    public $data = [];

    public function __construct($filename)
    {
        $this->_filename = $filename;
        if (file_exists($this->_filename))
            $this->data = unserialize(file_get_contents($this->_filename));
        else
            $this->create_new_game();
    }    

    public function save()
    {
        file_put_contents($this->_filename, serialize($this->data));
    }
    
    public function create_new_game()
    {
        $this->data = array();
        $this->data["ships"][] = new Ship(5, 5, "#00FF00");
        $this->data["ships"][] = new Ship(7, 7, "#00F0F0");

        $ship = new Ship(105, 5, "#FF0000");
        $ship->rotate(2);
        $this->data["ships"][] = $ship;
        
        $ship = new Ship(105, 14, "#FF6600");
        $ship->rotate(2);
        $this->data["ships"][] = $ship;
    }
    
    public function handle_events($post)
    {
        if ($post["new_game"] === "NEW GAME")
        {
            $this->create_new_game();
        }
        else if ($post["rotate"] === "Rotate")
        {
            $this->data["ships"][1]->rotate(1);
        }  
        else if ($post["submit"] === "OK")
        {
            $this->data["ships"][1]->move();
        }        
    }

    public function show_map()
    {
        $map = new Map();
        foreach ($this->data["ships"] as $ship)
        {
            $ship->put_on_map($map);
        }
        $map->print_map();        
    }

    public function show_controlers()
    {
?>

<div class="controler">
<form action="index.php" method="POST">
	<input type="submit" name="new_game" value="NEW GAME"/>
</form>

<form action="index.php" method="POST">
	<input type="submit" name="submit" value="OK"/>
</form>

<form action="index.php" method="POST">
	<input type="submit" name="rotate" value="Rotate"/>
</form>

<?php
    }

}

?>