<?php
file_put_contents("./coords.csv", $_POST['name'].':'.$_POST['top'].':'.$_POST['left'].":100".PHP_EOL, FILE_APPEND);
?>