<?php

require 'db.php';
class User{
	private $login;
	private $password;
	private $mail;
	private $name;
	private $db;

	public function __construct($login, $password, $mail, $name){
		// instanciate db using db.php

		// insert in db
	}

	public static function connect($login, $password){
		// get DB
		$connection = getDB();
		$query = 'SELECT * FROM user WHERE username = "' . $login .'" AND password = "' . $password . '"';
		$statement = $connection->query($query);
		$result = $statement->fetchAll(PDO::FETCH_CLASS);
		if(count($result) === 1){
			return json_encode(array("status" => "success"));
		}else{
			return json_encode(array("status" => "fail"));
		}
	}
}