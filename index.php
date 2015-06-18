<?php

require 'db.php';
require 'Slim/Slim.php';

// $host = "localhost";
// $user = "root";
// $password ="arthur";
// $dbName = "move_your_body";
// $connection = new PDO("mysql:host=localhost;dbname=move_your_body", $user, $password);

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/login/:login/:password', function($login, $password){
	login($login, $password);
});

$app->run();


function login($login, $password){
	$connection = getDB();
	$query = 'SELECT * FROM user WHERE username = "' . $login .'" AND password = "' . $password . '"';
	$statement = $connection->query($query);
	$result = $statement->fetchAll(PDO::FETCH_CLASS);
	if(count($result) === 1){
		echo json_encode(array("status" => "success"));
	}else{
		echo json_encode(array("status" => "fail"));
	}
	$connection = null;
}