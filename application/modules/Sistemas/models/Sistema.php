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

	public function buscarSistemasEstacion($idEstacion){
		$sql = "SELECT sistema.id as idSistema, sistema.nombre as nombreSistema FROM estacion INNER JOIN seccion ON seccion.estacion_id = estacion.id INNER JOIN sistema ON sistema.seccion_id = seccion.id WHERE estacion.id = ".$idEstacion." ORDER BY sistema.nombre ASC";
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

	public function buscarSistemasSecciones(){
		$sql = "SELECT sistema.id AS idSistema, CONCAT(seccion.nombre,' - ',sistema.nombre) as nombreSistema FROM seccion INNER JOIN sistema ON sistema.seccion_id = seccion.id ORDER BY seccion.nombre ASC, sistema.nombre ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

}	