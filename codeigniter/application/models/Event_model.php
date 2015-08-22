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

	public function create($title, $description, $date, $latitude, $longitude, $sport, $numberPeople, $idUser){
		$query = 'INSERT INTO event (title, description, date_event, latitude, longitude, sport, numberPeople, idUser) VALUES 
		("' . $title . '", "' . $description . '", "' . $date . '", ' . $latitude . ', ' . $longitude . ', "' . $sport . '", ' . $numberPeople . ', ' . $idUser . ')';
		$this->db->query($query);
		if($this->db->affected_rows()){
			$idEvent = $this->db->insert_id();
			return $this->joinEvent($idEvent, $idUser);
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
		$query = 'INSERT INTO `join` (idEvent, idUser) VALUES (' . $idEvent . ', ' . $idUser . ')';
		$this->db->query($query);
		if($this->db->affected_rows()){
			return json_encode(array("status" => "success"));
		}else{
			return json_encode(array("status" => "fail"));
		}
	}

	public function getEventsForUser($idUser){
		$query = $this->db->query('SELECT idEvent FROM `join` WHERE idUser = "' . $idUser .'"');
		$data = array();
		foreach ($query->result() as $row){
			$event = $this->db->query('SELECT * FROM event WHERE id = ' . $row->idEvent . ' AND date_event >= NOW()');
			//var_dump($event);
			//die();
			//if($event->num_rows){
				$data[] = array(
					'id' => $event->result()[0]->id,
					'title' => $event->result()[0]->title,
					'description' => $event->result()[0]->description,
					'date' => $event->result()[0]->date_event,
					'latitude' => $event->result()[0]->latitude,
					'longitude' => $event->result()[0]->longitude,
					'sport' => $event->result()[0]->sport,
					'numberPeople' => $event->result()[0]->numberPeople,
					'idUser' => $event->result()[0]->idUser,
				);
			//}
		}
		if(!empty($data)){
			return array('status' => 'success', "result" => $data);
		}
		return array("status" => "fail");
	}

	private function mydeg2rad($deg) {
  		return $deg * (pi()/180);
	}
}