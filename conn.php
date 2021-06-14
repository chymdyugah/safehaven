<?php
	$host = "localhost";
	$username = "id12226527_safe";
	$password = "LTM4Ot>3CrI!&D{j";
	$database = "id12226527_safehaven";
	
	$conn = new mysqli($host,$username,$password,$database);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>