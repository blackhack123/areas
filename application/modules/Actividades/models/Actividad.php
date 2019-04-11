<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Actividad extends CI_Model{
	
	public function buscarParametrosParte(){

		$sql = "SELECT actividad.hora_desde AS horaDesdeActividad, actividad.duracion AS duracionActividad, actividad.accion AS accionActividad FROM actividad WHERE actividad.nombre = 'PARTE' GROUP BY actividad.id"; 
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("actividad", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idActividad, $data){
		$this->db->where("id", $idActividad);
		$this->db->update("actividad", $data);
		return $this->db->affected_rows();
	}

	public function eliminarRegistro($idActividad){
		$this->db->where('id', $idActividad);
		$this->db->delete('actividad');
		return $this->db->affected_rows();
	}
}