<?php

Class ConnectionDao {
	public function getConnection(){
		$servername = "db102";
		$port = "3306";
		$db = "wiring_calculation";
		$username = "root";
		$password = "1234";

		$conn = new mysqli($servername, $username, $password, $db, $port);

		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		} else {
			return $conn;
		}
	}
}


?>
