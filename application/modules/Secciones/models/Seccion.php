<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Seccion extends CI_Model{
	public function buscarSeccionesEstacion($idEstacion){
		$sql = "SELECT seccion.id AS idSeccion, seccion.nombre AS nombreSeccion FROM seccion WHERE seccion.estacion_id = ".$idEstacion." ORDER BY nombreSeccion ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function insertarRegistro($data){
		$this->db->insert("seccion", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idSeccion, $data){
		$this->db->where("id", $idSeccion);
		$this->db->update("seccion", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idSeccion){
		$sql = "SELECT seccion.id AS idSeccion, seccion.nombre AS nombreSeccion FROM seccion WHERE seccion.id = ".$idSeccion;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idSeccion){
		$this->db->where('id', $idSeccion);
		$this->db->delete('seccion');
		return $this->db->affected_rows();
	}

}	