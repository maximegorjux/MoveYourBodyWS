<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Event extends REST_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('event_model');
	}

	public function getSports_get(){
		$data = $this->event_model->getSports();
		$return = array();
		foreach ($data as $sport) {
			$return[] = $sport->label;
		}
		if(!empty($return)){
			$this->response(array('result' => $return), 200);
		}else{
			$this->response(array('result' => 'No sports in database'));
		}
	}

	public function create_post(){
		$title = $this->post('title');
		$description = $this->post('description');
		$date = $this->post('date');
		$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$sport = $this->post('sport');

		// TODO : ajouter l'auteur de l'événement dans la table join ???

		$idUser = $this->post('idUser');
		
		if($title && $description && $date && $latitude && $longitude && $sport && $idUser){
			$data = $this->event_model->create($title, $description, $date, $latitude, $longitude, $sport, $idUser);
			$this->response($data, 200);
		}else{
			$this->response(NULL, 400);
		}
	}

	public function join_post(){
		$idEvent = $this->post('idEvent');
		$idUser = $this->post('idUser');
		if($idEvent && $idUser){
			$data = $this->event_model->joinEvent($idEvent, $idUser);
			$this->response($data, 200);
		}else{
			$this->response(NULL, 400);
		}
		
	}

	public function getEventsNearFrom_get(){
		$latitude = $this->get('latitude');
		$longitude = $this->get('longitude');
		$distance = $this->get('distance');
		if($latitude && $longitude && $distance){
			$data = $this->event_model->getEventsNearFrom($latitude, $longitude, $distance);
			$this->response($data, 200);
		}else{
			$this->response(NULL, 400);
		}
		
	}

	public function getEventsForUser_get(){
		$idUser = $this->get('idUser');
		if($idUser){
			$data = $this->event_model->getEventsForUser($idUser);
			$this->response($data, 200);
		}else{
			$this->response(NULL, 400);
		}
		
	}

}