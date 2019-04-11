<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class TipoFuerza extends CI_Model{
	public function buscarTipoFuerza(){
		$sql = "SELECT tipo_fuerza.id AS idTipoFuerza, tipo_fuerza.nombre AS nombreTipoFuerza FROM tipo_fuerza ORDER BY idTipoFuerza ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function insertarRegistro($data){
		$this->db->insert("tipo_fuerza", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idTipoFuerza, $data){
		$this->db->where("id", $idTipoFuerza);
		$this->db->update("tipo_fuerza", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idTipoFuerza){
		$sql = "".$idTipoFuerza;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idTipoFuerza){
		$this->db->where('id', $idTipoFuerza);
		$this->db->delete('tipo_fuerza');
		return $this->db->affected_rows();
	}

}	