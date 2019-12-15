<!DOCTYPE html>
<html>
<head>
	<title>Game</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>

<?php

require_once('Game.class.php');

$game = new Game('save.game');
$game->handle_events($_POST);
$game->show_board();
$game->show_controler();
$game->save();

?>

</body>
</html>