<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TipoMantenimiento extends CI_Model{
	
	public function buscarTiposMantenimientos(){
		$sql = "SELECT tipo_mantenimiento.id AS idTipoMantenimiento, tipo_mantenimiento.nombre AS nombreTipoMantenimiento FROM tipo_mantenimiento ORDER BY nombreTipoMantenimiento ASC";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function insertarRegistro($data){
		$this->db->insert("tipo_mantenimiento", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idTipoMantenimiento, $data){
		$this->db->where("id", $idTipoMantenimiento);
		$this->db->update("tipo_mantenimiento", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idTipoMantenimiento){
		$sql = "SELECT tipo_mantenimiento.id AS idTipoMantenimiento, tipo_mantenimiento.nombre AS nombreTipoMantenimiento FROM tipo_mantenimiento WHERE id = ".$idTipoMantenimiento;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idTipoMantenimiento){
		$this->db->where('id', $idTipoMantenimiento);
		$this->db->delete('tipo_mantenimiento');
		return $this->db->affected_rows();
	}
	
}