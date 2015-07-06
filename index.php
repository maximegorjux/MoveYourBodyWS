<?php
ini_set('display_errors', 1);

require_once __DIR__.'/silex/vendor/autoload.php';

$app = new Silex\Application();

$app->get('/hello', function () {
    echo 'Hello!';
});

$app->run();

/*include_once 'Slim/Slim.php';
require 'User.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/login/:login/:password', function($login, $password){
	login($login, $password);
});

$app->get('/signup/', function() use($app){
 	//signup($login, $password, $email, $name);
 	$login = $app->request()->params('login');
 	echo $login;
});


// $app->get('/signup/:login', function($login){
// 	//signup($login, $password, $email, $name);
// 	echo $login;
// });
$app->run();


function login($login, $password){
	$return = User::connect($login, $password);
	echo $return;
}

function signup($login, $password, $email, $name){
	$return = User::signup($login, $password, $email, $name);
	echo $return;
}
?>

<form method="post" action="./index.php/signup">
<input type="text" name="login"/>
<input type="text" name="password"/>
<input type="text" name="mail"/>
<input type="text" name="name"/>
<input type="submit" value="ok" />
</form>*/