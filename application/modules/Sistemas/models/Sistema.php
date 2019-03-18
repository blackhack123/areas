<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Sistema extends CI_Model{
	public function buscarSistemasSeccion($idSeccion){
		$sql = "SELECT sistema.id AS idSistema, sistema.nombre AS nombreSistema FROM sistema WHERE sistema.seccion_id = ".$idSeccion." ORDER BY nombreSistema ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function insertarRegistro($data){
		$this->db->insert("sistema", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idSistema, $data){
		$this->db->where("id", $idSistema);
		$this->db->update("sistema", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idSistema){
		$sql = "SELECT sistema.id AS idSistema, sistema.nombre AS nombreSistema FROM sistema WHERE sistema.id = ".$idSistema;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idSistema){
		$this->db->where('id', $idSistema);
		$this->db->delete('sistema');
		return $this->db->affected_rows();
	}

}	