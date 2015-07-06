<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	 public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }

	public function login($login, $password){
		$data = $this->user_model->connect($login, $password);
		if($data){
			echo json_encode(array('status' => 'success'));
		}else{
			echo json_encode(array('status' => 'fail'));
		}
	}

	public function signup($login, $password, $mail, $name){
		$data = $this->user_model->signup($login, $password, $mail, $name);
		echo $data;
	}
}
