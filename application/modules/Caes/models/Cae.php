<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cae extends CI_Model{
	
	public function buscarCaes(){
		$sql = "SELECT cae.id AS idCae, cae.nombre AS nombreCae FROM cae ORDER BY nombreCae ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("cae", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idCae, $data){
		$this->db->where("id", $idCae);
		$this->db->update("cae", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idCae){
		$sql = "SELECT cae.id AS idCae, cae.nombre AS nombreCae FROM cae WHERE id=".$idCae;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idCae){
		$this->db->where('id', $idCae);
		$this->db->delete('cae');
		return $this->db->affected_rows();
	}
}