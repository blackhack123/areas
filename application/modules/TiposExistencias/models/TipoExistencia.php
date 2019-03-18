<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class TipoExistencia extends CI_Model{
	public function buscarTiposExistenciasCae($idCae){
		$sql = "SELECT tipo_existencia.id AS idTipoExistencia, tipo_existencia.nombre AS nombreTipoExistencia, tipo_existencia.propiedad AS propiedadTipoExistencia FROM tipo_existencia WHERE tipo_existencia.cae_id = ".$idCae." ORDER BY nombreTipoExistencia ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function insertarRegistro($data){
		$this->db->insert("tipo_existencia", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idTipoExistencia, $data){
		$this->db->where("id", $idTipoExistencia);
		$this->db->update("tipo_existencia", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idTipoExistencia){
		$sql = "SELECT tipo_existencia.id AS idTipoExistencia, tipo_existencia.nombre AS nombreTipoExistencia, tipo_existencia.propiedad AS propiedadTipoExistencia FROM tipo_existencia WHERE tipo_existencia.id = ".$idTipoExistencia;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idTipoExistencia){
		$this->db->where('id', $idTipoExistencia);
		$this->db->delete('tipo_existencia');
		return $this->db->affected_rows();
	}

}	