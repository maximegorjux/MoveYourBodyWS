<?php

class User_model extends CI_Model{
	private $login;
	private $password;
	private $mail;
	private $name;

	public function __construct(){
		$this->load->database();	
	}

	public function signup($login, $password, $mail, $name){

		if($this->db->get_where('user', array('username' => $login))->row_array()){
			return json_encode(array("status" => "username already exists"));
		}else{
			$query = 'INSERT INTO user (username, password, mail, name) 
			VALUES ("' . $login . '", "' . $password . '", "' . $mail . '", "' .$name . '")';
			$this->db->query($query);
			if($this->db->affected_rows()){
				return json_encode(array("status" => "success"));
			}else{
				return json_encode(array("status" => "fail"));
			}
		}
	}

	public function connect($login, $password){

		$query = $this->db->get_where('user', array('username' => $login, 'password' => $password));
		return $query->row_array();
	}
}