<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Fuerza extends CI_Model{
	
	public function buscarFuerzas(){
		$sql = "SELECT fuerza.id AS idFuerza, fuerza.nombre AS nombreFuerza, fuerza.logo AS logoFuerza FROM fuerza ORDER BY nombreFuerza ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("fuerza", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idFuerza, $data){
		$this->db->where("id", $idFuerza);
		$this->db->update("fuerza", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idFuerza){
		$sql = "SELECT fuerza.id AS idFuerza, fuerza.nombre AS nombreFuerza, fuerza.logo AS logoFuerza FROM fuerza WHERE id=".$idFuerza;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idFuerza){
		$this->db->where('id', $idFuerza);
		$this->db->delete('fuerza');
		return $this->db->affected_rows();
	}
}