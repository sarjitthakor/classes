<?php
	session_start();
		
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db="classes";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password,$db);

	if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>