<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/login/:login/:password', function($login, $password){
	login($login, $password);
});

$app->run();


function login($login, $password){
	
}