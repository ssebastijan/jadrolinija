<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "jadrolinija";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
?>
