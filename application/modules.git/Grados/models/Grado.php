<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Grado extends CI_Model{
	public function buscarGradosFuerza($idFuerza){
		$sql = "SELECT grado.id AS idGrado, grado.orden AS ordenGrado, grado.nombre AS nombreGrado, grado.abreviatura AS abreviaturaGrado FROM grado WHERE grado.fuerza_id = ".$idFuerza." ORDER BY ordenGrado ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function insertarRegistro($data){
		$this->db->insert("grado", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idGrado, $data){
		$this->db->where("id", $idGrado);
		$this->db->update("grado", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idGrado){
		$sql = "SELECT grado.id AS idGrado, grado.orden AS ordenGrado, grado.nombre AS nombreGrado, grado.abreviatura AS abreviaturaGrado FROM grado WHERE grado.id = ".$idGrado;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idGrado){
		$this->db->where('id', $idGrado);
		$this->db->delete('grado');
		return $this->db->affected_rows();
	}

}	