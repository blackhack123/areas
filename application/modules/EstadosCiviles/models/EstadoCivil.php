<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class EstadoCivil extends CI_Model{
	
	public function buscarEstadosCiviles(){
		$sql = "SELECT estado_civil.id AS idEstadoCivil, estado_civil.nombre AS nombreEstadoCivil FROM estado_civil";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("estado_civil", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idEstadoCivil, $data){
		$this->db->where("id", $idEstadoCivil);
		$this->db->update("estado_civil", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idEstadoCivil){
		$sql = "SELECT estado_civil.id AS idEstadoCivil, estado_civil.nombre AS nombreEstadoCivil FROM estado_civil WHERE id = ".$idEstadoCivil;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idEstadoCivil){
		$this->db->where('id', $idEstadoCivil);
		$this->db->delete('estado_civil');
		return $this->db->affected_rows();
	}
}