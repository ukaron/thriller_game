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
        $this->data["ships"]['badass_mess'] = new Ship(5, 5, "#00FF00");
        $this->data["ships"]['anarchy_son'] = new Ship(7, 7, "#00F0F0");

        $ship = new Ship(105, 5, "#FF0000");
        $ship->rotate(2);
        $this->data["ships"][] = $ship;
        
        $ship = new Ship(105, 14, "#FF6600");
        $ship->rotate(2);
        $this->data["ships"][] = $ship;
    }
    
    public function handle_events($post)
    {
        $ship_name = $post['name'];
        if ($post["new_game"] === "NEW GAME")
        {
            $this->create_new_game();
        }
        else if ($post["rotate"] === "Rotate")
        {
            $this->data["ships"][$ship_name]->rotate(1);
        }  
        else if ($post["submit"] === "go")
        {
            $this->data["ships"][$ship_name]->move();
        }
    }

    public function show_map($post)
    {
        $map = new Map();
        if ($post["shoot"] == "shoot")
            $this->data["ships"][$post['name']]->shoot($map);
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

<form action="index.php" method="POST" class="choose_ship">
    <input type="radio" name="name" value="anarchy_son" checked> anarchy_son<br>
	<input type="submit" name="new_game" value="NEW GAME"/>
	<input type="submit" name="submit" value="go"/>
    <input type="submit" name="rotate" value="Rotate"/> <br>
    <input type="submit" name="shoot" value="shoot"/>
</form>

<form action="index.php" method="POST" class="choose_ship">
    <input type="radio" name="name" value="badass_mess" checked> badass_mess<br>
	<input type="submit" name="new_game" value="NEW GAME"/>
	<input type="submit" name="submit" value="go"/>
	<input type="submit" name="rotate" value="Rotate"/> <br>
    <input type="submit" name="shoot" value="shoot"/>
</form>

<?php
    }

}

?>