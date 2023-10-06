<?php
function db()
{
	static $conn;
	if ($conn == NULL) {
		$conn = mysqli_connect('localhost', 'root', '', 'learning');
	}
	if (!$conn) {
		die("Could not connect to database: " . mysqli_connect_error());
	}
	return $conn;
}
