<?php
	if (isset($_POST['move'])) {
		switch ($_POST['move']) {
			case ('forward'):
				if (file_exists("./coords.csv")) {
					$data = explode(PHP_EOL, file_get_contents("./coords.csv"));
					file_put_contents("./coords.csv", "");
					foreach ($data as $elem) {
						if (strpos($elem, "Firestorm") === 0) {
							$coords = explode(':', $elem);
							file_put_contents("./coords.csv", "Firestorm".':'.$coords[1].':'.($coords[2] + 10).':'.$coords[3].PHP_EOL, FILE_APPEND);
							echo ("#Firestorm".':'.$coords[1].':'.($coords[2] + 10));
						}
						else
							file_put_contents("./coords.csv", $elem, FILE_APPEND);
					}
				}
				break;
			case ('down'):
				$data = explode(PHP_EOL, file_get_contents("./coords.csv"));
				file_put_contents("./coords.csv", "");
				foreach ($data as $elem) {
					if (strpos($elem, "Firestorm") === 0) {
						$coords = explode(':', $elem);
						file_put_contents("./coords.csv", "Firestorm".':'.($coords[1] + 10).':'.($coords[2]).':'.$coords[3].PHP_EOL, FILE_APPEND);
						echo ("#Firestorm".':'.($coords[1] + 10).':'.($coords[2]));
					}
					else
						file_put_contents("./coords.csv", $elem, FILE_APPEND);
				}
				break;
			case ('up'):
				$data = explode(PHP_EOL, file_get_contents("./coords.csv"));
				file_put_contents("./coords.csv", "");
				foreach ($data as $elem) {
					if (strpos($elem, "Firestorm") === 0) {
						$coords = explode(':', $elem);
						file_put_contents("./coords.csv", "Firestorm".':'.($coords[1] - 10).':'.($coords[2]).':'.$coords[3].PHP_EOL, FILE_APPEND);
						echo ("#Firestorm".':'.($coords[1] - 10).':'.($coords[2]));
					}
					else
						file_put_contents("./coords.csv", $elem, FILE_APPEND);
				}
				break;
		}
	}
	else if (isset($_POST['punch'])) {
		$data = explode(PHP_EOL, file_get_contents("./coords.csv"));
		file_put_contents("./coords.csv", "");
		foreach ($data as $elem) {
			if (strpos($elem, "Firestorm") === 0) {
				$coords = explode(':', $elem);
				file_put_contents("./coords.csv", "Firestorm".':'.($coords[1]).':'.($coords[2]).':'.($coords[3] - 10).PHP_EOL, FILE_APPEND);
				echo ("#Firestorm".':'.($coords[3] - 10));
			}
			else
				file_put_contents("./coords.csv", $elem, FILE_APPEND);
		}
	}
	else
		echo '0';
?>