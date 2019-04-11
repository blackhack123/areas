<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcion extends CI_Model{
	
	public function buscarFunciones(){
		$sql = "SELECT funcion.id AS idFuncion, funcion.nombre AS nombreFuncion FROM funcion ORDER BY nombreFuncion ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("funcion", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idFuncion, $data){
		$this->db->where("id", $idFuncion);
		$this->db->update("funcion", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idFuncion){
		$sql = "SELECT funcion.id AS idFuncion, funcion.nombre AS nombreFuncion FROM funcion WHERE id = ".$idFuncion;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idFuncion){
		$this->db->where('id', $idFuncion);
		$this->db->delete('funcion');
		return $this->db->affected_rows();
	}
}