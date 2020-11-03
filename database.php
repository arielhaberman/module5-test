<?php

$mysqli = new mysqli('localhost', 'userphp', 'phppass', 'calendar');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
