$(document).ready(function(){
	$(".forward").click(move_forward);
	$(".down").click(move_down);
	$(".up").click(move_up);
	$("#place_new").click(place_new);
	$("#punch").click(reduce_health);
});

//setInterval(parse_json, 3000);

function parse_json() {
	$.ajax({
		url: './new_ship.php',
		type: 'post',
		data: {'name': 'Diver', 'top': '10', 'left': '1000'},
		success: function(data) { update_game(JSON.parse(data)); console.log(response); }
	});
}

function update_game(game_data) {
	var ships_array = game_data.info;
	for (i = 0; i++; i < ships_array.lenght) {
		update_ship(ships_array[i]);
	}
}

function update_ship(ship_item) {
	$("#" + ship_item.name).css({"left": (ship_item.x*10) + 'px', "top": (ship_item.y*10) + 'px'});
}

function place_new () {
	$("#board").append("<img src=\"./imgs/2.0.png\" alt=\"Diver\" id=\"Diver\" class=\"ships\">");
	$("#Diver").css({"position": "absolute", "left": "1000px", "top": "10px"});
	$.ajax({
		url: './new_ship.php',
		type: 'post',
		data: {'name': 'Diver', 'top': '10', 'left': '1000'},
		success: function(response) { console.log(response); }
	});
}

function reduce_health() {
	$.ajax({
		url: './moves.php',
		type: 'post',
		data: {'punch': '1'},
		success: function(data) { cut_health(data); console.log(data); }
	});
}

function cut_health(data) {
	data = data.split(":");
	$(data[0] + " .health" + " #h_line").css({"width": (data[1] + "%")})
}

function move_forward() {
	$.ajax({
		url: './moves.php',
		type: 'post',
		data: {'move': 'forward'},
		success: function(data) { ship_move(data); console.log(data); }
	});
}

function move_down() {
	$.ajax({
		url: './moves.php',
		type: 'post',
		data: {'move': 'down'},
		success: function(data) { ship_move(data); console.log(data); }
	});
}

function move_up() {
	$.ajax({
		url: './moves.php',
		type: 'post',
		data: {'move': 'up'},
		success: function(data) { ship_move(data); console.log(data); }
	});
}

function ship_move(coords) {
	coords = coords.split(':');
	$(coords[0]).animate({
		top: coords[1],
		left: coords[2]
	});
}