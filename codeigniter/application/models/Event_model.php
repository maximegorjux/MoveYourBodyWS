<?php

class Event_model extends CI_Model{

	const KILOMETER_VALUE = 6371;

	public function __construct(){
		$this->load->database();
	}

	public function getSports(){
		$query = $this->db->query('SELECT * FROM sport');
		return $query->result();
	}

	public function create($title, $description, $date, $latitude, $longitude, $sport){
		$query = 'INSERT INTO event (title, description, date_event, latitude, longitude, sport) VALUES 
		("' . $title . '", "' . $description . '", "' . $date . '", ' . $latitude . ', ' . $longitude . ', "' . $sport . '")';
		$this->db->query($query);
		if($this->db->affected_rows()){
			return json_encode(array("status" => "success"));
		}else{
			return json_encode(array("status" => "fail"));
		}
	}

	public function delete($idEvent){
		$query = 'DELETE FROM event WHERE id = ' . $idEvent;
		$this->db->query($query);
		if($this->db->affected_rows()){
			return json_encode(array("status" => "success"));
		}else{
			return json_encode(array("status" => "fail"));
		}
	}

	public function getEventsNearFrom($latitude, $longitude, $distance){
		$query = $this->db->query('SELECT * FROM event');
		$data = $query->result();
		$result = array();
		foreach ($data as $event) {
			$deltaLat = $this->mydeg2rad($event->latitude() - $latitude);
			$deltaLong = $this->mydeg2rad($event->longitude() - $longitude);

			$radius = 6371;

			$a = sin($deltaLat/2) * sin($deltaLat/2) +
			cos($this->mydeg2rad($latitude)) * cos($this->mydeg2rad($longitude)) *
			sin($deltaLong/2) * sin($deltaLong/2);

			$c =  2 * atan2(sqrt(a), sqrt(1-a));
			$d = $radius * $c;
			$d = ceil($d);

			if($d <= $distance){
				$result[] = $event;
			}
		}
		return json_encode($result);
	}

	public function joinEvent($idEvent, $idUser){
		$query = 'INSERT INTO join (idEvent, idUser) VALUES (' . $idEvent . ', ' . $idUser . ')';
		$this->db->query($query);
		if($this->db->affected_rows()){
			return json_encode(array("status" => "success"));
		}else{
			return json_encode(array("status" => "fail"));
		}
	}

	public function getEventsForUser($idUser){
		$query = $this->db->query('SELECT * FROM join WHERE idUser = ' . $idUser);
		return json_encode($query->result());
	}

	private function mydeg2rad($deg) {
  		return $deg * (pi()/180);
	}
}