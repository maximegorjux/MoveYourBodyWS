<?php
function getDB(){
	$host = "localhost";
	$user = "root";
	$password ="arthur";
	$dbName = "move_your_body";
	$connection = new PDO("mysql:host=localhost;dbname=move_your_body", $user, $password);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $connection;
}
	//$connection->beginTransaction();
?>