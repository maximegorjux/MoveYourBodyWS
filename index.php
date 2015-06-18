<?php
ini_set('display_errors', 1);

require 'Slim/Slim.php';
require 'User.php';

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
	$return = User::connect($login, $password);
	echo $return;
}