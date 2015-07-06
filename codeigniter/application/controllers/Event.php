<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('event_model');
	}

	public function getSports(){
		$data = $this->event_model->getSports();
		$return = array();
		foreach ($data as $sport) {
			$return[] = $sport->label;
		}
		var_dump($return);
	}

	public function create($title, $description, $date, $latitude, $longitude, $sport){
		$data = $this->event_model->create($title, $description, $date, $latitude, $longitude, $sport);
		echo $data;
	}

	public function join($idEvent, $idUser){
		$data = $this->event_model->joinEvent($idEvent, $idUser);
		echo $data;
	}

	public function getEventsNearFrom($latitude, $longitude, $distance){
		$data = $this->event_model->getEventsNearFrom($latitude, $longitude, $distance);
		echo $data;
	}

	public function getEventsForUser($idUser){
		$data = $this->event_model->getEventsForUser($idUser);
		echo $data;
	}

}