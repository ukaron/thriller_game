
<!DOCTYPE html>
<html>
<head>
    <style>
.table {
	font-family: monospace;
	font-size: 9px;
	/* border: 1px solid black; */
	/* display: grid;
	grid-template-columns: repeat(50, 1fr);
	grid-template-rows: repeat(50, 1fr); */


}


/* .table__item {
	margin: 0.2vw;
	padding: 0.2vw;
	width: 1vw;
	height: 1vw;
	font-size: 1vw;
	border: 1px solid black;
	background-color: #e8e8e8;
} */

.table {
	display: inline-block;
}

.controler {
	display: inline-block;
}
.choose_ship {
        display: inline-block;
		margin: 15px;
		background-color: lightblue;
    }
</style>



</head>
<body>

<?php

require_once('Game.class.php');

$game = new Game("save.game");
$game->handle_events($_POST);
$game->show_map($_POST);
$game->show_controlers();
$game->save();

?>

</div>

</body>
</html>