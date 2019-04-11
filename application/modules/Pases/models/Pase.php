<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pase extends CI_Model{
	
	public function buscarPaseActivoUsuario($idUsuario){
		$sql = "SELECT pase.id AS idPase, pase.cae_id AS idCae, pase.estado AS estadoPase FROM pase INNER JOIN personal ON pase.personal_id = personal.id INNER JOIN usuario ON usuario.personal_id = personal.id WHERE pase.estado = 'A' AND usuario.id = ".$idUsuario." GROUP BY pase.id";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("pase", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idPase, $data){
		$this->db->where("id", $idPase);
		$this->db->update("pase", $data);
		return $this->db->affected_rows();
	}

	public function editarEstadoPasePersonal($idPersonal, $data){
		$this->db->where("personal_id", $idPersonal);
		$this->db->update("pase", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idPase){
		$sql = "SELECT pase.id AS idPase, pase.cae_id AS idCaeDestino, pase.cae_origen_id as idCaeOrigen, pase.personal_id AS idPersonalPase, pase.fecha_presentacion AS fechaPresentacionPase, pase.fecha_salida AS fechaSalidaPase, pase.estado AS estadoPase FROM pase WHERE pase.id = ".$idPase;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idPase){
		$this->db->where('id', $idPase);
		$this->db->delete('pase');
		return $this->db->affected_rows();
	}

	public function buscarPasePersonal($idPersonal){
		$sql = "SELECT pase.id AS idPase, pase.cae_id AS idCaeDestino, CASE WHEN pase.cae_id > 0 THEN (SELECT cae.nombre FROM cae WHERE cae.id = pase.cae_id) END AS caeDestino, pase.cae_origen_id as idCaeOrigen, CASE WHEN pase.cae_origen_id > 0 THEN (SELECT cae.nombre FROM cae WHERE cae.id = pase.cae_origen_id) END AS caeOrigen, pase.fecha_presentacion AS fechaPresentacionPase, pase.fecha_salida AS fechaSalidaPase, pase.estado AS estadoPase FROM pase WHERE pase.personal_id = ".$idPersonal." ORDER BY fechaPresentacionPase DESC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}
}