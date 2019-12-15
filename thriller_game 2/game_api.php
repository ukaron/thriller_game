<?php

require_once('Game.class.php');


header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$res = [];
if ($_POST["command"])
{
    $game = new Game('save.game');
    
    if ($_POST["command"] == "board") 
    {
        $res = $game->get_board();
    }
}

echo json_encode($res);


?>