<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Sector extends CI_Model{
	public function buscarSectoresCae($idCae){
		$sql = "SELECT sector.id AS idSector, sector.nombre AS nombreSector FROM sector WHERE sector.cae_id = ".$idCae." ORDER BY nombreSector ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	//Listar Sectores para Super Admin
	public function buscarSectores(){
		$sql = "SELECT sector.id as idSector, CONCAT(cae.nombre, ' - ', sector.nombre) as nombreSector FROM cae INNER JOIN sector ON sector.cae_id = cae.id ORDER BY cae.nombre ASC, sector.nombre ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}	
	}

	public function insertarRegistro($data){
		$this->db->insert("sector", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idSector, $data){
		$this->db->where("id", $idSector);
		$this->db->update("sector", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idSector){
		$sql = "SELECT sector.id AS idSector, sector.nombre AS nombreSector FROM Sector WHERE sector.id = ".$idSector;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idSector){
		$this->db->where('id', $idSector);
		$this->db->delete('sector');
		return $this->db->affected_rows();
	}

}	