<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class User extends REST_Controller {

	public function __construct(){
        parent::__construct();

        $this->load->model('user_model');
    }

	public function login_get(){
		$login = $this->get('login');
		$password = $this->get('password');
		if($login && $password){
			$data = $this->user_model->connect($login, $password);
			if($data){
				$this->response(array('status' => 'success', 'id' => $data['id']), 200);
			}else{
				$this->response(array('status' => 'fail'), 200);
			}
		}else{
			$this->response(NULL,400);
		}
	}

	public function signup_post(){
		$login = $this->post('login');
		$password = $this->post('password');
		$mail = $this->post('mail');
		$name = $this->post('name');
		$options = [
		    'cost' => 12,
		];
		$password = password_hash($password, PASSWORD_BCRYPT, $options);
		if($login && $password && $mail && $name){
			$data = $this->user_model->signup($login, $password, $mail, $name);
			$this->response($data, 200);
		}else{
			$this->response(NULL, 400);
		}
	}
}
